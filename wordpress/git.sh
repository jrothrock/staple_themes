#!/bin/bash
mkdir -p ./hold_temp/wp-content/
cp -r ./wordpress/wp-content ./hold_temp/
cp ./wordpress/wp-config.php ./hold_temp/
rm -rf ./wordpress
mkdir wordpress
cp -r ./hold_temp/ ./wordpress
rm -rf ./hold_temp