#!/bin/bash


cd "$(dirname "$0")"

lc_old(){
    case "$1" in
        [A-Z])
        n=$(printf "%d" "'$1")
        n=$((n+32))
        OLD_LOWER_THEME_NAME="$OLD_LOWER_THEME_NAME$(printf \\$(printf "%o" "$n"))"
        ;;
        *)
        OLD_LOWER_THEME_NAME="$OLD_LOWER_THEME_NAME$(printf "%s" "$1")"
        ;;
    esac
}


while [ -z "$OLD_THEME_NAME" ] ; do
         echo ""
         read -p "Current Theme Name: " OLD_THEME_NAME
         if [ -z "$OLD_THEME_NAME" ] ; then
            echo "Name Can't Be Blank." 
            unset OLD_THEME_NAME
         elif [ "$OLD_THEME_NAME" == "stencil"] || [ "$OLD_THEME_NAME" == "Stencil"] ; then
            echo "This Theme Is Used For Generating New Themes. Name Can't Be Changed."
            unset OLD_THEME_NAME
         fi
         for((i=0;i<${#OLD_THEME_NAME};i++))
         do
            ch="${OLD_THEME_NAME:$i:1}"
            lc_old "$ch"
         done
         OLD_LOWER_THEME_NAME_UNDERSCORE=$(echo ${OLD_LOWER_THEME_NAME// /_})
         if [ ! -d "./wordpress/wp-content/themes/$OLD_LOWER_THEME_NAME_UNDERSCORE" ]; then
            echo "Theme wasn't found, are you sure that's the right name?"
            unset OLD_THEME_NAME
         fi
done

while [ -z "$NEW_THEME_NAME" ] ; do
         echo ""
         read -p "New Theme Name: " NEW_THEME_NAME
         if [ -z "$NEW_THEME_NAME" ] ; then
            echo "Name Can't Be Blank." 
            unset NEW_THEME_NAME
         fi
done

lc_new(){
    case "$1" in
        [A-Z])
        n=$(printf "%d" "'$1")
        n=$((n+32))
        NEW_LOWER_THEME_NAME="$NEW_LOWER_THEME_NAME$(printf \\$(printf "%o" "$n"))"
        ;;
        *)
        NEW_LOWER_THEME_NAME="$NEW_LOWER_THEME_NAME$(printf "%s" "$1")"
        ;;
    esac
}
for((i=0;i<${#NEW_THEME_NAME};i++))
do
    ch="${NEW_THEME_NAME:$i:1}"
    lc_new "$ch"
done

OLD_UPPER_THEME_NAME_UNDERSCORE=$(echo ${OLD_THEME_NAME// /_})

NEW_UPPER_THEME_NAME_UNDERSCORE=$(echo ${NEW_THEME_NAME// /_})
NEW_LOWER_THEME_NAME_UNDERSCORE=$(echo ${NEW_LOWER_THEME_NAME// /_})

cd "./Documentation"

if [  -d "./${OLD_LOWER_THEME_NAME_UNDERSCORE}" ]; then
    mkdir "${NEW_LOWER_THEME_NAME_UNDERSCORE}"
    cd "./${OLD_LOWER_THEME_NAME_UNDERSCORE}"

    grep -r -l "${OLD_LOWER_THEME_NAME_UNDERSCORE}" . | xargs sed -i "" "s/${OLD_LOWER_THEME_NAME_UNDERSCORE}/${NEW_LOWER_THEME_NAME_UNDERSCORE}/g"
    grep -r -l "${OLD_UPPER_THEME_NAME_UNDERSCORE}" . | xargs sed -i "" "s/${OLD_UPPER_THEME_NAME_UNDERSCORE}/${NEW_UPPER_THEME_NAME_UNDERSCORE}/g"

    grep -r -l "Theme Name: ${OLD_THEME_NAME}" . | xargs sed -i "" "s/Theme Name: ${OLD_THEME_NAME}/Theme Name: ${NEW_THEME_NAME}/g"

    for i in {1..3}
    do
    find . -name \* -print | sed -e "p;s/${OLD_LOWER_THEME_NAME_UNDERSCORE}/${NEW_LOWER_THEME_NAME_UNDERSCORE}/" | xargs -n2 mv
    done

    mv * "../${NEW_LOWER_THEME_NAME_UNDERSCORE}"
    cd ..
    rm -rf "./${OLD_LOWER_THEME_NAME_UNDERSCORE}"
fi

cd "../wordpress/wp-content/themes/"
mkdir "${NEW_LOWER_THEME_NAME_UNDERSCORE}"
cd "./${OLD_LOWER_THEME_NAME_UNDERSCORE}"

grep -r -l "${OLD_LOWER_THEME_NAME_UNDERSCORE}" . | xargs sed -i "" "s/${OLD_LOWER_THEME_NAME_UNDERSCORE}/${NEW_LOWER_THEME_NAME_UNDERSCORE}/g"
grep -r -l "${OLD_UPPER_THEME_NAME_UNDERSCORE}" . | xargs sed -i "" "s/${OLD_UPPER_THEME_NAME_UNDERSCORE}/${NEW_UPPER_THEME_NAME_UNDERSCORE}/g"

grep -r -l "Theme Name: ${OLD_THEME_NAME}" . | xargs sed -i "" "s/Theme Name: ${OLD_THEME_NAME}/Theme Name: ${NEW_THEME_NAME}/g"

for i in {1..3}
do
  find . -name \* -print | sed -e "p;s/${OLD_LOWER_THEME_NAME_UNDERSCORE}/${NEW_LOWER_THEME_NAME_UNDERSCORE}/" | xargs -n2 mv
done

mv * "../${NEW_LOWER_THEME_NAME_UNDERSCORE}"
cd ..
rm -rf "./${OLD_LOWER_THEME_NAME_UNDERSCORE}"

mkdir "${NEW_LOWER_THEME_NAME_UNDERSCORE}-child"
cd "./${OLD_LOWER_THEME_NAME_UNDERSCORE}-child"

grep -r -l "${OLD_LOWER_THEME_NAME_UNDERSCORE}" . | xargs sed -i "" "s/${OLD_LOWER_THEME_NAME_UNDERSCORE}/${NEW_LOWER_THEME_NAME_UNDERSCORE}/g"
grep -r -l "${OLD_UPPER_THEME_NAME_UNDERSCORE}" . | xargs sed -i "" "s/${OLD_UPPER_THEME_NAME_UNDERSCORE}/${NEW_UPPER_THEME_NAME_UNDERSCORE}/g"

grep -r -l "Theme Name: ${OLD_THEME_NAME}" . | xargs sed -i "" "s/Theme Name: ${OLD_THEME_NAME}/Theme Name: ${NEW_THEME_NAME}/g"

for i in {1..3}
do
  find . -name \* -print | sed -e "p;s/${OLD_LOWER_THEME_NAME_UNDERSCORE}/${NEW_LOWER_THEME_NAME_UNDERSCORE}/" | xargs -n2 mv
done

mv * "../${NEW_LOWER_THEME_NAME_UNDERSCORE}-child"
cd ..
rm -rf "./${OLD_LOWER_THEME_NAME_UNDERSCORE}-child"

cd "../plugins/"
mkdir "${NEW_LOWER_THEME_NAME_UNDERSCORE}_extensions"
cd "./${OLD_LOWER_THEME_NAME_UNDERSCORE}_extensions"

grep -r -l "${OLD_LOWER_THEME_NAME_UNDERSCORE}" . | xargs sed -i "" "s/${OLD_LOWER_THEME_NAME_UNDERSCORE}/${NEW_LOWER_THEME_NAME_UNDERSCORE}/g"
grep -r -l "${OLD_UPPER_THEME_NAME_UNDERSCORE}" . | xargs sed -i "" "s/${OLD_UPPER_THEME_NAME_UNDERSCORE}/${NEW_UPPER_THEME_NAME_UNDERSCORE}/g"

grep -r -l "Plugin Name: ${OLD_THEME_NAME} Extensions" . | xargs sed -i "" "s/Plugin Name: ${OLD_THEME_NAME} Extensions/Plugin Name: ${NEW_THEME_NAME} Extensions/g"

grep -r -l "Description: This plugin is developed to enhance the capabilities of the ${OLD_THEME_NAME} WordPress Theme." . | xargs sed -i "" "s/Description: This plugin is developed to enhance the capabilities of the ${OLD_THEME_NAME} WordPress Theme./Description: This plugin is developed to enhance the capabilities of the ${NEW_THEME_NAME} WordPress Theme./g"


for i in {1..3}
do
  find . -name \* -print | sed -e "p;s/stencil/${LOWER_THEME_NAME_UNDERSCORE}/" | xargs -n2 mv
done

mv * "../${NEW_LOWER_THEME_NAME_UNDERSCORE}_extensions"
cd ..
rm -rf "./${OLD_LOWER_THEME_NAME_UNDERSCORE}_extensions"

echo ""
echo ""
echo "Name and internal references have been changed."