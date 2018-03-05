#!/bin/bash

cd "$(dirname "$0")"

while [ -z "$UPPER_THEME_NAME" ] ; do
         echo ""
         read -p "New Theme Name: " UPPER_THEME_NAME
         if [ -z "$UPPER_THEME_NAME" ] ; then
            echo "Name Can't Be Blank." 
            unset UPPER_THEME_NAME
         fi
done

read -p "Description: " DESCRIPTION

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

mkdir -p ./temp_hold/Documentation
cp -r ./wordpress/wp-content/themes/stencil ./wordpress/wp-content/themes/stencil-child  ./wordpress/wp-content/plugins/stencil_extensions ./temp_hold
cp -r ./Documentation/stencil ./temp_hold/Documentation
cd ./temp_hold


UPPER_THEME_NAME_UNDERSCORE=$(echo ${UPPER_THEME_NAME// /_})
LOWER_THEME_NAME_UNDERSCORE=$(echo ${LOWER_THEME_NAME// /_})

grep -r -l "stencil" . | xargs sed -i "" "s/stencil/${LOWER_THEME_NAME_UNDERSCORE}/g"
grep -r -l "Stencil" . | xargs sed -i "" "s/Stencil/${UPPER_THEME_NAME_UNDERSCORE}/g"

grep -r -l "Theme Name: ${UPPER_THEME_NAME_UNDERSCORE}" ./stencil | xargs sed -i "" "s/Theme Name: ${UPPER_THEME_NAME_UNDERSCORE}/Theme Name: ${UPPER_THEME_NAME}/g"
grep -r -l "Plugin Name: ${UPPER_THEME_NAME_UNDERSCORE} Extensions" ./stencil_extensions | xargs sed -i "" "s/Plugin Name: ${UPPER_THEME_NAME_UNDERSCORE} Extensions/Plugin Name: ${UPPER_THEME_NAME} Extensions/g"

grep -r -l "Description: This plugin is developed to enhance the capabilities of the ${UPPER_THEME_NAME_UNDERSCORE} WordPress Theme." ./stencil_extensions | xargs sed -i "" "s/Description: This plugin is developed to enhance the capabilities of the ${UPPER_THEME_NAME_UNDERSCORE} WordPress Theme./Description: This plugin is developed to enhance the capabilities of the ${UPPER_THEME_NAME} WordPress Theme./g"

if ! [ -z "$DESCRIPTION" ]; then
    grep -r -l "Description: The Stencil Theme Was Created With The Purpose Of Rapid Theme Development." ./stencil | xargs sed -i "" "s/Description: The Stencil Theme Was Created With The Purpose Of Rapid Theme Development./Description: ${DESCRIPTION}/g"
else
    grep -r -l "Description: The ${UPPER_THEME_NAME_UNDERSCORE} Theme Was Created With The Purpose Of Rapid Theme Development." ./stencil | xargs sed -i "" "s/Description: The ${UPPER_THEME_NAME_UNDERSCORE} Theme Was Created With The Purpose Of Rapid Theme Development./Description: The ${UPPER_THEME_NAME} Theme Was Created With The Purpose Of Rapid Theme Development./g"
fi

for i in {1..3}
do
  find . -name \* -print | sed -e "p;s/stencil/${LOWER_THEME_NAME_UNDERSCORE}/" | xargs -n2 mv
done


mv $LOWER_THEME_NAME_UNDERSCORE ../wordpress/wp-content/themes/
mv "${LOWER_THEME_NAME_UNDERSCORE}-child" ../wordpress/wp-content/themes/
mv "${LOWER_THEME_NAME_UNDERSCORE}_extensions" ../wordpress/wp-content/plugins/
mv "./Documentation/${LOWER_THEME_NAME_UNDERSCORE}" ../Documentation
cd ..
rm -rf temp_hold

echo ""
echo ""
echo "The ${UPPER_THEME_NAME} Theme Has Been Created."