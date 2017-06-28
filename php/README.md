# canals/php

##Une image docker PHP  construite pour un usage pédagogique et pour fabriquer un environnement de développement web/php

###description
Image docker pour la création d'un container destiné à du dev. web en php. L'image est basée sur
les images php [officielle](https://hub.docker.com/_/php/), avec les tag `7.1-apache` ou `5.6-apache`.
Les images contiennent un grand nombre d'extensions classiques et n'ont pas vocation à être utilisées en production.
Le dockerfile s'inspire de [celui-ci](https://hub.docker.com/r/lavoweb/php-5.6/), et de
[vaprobash](https://github.com/fideloper/Vaprobash)

###tag
+ `7.1`, `latest` : image pour php 7.1, basée sur l'image officielle `php:7.1-apache`
+ `5.6` : image pour php 5.6, basée sur l'image officielle `php:5.6-apache`

###test
Le répertoire [test](test) contient des fichiers docker-compose pour vérifier le fonctionnement de chacune des 2 images


###contenu de l'image

####apache :

+ apache 2.4, modules `mod_rewrite` et `mod_ssl` activés,
+ un vhost par défaut sure le port 80, docroot `/var/www/html`
+ un vhost ssl par défaut sur le port 443, docroot `/var/www/html`, certificat auto-signé
+ création _optionnelle_ d'un vhost supplémentaire, sur les ports 80 _et_ 443, en définissant 2 variables d'environnement :
    * VHOST_HOSTNAME : contient le hostname du vhost
    * VHOST_DOCROOT : le docroot du vhost

####php :

+ php7.1 ou 5.6 sous forme de module apache (`mod_php7`, `od_php5`)
+ extensions : `mbstring`, `curl`, `ftp`, `openssl`, `zlib`, `bcmath`, `bz2`, `calendar`, `dba`, `exif`
   `gd`, `gettext`, `imap`, `intl`, `mcrypt`, `soap`, `tidy`, `xmlrpc`, `xsl`, `zip`, `imagick`
+ PDO : `pdo`, `pdo_mysql`, `pdo_sqlite`, `pdo_pgsql`
+ autres extensions : `xdebug`, `mongodb`, `redis`
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
allow_url_fopen = On
allow_url_include = Off

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

###Adaptation de l'image

Pour adapter l'image à des besoins particuliers, le plus simple est de créer un Dockerfile et de l'utiliser pour
installer des extensions, pour copier un fichier de configuration ou pour déclarer un volume spécifique.

+ installer des extensions : utiliser l'approche proposée par l'image php officielle : voir les explications
   [ici](https://hub.docker.com/_/php/)
+ modifier la configuration php : copier un fichier `.ini` dans le répertoire `/usr/local/etc/php/`

####exemple
```
FROM canals/php:7.1

RUN pecl install mailparse \
   && docker-php-ext-enable mailparse

COPY local.ini /usr/local/etc/php/
```