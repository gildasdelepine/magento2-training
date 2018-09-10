#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[VARNISH]==="

echo "  => Fix Bug on Stretch"

mkdir -p /etc/systemd/system/varnishncsa.service.d
touch /etc/systemd/system/varnishncsa.service.d/override.conf
echo "[Service]"            >> /etc/systemd/system/varnishncsa.service.d/override.conf
echo "PrivateNetwork=false" >> /etc/systemd/system/varnishncsa.service.d/override.conf

cp ./conf/varnish/varnish_reload_vcl_stretch /usr/sbin/varnish_reload_vcl
chmod 755 /usr/sbin/varnish_reload_vcl

echo "  => Install Package"

apt-get -y install varnish
varnishd -V

echo "  => Configure"

rm -f /etc/default/varnish
rm -f /etc/varnish/magento2.vcl
rm -f /etc/systemd/system/varnish.service
rm -f /etc/systemd/system/varnishncsa.service

cp -f /var/www/magento2/architecture/conf/varnish/default             /etc/default/varnish
cp -f /var/www/magento2/architecture/conf/varnish/magento2.vcl        /etc/varnish/magento2.vcl
cp -f /var/www/magento2/architecture/conf/varnish/varnish.service     /etc/systemd/system/varnish.service
cp -f /var/www/magento2/architecture/conf/varnish/varnishncsa.service /etc/systemd/system/varnishncsa.service

echo "  => Services Enabled"
systemctl --no-pager daemon-reload
systemctl --no-pager is-enabled varnish     || systemctl --no-pager enable varnish
systemctl --no-pager is-enabled varnishncsa || systemctl --no-pager enable varnishncsa

echo "  => Services Restart"
systemctl --no-pager daemon-reload
systemctl --no-pager restart varnish
systemctl --no-pager restart varnishncsa

echo "  => Services Status"
systemctl --no-pager status varnish
systemctl --no-pager status varnishncsa

echo ""
