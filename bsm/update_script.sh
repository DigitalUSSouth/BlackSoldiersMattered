#!/bin/bash



echo "Cloning from github"
rm -rf bsm-temp
git clone https://github.com/DigitalUSSouth/BlackSoldiersMattered.git bsm-temp

echo "Creating backup"
rm -rf ~/bsm-old/*
cp -a /var/www/html/bsm ~/bsm-old

shopt -s extglob
rm -rf !(bsm-temp)

echo "Copying files"
cp -a bsm-temp/bsm/. /var/www/html/bsm

echo "Removing temporary files"
rm -rf bsm-temp

exit
