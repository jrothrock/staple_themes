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

cd ./wordpress/wp-content

UPPER_THEME_NAME_UNDERSCORE=$(echo ${UPPER_THEME_NAME// /_})
LOWER_THEME_NAME_UNDERSCORE=$(echo ${LOWER_THEME_NAME// /_})

grep -r -l "stencil" . | xargs sed -i "" "s/stencil/${LOWER_THEME_NAME_UNDERSCORE}/g"
grep -r -l "Stencil" . | xargs sed -i "" "s/Stencil/${UPPER_THEME_NAME_UNDERSCORE}/g"

grep -r -l "Theme Name: ${UPPER_THEME_NAME_UNDERSCORE}" ./themes | xargs sed -i "" "s/Theme Name: ${UPPER_THEME_NAME_UNDERSCORE}/Theme Name: ${UPPER_THEME_NAME}/g"
grep -r -l "Plugin Name: ${UPPER_THEME_NAME_UNDERSCORE} Extensions" ./plugins | xargs sed -i "" "s/Plugin Name: ${UPPER_THEME_NAME_UNDERSCORE} Extensions/Plugin Name: ${UPPER_THEME_NAME} Extensions/g"

grep -r -l "Description: This plugin is developed to enhance the capabilities of the ${UPPER_THEME_NAME_UNDERSCORE} WordPress Theme." ./plugins | xargs sed -i "" "s/Description: This plugin is developed to enhance the capabilities of the ${UPPER_THEME_NAME_UNDERSCORE} WordPress Theme./Description: This plugin is developed to enhance the capabilities of the ${UPPER_THEME_NAME} WordPress Theme./g"


for i in {1..3}
do
  find . -name \* -print | sed -e "p;s/stencil/${LOWER_THEME_NAME_UNDERSCORE}/" | xargs -n2 mv
done

echo ""
echo ""
echo "Name and internal references have been changed."