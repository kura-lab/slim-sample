# slim-sample
Slim + Twig Smaple Code

### Environment

* CentOS release 6.5 (Final)
* PHP 5.3.3

### Install

#### Composer

```
cat composer.json
{
  "require": {
    "slim/slim": "2.*",
    "slim/views": "0.1.*",
    "twig/twig": "1.*",
    "predis/predis": "1.*",
    "monolog/monolog": "@stable"
  }
}
```

```
curl -s http://getcomposer.org/installer | php
sudo php composer.phar install
```

#### Redis

```
udo rpm -ivh http://ftp-srv2.kddilabs.jp/Linux/distributions/fedora/epel/6/x86_64/epel-release-6-8.noarch.rpm
sudo yum -y install php-pecl-redis --enablerepo=epel
sudo yum -y install redis --enablerepo=epel
sudo service redis start
// auto start
sudo chkconfig redis on
```

```
// sudo vim /etc/selinux/config
// SELINUX=disabled -> SELINUX=enforcing
# This file controls the state of SELinux on the system.
# SELINUX= can take one of these three values:
#    enforcing - SELinux security policy is enforced.
#    permissive - SELinux prints warnings instead of enforcing.
#    disabled - SELinux is fully disabled.
SELINUX=enforcing
# SELINUXTYPE= type of policy in use. Possible values are:
#    targeted - Only targeted network daemons are protected.
#    strict - Full SELinux protection.
SELINUXTYPE=targeted

sudo reboot -h now

sudo setsebool -P httpd_can_network_connect 1
getsebool httpd_can_network_connect
```

#### PHP

```
cat /etc/php.d/slim.ini
include_path="${include_path}:/var/www/html/"
open_basedir="${open_basedir}:/var/www/html/"
date.timezone = "Asia/Tokyo"
```

#### Apache

```
cat /etc/httpd.d/slim.conf
NameVirtualHost *:80

<VirtualHost *:80>
  ServerName example.com
  DocumentRoot /var/www/html
  <Directory "/var/www/html">
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [QSA,L]
    AllowOverride All
    Order allow,deny
    Allow from all
  </Directory>
</VirtualHost>
```

```
sudo service httpd restart
```
