#!/bin/bash

rm -f var/cache/CompiledContainer.php

export APP_ENV=dev
export APP_DEBUG=1

export DEBUG=1
export DATABASE="sqlite://var/database.sqlite"

tree src/Domain/Entities

vendor/bin/doctrine orm:info

php -S 127.0.0.1:8000 -t public
