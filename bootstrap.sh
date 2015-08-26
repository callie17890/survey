#!/usr/bin/env bash
	# Install Apache2, PHP 5.6 and its dependancies
  sudo apt-get update && sudo apt-get install python-software-properties

  sudo add-apt-repository ppa:ondrej/php5-5.6

  sudo apt-get install -y apache2 php5 php5-cli mysql-server

  rm -rf /var/www/html
  ln -s /vagrant/www /var/www/html