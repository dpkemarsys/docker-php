# canals/php:7.1, latest

##a PHP docker image for pedagogical purposes

Image docker pour la création d'un container destiné à du dev. web en php. L'image est basée sur
l'images php [officielle](https://hub.docker.com/_/php/), avec le tag `7.1-apache`.
Le dockerfile s'inspire de [celui-ci](https://hub.docker.com/r/lavoweb/php-5.6/), et de
[vaprobash](https://github.com/fideloper/Vaprobash)

###contenu de l'image

####apache :

+ apache 2.4, modules `mod_rewrite` et `mod_ssl` activés,
+ un vhost par défaut sure le port 80, docroot `/var/www/html`
+ un vhost ssl par défaut sur le port 443, docroot `/var/www/html`, certificat auto-signé
+ création _optionnelle_ d'un vhost supplémentaire, sur les ports 80 _et_ 443, en définissant 2 variables d'environnement :
    * VHOST_HOSTNAME : contient le hostname du vhost
    * VHOST_DOCROOT : le docroot du vhost

####php :

+ php7.1, module apache (`php7)`
+ extensions : `mbstring`, `curl`, `ftp`, `openssl`, `zlib`, `bcmath`, `bz2`, `calendar`, `dba`, `exif`
   `gd`, `gettext`, `imap`, `intl`, `mcrypt`, `soap`, `tidy`, `xmlrpc`, `xsl`, `zip`, `imagick`
+ PDO : `pdo`, `pdo_mysql`, `pdo_sqlite`, `pdo_pgsql`
+ autres extensions : `xdebug`, `mongodb`
+ composer
+ pour ajouter de nouvelles extensions : se référer à la doc de l'image php officielle, et créer un dockerfile

Configuration php en mode développement :
```
[PHP]


memory_limit = 512M
max_execution_time = 60
error_reporting = -1
display_errors = On
display_startup_errors = On
track_errors = On
variables_order = "GPCS"


;;;;;;;;;;;;;;;;
; File Uploads ;
;;;;;;;;;;;;;;;;

file_uploads = On
upload_max_filesize = 8M
max_file_uploads = 25

;;;;;;;;;;;;;;;;;;
; Fopen wrappers ;
;;;;;;;;;;;;;;;;;;
allow_url_fopen = Off

```


###Utilisation de l'image

Il est conseillé de monter les volumes correspondant aux _docroot_ des vhosts créés : vhost par défaut s'il est utilisé,
vhost spécifique.

####exemple :

```bash
$ docker run -d --name vhost-php \
       -e "VHOST_HOSTNAME=vost.php.local" \
       -e "VHOST_DOCROOT=/var/www/vost"   \
       -p 9080:80 -p 9443:443 \
       -v $(PWD)/html:/var/www/html \
       -v $(PWD)/api:/var/www/vost \
       -v $(PWD)/src:/var/www/src \
       canals/php
```

