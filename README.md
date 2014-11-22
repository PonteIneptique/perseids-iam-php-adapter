perseids-iam-php-adapter
========================
[![Build Status](https://travis-ci.org/PonteIneptique/perseids-iam-php-adapter.svg)](https://travis-ci.org/PonteIneptique/perseids-iam-php-adapter)


#Informations
This project is a test to convert the [Bamboo attempt](http://svn.code.sf.net/p/projectbamboo/code/account-services/trunk/bamboo_as/bamboo_as.module) of providing an IAM gateway to PhP/Drupal (The source can also be found in `/source/bamboo_as.module.php`).

#Composer
To install the dependency, use the simple `composer install` command in the root folder.

#PFX files
If you have pfx files instead of pem, the https curl client won't accept it. To turn it to PEM, assuming your file is named `my_selfsigned.pfx`, open a terminal in its folder and type :

```
openssl pkcs12 -in client-certificate.pfx -out client-certificate.pem -nodes
``` 