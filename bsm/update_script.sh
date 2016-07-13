#!/bin/bash



echo "Cloning from github"
git clone https://github.com/DigitalUSSouth/BlackSoldiersMattered.git bsm-temp

echo "Creating backup"
mkdir -p bsm-old
cd bsm-old
rm -rf *
cd ../
cp -R $(ls | grep -v '^bsm-old$') bsm-old/
rm -rf !(bsm-temp|bsm-old)

echo "Copying files"
cp -a bsm-temp/bsm/. /var/www/html/bsm

echo "Removing temporary files"
rm -rf bsm-temp

exit
