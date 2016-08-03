#!/bin/bash



echo "Cloning from github"
rm -rf bsm-temp
rm -f data/*
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
curl localhost/bsm/convertCamps | grep -i 'error\|warning\|invalid\|exception'
echo "convertCamps - Done."
curl localhost/bsm/convertUnits | grep -i 'error\|warning\|invalid\|exception'
echo "convertUnits - Done."
curl localhost/bsm/convert | grep -i 'error\|warning\|invalid\|exception'
echo "convert solidiers - Done."


exit
