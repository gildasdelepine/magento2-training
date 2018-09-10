#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../

./script/provision/00-update.sh
./script/provision/01-basic.sh
./script/provision/02-mysql.sh
./script/provision/03-create-db.sh
./script/provision/04-redis.sh
./script/provision/05-php.sh
./script/provision/06-apache.sh
./script/provision/07-varnish.sh
./script/provision/08-nginx.sh

./script/permissions.sh

