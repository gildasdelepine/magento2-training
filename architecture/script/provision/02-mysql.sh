#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[MYSQL]==="

echo "   => Prepare Root Pass"

ROOT_PASS=`date +%s | sha256sum | base64 | head -c 32 ; echo`

echo "   => Add Repository"

wget https://repo.percona.com/apt/percona-release_0.1-4.$(lsb_release -sc)_all.deb
dpkg -i percona-release_0.1-4.$(lsb_release -sc)_all.deb
rm -f percona-release_0.1-4.$(lsb_release -sc)_all.deb
apt-get update

echo "   => Install package"

export DEBIAN_FRONTEND=noninteractive
apt-get -y install python-mysqldb
apt-get -y install percona-server-server
export DEBIAN_FRONTEND=dialog

echo "  => Configure"

mysqladmin -u root password ${ROOT_PASS}

systemctl --no-pager stop mysql
systemctl --no-pager status mysql
mkdir -p /etc/mysql/conf.d
mkdir -p /var/log/mysql
chown mysql.adm /var/log/mysql

rm -f /etc/mysql/conf.d/provision.cnf
cp -f /var/www/magento2/architecture/conf/mysql/provision.cnf /etc/mysql/conf.d/provision.cnf

echo "  => Clean"

rm -f /var/lib/mysql/ib*
rm -rf /var/lib/mysql/mysql/innodb_*
rm -rf /var/lib/mysql/mysql/slave_*

echo "  => Restart"

systemctl --no-pager start mysql
systemctl --no-pager is-enabled mysql || systemctl --no-pager enable mysql
systemctl --no-pager status mysql

echo "  => Automatic Root Pass"

touch /root/.my.cnf
chmod 600 /root/.my.cnf
echo "[client]"              >  /root/.my.cnf
echo "user=root"             >> /root/.my.cnf
echo "password=${ROOT_PASS}" >> /root/.my.cnf

echo ""
