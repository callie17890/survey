#!/usr/bin/env bash
	# Install Apache2, PHP 5.6 and its dependancies
  sudo apt-get update && sudo apt-get install python-software-properties

  sudo add-apt-repository ppa:ondrej/php5-5.6
  sudo apt-get install -y apache2 apache2-utils apache2-mpm-prefork php5 php5-cli 

  chown -R vagrant /var/log/apache2/*

  rm -rf /var/www/html
  ln -s /vagrant/www /var/www/html
  ln -s /var/log/apache2/error.log /vagrant

  sudo apache2ctl restart
