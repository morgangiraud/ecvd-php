# ecvd-php
Lessons for the ECV Digital school - PHP/MySQL

You can find the website [here](http://morgangiraud.github.io/ecvd-php/)

## Setup
Before starting you need to setup your environment.
**(Mac OSX)**

### Pre-requisites
- Launch a terminal
- Install [brew](http://brew.sh/)
- Update brew: `brew update` (If you already had brew, upgrade: `brew upgrade`)
- Install [GIT](https://git-scm.com/): `brew install git`
  - you can add [git-extras](https://github.com/tj/git-extras): `brew install git-extras`
- Install [sublime text 3](http://www.sublimetext.com/3) ([Atom](https://atom.io/) is also a good choice)
- Install [package control](https://packagecontrol.io/installation) for sublime text 3
- Thanks to the package control install those modules:
  - [SublimeLinter](http://sublimelinter.readthedocs.org/en/latest/installation.html)
  - SublimeLinter-php
  - Goto Documentation
- Link your sublime text in the command line here: https://www.sublimetext.com/docs/3/osx_command_line.html
- Add some completions: `brew install bash-completion`

### PHP
- Install php 5.6: `brew install php56`
 - Install phplint: `brew install phplint`
 - Install phpunit: `brew install phpunit`

Check your installation: `php -v`

### MySQL
- Install mysql: `brew install mysql`
- Install [Sequel Pro](http://www.sequelpro.com/)

Start mysql: `mysqld_safe`
Access it from Sequel pro

## Goal
Succeeding at the [zend certification](http://www.zend.com/en/services/certification/php-5-certification)
![ok dude](https://github.com/jglovier/gifs/blob/gh-pages/thumbs-up/thumbs-up.gif)


## Gift
For your own sanity, add this to your .bash_profile file
```bash
parse_git_branch() {
    git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/ (\1)/'
}
export PS1="\u@\h \W\[\033[32m\]\$(parse_git_branch)\[\033[00m\] $ "
```
