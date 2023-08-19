#!/bin/bash

brew install libyaml
brew install imagemagick
brew install sphinx

pecl install yaml
pecl install imagick

php -m | grep yaml
php -m | grep imagick

composer update

code .

php -S 127.0.0.1:8000 -t public

open http://127.0.0.1:8000/cup/system
