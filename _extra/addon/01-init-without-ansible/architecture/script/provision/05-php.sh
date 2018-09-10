#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[PHP-FPM]==="


echo "  => Install Packages"

apt-get install -y php7.0-fpm
apt-get install -y php7.0-bcmath
apt-get install -y php7.0-curl
apt-get install -y php7.0-gd
apt-get install -y php7.0-iconv
apt-get install -y php7.0-intl
apt-get install -y php7.0-json
apt-get install -y php7.0-mbstring
apt-get install -y php7.0-mcrypt
apt-get install -y php7.0-mysql
apt-get install -y php7.0-pdo
apt-get install -y php7.0-pdo-mysql
apt-get install -y php7.0-readline
apt-get install -y php7.0-redis
apt-get install -y php7.0-simplexml
apt-get install -y php7.0-soap
apt-get install -y php7.0-xml
apt-get install -y php7.0-xsl
apt-get install -y php7.0-zip

php -v

echo "  => Configure"

rm -f /etc/php/7.0/fpm/conf.d/80-provision.ini
rm -f /etc/php/7.0/cli/conf.d/80-provision.ini
rm -f /etc/php/7.0/fpm/pool.d/*

ln -s /var/www/magento2/architecture/conf/php/magento2.fpm.ini   /etc/php/7.0/fpm/conf.d/80-provision.ini
ln -s /var/www/magento2/architecture/conf/php/magento2.cli.ini   /etc/php/7.0/cli/conf.d/80-provision.ini
ln -s /var/www/magento2/architecture/conf/php/magento2.pool.conf /etc/php/7.0/fpm/pool.d/magento2.conf

echo "  => Service Enable"
systemctl --no-pager daemon-reload
systemctl --no-pager is-enabled php7.0-fpm || systemctl enable php7.0-fpm

echo "  => Service Restart"
systemctl --no-pager daemon-reload
systemctl --no-pager restart php7.0-fpm

echo "  => Service Status"
systemctl --no-pager status php7.0-fpm

echo ""
