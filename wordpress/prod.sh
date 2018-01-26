#!/bin/bash

cd "$(dirname "$0")"

if [ ! -d "./themes" ]; then
    mkdir "./themes"
fi

while [ -z "$UPPER_THEME_NAME" ] ; do
         echo ""
         read -p "Theme Name For Production (Capitalize first letter): " UPPER_THEME_NAME
         if [ -z "$UPPER_THEME_NAME" ] ; then
            echo "Name Can't Be Blank." 
            unset UPPER_THEME_NAME
         fi
done

LOWER_THEME_NAME=""

lc(){
    case "$1" in
        [A-Z])
        n=$(printf "%d" "'$1")
        n=$((n+32))
        LOWER_THEME_NAME="$LOWER_THEME_NAME$(printf \\$(printf "%o" "$n"))"
        ;;
        *)
        LOWER_THEME_NAME="$LOWER_THEME_NAME$(printf "%s" "$1")"
        ;;
    esac
}
for((i=0;i<${#UPPER_THEME_NAME};i++))
do
    ch="${UPPER_THEME_NAME:$i:1}"
    lc "$ch"
done

UPPER_THEME_NAME_UNDERSCORE=$(echo ${UPPER_THEME_NAME// /_})
LOWER_THEME_NAME_UNDERSCORE=$(echo ${LOWER_THEME_NAME// /_})

if [  -d "./themes/${LOWER_THEME_NAME_UNDERSCORE}" ]; then
    rm -rf "./themes/${LOWER_THEME_NAME_UNDERSCORE}"
fi
mkdir "./themes/${LOWER_THEME_NAME_UNDERSCORE}"

cp -r ./Documentation "./themes/${LOWER_THEME_NAME_UNDERSCORE}"

cd "./themes/${LOWER_THEME_NAME_UNDERSCORE}/Documentation"

grep -r -l "stencil" . | xargs sed -i "" "s/stencil/${LOWER_THEME_NAME_UNDERSCORE}/g"
grep -r -l "Stencil" . | xargs sed -i "" "s/Stencil/${UPPER_THEME_NAME_UNDERSCORE}/g"

cd ../../..

cp -r ./Licensing "./themes/${LOWER_THEME_NAME_UNDERSCORE}/"

cd wordpress/wp-content/plugins/
zip -r "${LOWER_THEME_NAME_UNDERSCORE}_extensions.zip" "./${LOWER_THEME_NAME_UNDERSCORE}_extensions"

mv "${LOWER_THEME_NAME_UNDERSCORE}_extensions.zip" "../themes/${LOWER_THEME_NAME_UNDERSCORE}/lib/plugins/"
cd ../themes
zip -r "${LOWER_THEME_NAME_UNDERSCORE}.zip"  "${LOWER_THEME_NAME_UNDERSCORE}/"

rm "${LOWER_THEME_NAME_UNDERSCORE}/lib/plugins/${LOWER_THEME_NAME_UNDERSCORE}_extensions.zip"

mv "${LOWER_THEME_NAME_UNDERSCORE}.zip" "../../../themes/${LOWER_THEME_NAME_UNDERSCORE}/"

if [ -d "${LOWER_THEME_NAME_UNDERSCORE}-child" ]; then
    zip -r "${LOWER_THEME_NAME_UNDERSCORE}-child.zip"  "${LOWER_THEME_NAME_UNDERSCORE}-child/"
    mv "${LOWER_THEME_NAME_UNDERSCORE}-child.zip" "../../../themes/${LOWER_THEME_NAME_UNDERSCORE}/"
fi