#!/bin/bash

cd "$(dirname "$0")"

while [ -z "$UPPER_THEME_NAME" ] ; do
         echo ""
         read -p "Documentation Theme Name: " UPPER_THEME_NAME
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

cd ./Documentation
cp -r ./stencil "./${LOWER_THEME_NAME_UNDERSCORE}"
cd "./${LOWER_THEME_NAME_UNDERSCORE}"

grep -r -l "stencil" . | xargs sed -i "" "s/stencil/${LOWER_THEME_NAME_UNDERSCORE}/g"
grep -r -l "Stencil" . | xargs sed -i "" "s/Stencil/${UPPER_THEME_NAME_UNDERSCORE}/g"

for i in {1..3}
do
  find . -name \* -print | sed -e "p;s/stencil/${LOWER_THEME_NAME_UNDERSCORE}/" | xargs -n2 mv
done

echo ""
echo ""
echo "The ${UPPER_THEME_NAME} Documentation Has Been Created."