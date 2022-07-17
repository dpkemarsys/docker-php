# canals/php

## Images docker PHP  construite pour un usage pédagogique et pour fabriquer un environnement de développement web/php

### Description
Images docker pour la création d'un container destiné à du dev. web en php. Les images sont basées sur
les images php [officielle](https://hub.docker.com/_/php/), avec les tag `8.1-apache`, `8.1-cli`,`7.4-apache`, `7.4-cli`,`7.3-apache`, `7.3-cli`, `7.1-apache` , 
`7.1-cli`ou `5.6-apache`.
Les images contiennent un grand nombre d'extensions classiques et n'ont pas vocation à être utilisées en production.
Le dockerfile s'inspire de [celui-ci](https://hub.docker.com/r/lavoweb/php-5.6/), et de
[vaprobash](https://github.com/fideloper/Vaprobash)

### tag
+ `8.1-apache`, `8.1`, `latest`  : image pour php 8.1 + apache, basée sur l'image officielle `php:8.1-apache`
+ `8.1-cli` : image pour php 8.1 cli, sans apache, basée sur l'image officielle `php:8.1-cli` 
+ `8.0-cli` : image pour php 8.0 cli, sans apache, basée sur l'image officielle `php:8.0-cli`
+ `8.0` : image pour php 8.0 + apache, basée sur l'image officielle `php:8.0-apache`
+ `7.4-cli` : image pour php 7.4 cli, sans apache, basée sur l'image officielle `php:7.4-cli`
+ `7.4`: image pour php 7.4 + apache, basée sur l'image officielle `php:7.4-apache`
+ `7.3-cli` : image pour php 7.3 cli, sans apache, basée sur l'image officielle `php:7.3-cli`
+ `7.3` : image pour php 7.3 + apache, basée sur l'image officielle `php:7.3-apache`
+ `7.2-cli` : image pour php 7.2 cli, sans apache, basée sur l'image officielle `php:7.2-cli`
+ `7.2` : image pour php 7.2 + apache, basée sur l'image officielle `php:7.2-apache`
+ `7.1-cli` : image pour php 7.1 cli, sans apache, basée sur l'image officielle `php:7.1-cli`
+ `7.1`, : image pour php 7.1 + apache, basée sur l'image officielle `php:7.1-apache`
+ `5.6` : image pour php 5.6 + apache, basée sur l'image officielle `php:5.6-apache`

###test
Le répertoire [test](test) contient des fichiers docker-compose pour vérifier le fonctionnement de chacune des images


### contenu des images

#### apache (`8.1`,`8.0`, `7.4`, `latest`, `7.3`,  `7.2` , `7.1` , `5.6` ):

+ apache 2.4, modules `mod_rewrite` et `mod_ssl` activés,
+ un vhost par défaut sure le port 80, docroot `/var/www/html`
+ un vhost ssl par défaut sur le port 443, docroot `/var/www/html`, certificat auto-signé
+ création _optionnelle_ d'un vhost supplémentaire, sur les ports 80 _et_ 443, en définissant 2 variables d'environnement :
    * VHOST_HOSTNAME : contient le hostname du vhost
    * VHOST_DOCROOT : le docroot du vhost

#### php :

+ php8.1, php8.0, php7.4, php7.3, php7.2, php7.1 ou 5.6 cli et sous forme de module apache dans les images apache (`mod_php7`, `mod_php5`)
+ extensions : `mbstring`, `curl`, `ftp`, `openssl`, `zlib`, `bcmath`, `bz2`, `calendar`, `dba`, `exif`
   `gd`, `gettext`, `imap`, `intl`, `mcrypt` (uniquement 5.6, 7.1), `soap`, `tidy`, `xmlrpc` (non installé sur 8.x), `xsl`, `zip`, `imagick` (non installé sur 8.0)
+ PDO : `pdo`, `pdo_mysql`, `pdo_sqlite`, `pdo_pgsql`
+ autres extensions : `xdebug`, `mongodb`, `redis`
+ composer
+ pour ajouter de nouvelles extensions : se référer à la doc de l'image php officielle, et créer un dockerfile

Configuration php en mode développement :
```
PHP]


;;;;;;;;;;;;;;;;;;;;
; Language Options ;
;;;;;;;;;;;;;;;;;;;;


engine = On
short_open_tag = Off
precision = 14
output_buffering = 4096
zlib.output_compression = Off
implicit_flush = Off

;;;;;;;;;;;;;;;;;
; Miscellaneous ;
;;;;;;;;;;;;;;;;;

expose_php = On

;;;;;;;;;;;;;;;;;;;
; Resource Limits ;
;;;;;;;;;;;;;;;;;;;

max_execution_time = 60
max_input_time = 60
memory_limit = 512M

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
; Error handling and logging ;
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;

error_reporting = E_ALL
display_errors = On
display_startup_errors = On
log_errors = On
log_errors_max_len = 1024
ignore_repeated_errors = Off
ignore_repeated_source = Off
report_memleaks = On
html_errors = On


;;;;;;;;;;;;;;;;;
; Data Handling ;
;;;;;;;;;;;;;;;;;

variables_order = "GPCS"
request_order = "GP"
register_argc_argv = Off
auto_globals_jit = On

post_max_size = 16M
default_mimetype = "text/html"
default_charset = "UTF-8"

;;;;;;;;;;;;;;;;;;;;;;;;;
; Paths and Directories ;
;;;;;;;;;;;;;;;;;;;;;;;;;
enable_dl = Off

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
default_socket_timeout = 60

```


### Utilisation des images

#### image php-cli
L'image ne démarre aucune commande, et n'expose aucun port. Il est nécessaire de monter 
les volumes et de prévoir  la commande lors de la création d'un conteneur.

##### exemple : exécution d'un script php dans le répertoire courant : 
```bash
$ docker run -it --rm  \
      -v "$PWD":/var/php \
      -w /var/php \
       canals/php:8.1-cli \
       php prog.php
```
##### exemple : lancement d'un serveur php sur le port 8000 dans le répertoire courant : 
```bash
$ docker run --rm -it \
             -p 8000:8000 \
             -v "$PWD":/var/php \
             -w /var/php \
             canals/php:8.1-cli \
             php -S 0.0.0.0:8000 
```

#### image php-apache
Il est conseillé de monter les volumes correspondant aux _docroot_ des vhosts créés : vhost par défaut s'il est utilisé,
vhost spécifique.

##### exemple :

```bash
$ docker run -d --name vhost-php \
       -e "VHOST_HOSTNAME=vost.php.local" \
       -e "VHOST_DOCROOT=/var/www/vost"   \
       -p 9080:80 -p 9443:443 \
       -v "$PWD"/html:/var/www/html \
       -v "$PWD"/api:/var/www/vost \
       -v "$PWD"/src:/var/www/src \
       canals/php:latest
```

### Adaptation de l'image

Pour adapter l'image à des besoins particuliers, le plus simple est de créer un Dockerfile et de l'utiliser pour
installer des extensions, pour copier un fichier de configuration ou pour déclarer un volume spécifique.

+ installer des extensions : utiliser l'approche proposée par l'image php officielle : voir les explications
   [ici](https://hub.docker.com/_/php/)
+ modifier la configuration php : copier un fichier `.ini` dans le répertoire `/usr/local/etc/php/`

#### exemple
```
FROM canals/php:latest

RUN pecl install mailparse \
   && docker-php-ext-enable mailparse

COPY local.ini /usr/local/etc/php/
```