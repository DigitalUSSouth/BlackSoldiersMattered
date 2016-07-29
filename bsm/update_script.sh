#!/bin/bash



echo "Cloning from github"
rm -rf bsm-temp
git clone https://github.com/DigitalUSSouth/BlackSoldiersMattered.git bsm-temp

echo "Creating backup"
rm -rf ~/bsm-old/*
cp -a /var/www/html/bsm ~/bsm-old

shopt -s extglob
rm -rf !(bsm-temp|data)

echo "Copying files"
cp -a bsm-temp/bsm/. /var/www/html/bsm

echo "Removing temporary files"
rm -rf bsm-temp

echo "Running data conversion scripts"
php convertCamps.php | grep error
echo "convertCamps - Done."
php convertUnits.php | grep error
echo "convertUnits - Done."
php convert.php | grep error
echo "convert solidiers - Done."


exit
