#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[NGINX]==="

echo "  => Install Package"

apt-get -y install nginx

echo "  => Configure"

rm -f /etc/nginx/sites-enabled/*
ln -s /var/www/magento2/architecture/conf/nginx/magento2-ssl /etc/nginx/sites-enabled/magento2-ssl

echo "  => Prepare Service"

systemctl --no-pager daemon-reload
systemctl --no-pager is-enabled nginx || systemctl enable nginx
systemctl --no-pager restart nginx
systemctl --no-pager status nginx

echo ""
