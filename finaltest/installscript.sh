#!/bin/bash
if [ -z "$1" ]; then
  echo "No argument supplied"
  exit 1
fi

if [ ! -d ~/tmp ]; then
  mkdir ~/tmp
fi
cd ~/tmp

# Xcode
xcode-select --install

which -s brew
if [[ $? != 0 ]] ; then
    /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
else
    brew update
fi
echo "Installing missing utils"
brew install automake colordiff curl git wget cask pidof
echo "Upgrading utils"
brew upgrade automake colordiff curl git wget cask pidof

echo "Checking for Sublime text"
which -s subl
if [[ $? != 0 ]] ; then  
  brew cask install sublime-text
fi

echo "Checking for Node"
which -s node
if [[ $? != 0 ]] ; then
    brew install node
else
    brew upgrade node
fi

echo "Checking for MySQL"
which -s mysql
if [[ $? != 0 ]] ; then
    brew install mysql
else
    brew upgrade mysql
fi
echo "Resetting root password"
number=$(ps aux | grep mysql | wc -l)
if [ $number -gt 1 ]
    then
        mysql.server stop
fi
echo "update mysql.user set password=PASSWORD('r00t') where User='root'; FLUSH PRIVILEGES;" > ~/tmp/init.sql
mysqld_safe --skip-grant-tables &
sleep 2
mysql -u root < ~/tmp/init.sql
rm ~/tmp/init.sql
mysql.server stop
mysqld_safe &

echo "Checking for PHP56"
which -s php
if [[ $? != 0 ]] ; then
    brew install php56
else
    brew remove
    brew upgrade php56
fi
echo "Restarting php-fpm"
pidof php-fpm | sudo xargs kill
sudo php-fpm
php -S localhost:8000 &

if [ -d ~/tmp/ecvd-php ]; then
  echo "Removing ~/tmp/ecvd-php folder"
  rm -rf ~/tmp/ecvd-php
fi
echo "cloning distant repo"
cd ~/tmp
git clone https://github.com/morgangiraud/ecvd-php.git
cd ecvd-php
git checkout -b $1
mkdir -p finaltest/$1
cd finaltest/$1
cp -R ../chat test.md .
subl .
open -a Terminal .
open -a "/Applications/Google Chrome.app" 'http://localhost:8000'