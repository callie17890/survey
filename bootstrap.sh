#!/usr/bin/env bash
	# Install Apache2, PHP 5.6 and its dependancies
  export DEBIAN_FRONTEND=noninteractive
  sudo apt-get update && sudo apt-get install python-software-properties

  sudo add-apt-repository ppa:ondrej/php5-5.6
  sudo apt-get install -y apache2 apache2-utils apache2-mpm-prefork php5 php5-cli 

  apt-get -y install mysql-server-5.5 mysql-server libapache2-mod-auth-mysql php5-mysql

  chgrp -R vagrant /var/log/apache2

  sed -i s/127.0.0.1/0.0.0.0/ /etc/mysql/my.cnf 

  rm -rf /var/www/html
  ln -s /vagrant/www /var/www/html

  sudo apache2ctl restart
  sudo service mysql restart

  mysql --execute="
  CREATE USER 'root'@'%';
  GRANT ALL ON *.* to root@'%';
  FLUSH PRIVILEGES;"
