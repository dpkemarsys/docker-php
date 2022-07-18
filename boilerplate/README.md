# Un template Docker-compose pour un environnement de dev. web en php

Le template est Basé sur les images php  [`canals/php`](https://hub.docker.com/r/canals/php/) et les images officielles 
de différents outils. Le template est disponible dans le fichier `docker-compose.yml`. Un exemple d'utilisation complet 
de ce template est disponible dans le répertoire de `test`.

## Utilisation

### première utilisation
```bash
$ docker-compose -f docker-compose.yml up

```

### arréter/démarrer les services
```bash
$ docker-compose -f docker-compose.yml stop
$ docker-compose -f docker-compose.yml start
```

### recréer des containers après des modifications dans le fichier docker-compose
```bash
$ docker-compose -f docker-compose.yml create
$ docker-compose -f docker-compose.yml start
```

## les services disponibles :

### machine(s) php

* un ou plusieurs services php/apache ou php-cli
* basés sur les images `canals/php`, les tags `:8.1`,`:8.1-cli`, `:latest`, `:8.0`,`:8.0-cli`, `:7.4`,`:7.4-cli`, `:7.3`,`:7.3-cli`, `:7.2` et `7.2-cli`, `:7.1` 
et `7.1-cli`,`:5.6` sont utilisables (pour plus de détails sur ces images, 
voir la [doc](https://hub.docker.com/r/canals/php/) )
* conseils : utiliser les vhost et les déclarer dans votre `/etc/hosts`
* attention aux numéros de ports lorsque l'on utilise plusieurs services de même type


#### exemple : service php basé sur apache
```
services:
  web:
    image: canals/php:latest
    environment:
      - VHOST_HOSTNAME=web.dev.local
      - VHOST_DOCROOT=/var/www/web
#     - http_proxy=http://www-cache:1234     
#     - https_proxy=http://www-cache:1234
    ports:
      - "5080:80"
      - "5543:443"
    volumes :
      - ./web:/var/www/web
      - ./src:/var/www/src
      - ./html:/var/www/html
      - data:/var/www/data
    networks:          
      - local_network  
    depends_on :
      - mysql
      - mongodb
```
#### exemple : service php-cli avec lancement du serveur embarqué : 
```
services:
  php:
    image: canals/php:8.1-cli
    ports:
      - "8800:8000"
    volumes:
     - ./:/var/php
    working_dir: /var/php
    command: php -S 0.0.0.0:8000 index.php
    networks:          
      - local_network  
    depends_on :
      - mysql
      - mongodb
```

### mysql + adminer

* basé sur les images officielles `mysql` (ou `mariadb`)et `adminer`
    * pour plus de détails, voir la doc [mysql](https://hub.docker.com/_/mysql/) et
     [adminer](https://hub.docker.com/_/adminer/)
* conseils : définir un password pour l'utilisateur `root`
* il peut être utile de monter un volume pour échanger des données avec le serveur mysql
  si les fichiers d'import/export sont trop volumineux pour être traités par adminer

#### important :
Le service mysql est accessible dans tous les services connectés au même réseau avec 
un hostname ayant pour valeur le nom du service.
On peut ajouter un ou plusieurs hostname alternatifs avec la directive sous directive `aliases` de la directive `networks`


#### exemple

```
  mysql:
    image: mariadb:latest
    environment:
      - MYSQL_ROOT_PASSWORD=root
      - MYSQL_USER=user
      - MYSQL_PASSWORD=user
    ports:
      - "3603:3306"
    networks:
      aliases:
        - db
      
  adminer:
     image: adminer
     ports:
       - "8080:8080"
     depends_on:
       - mysql
  # Dans ce conteneur, le serveur mysql est accessible avec le hostname mysql et 
  # le hostname db
```

### mongodb + mongo-express

* basé sur l'image [officielle](https://hub.docker.com/_/mongo/) `mongo`
* mongo-express est un client mongo pour interagir de façon interactive avec le serveur mongo,
 basé sur l'image [officielle](https://hub.docker.com/_/mongo-express/) `mongo-express`

#### exemple

```
  mongodb:
    image: mongo:latest
    ports:
        - 27017:27017
    networks:
      local_network:
        aliases:
          - mongo

  mongo-express:
     image: mongo-express:latest
     ports:
        - "8081:8081"
     depends_on:
       - mongodb
```

### mailcatcher
 MailCatcher est un service de mail qui offre un contexte de test pour les
 fonctionnalités d'envoi de mail d'une application web. MailCatcher est un serveur de mail
 permettant de consulter l'ensemble des messages qui lui sont adressés via une interface web.
 Le serveur opère sur le port `1025` et l'interface web est accessible sur le port `1080`.

 * basé sur l'image `schickling/mailcatcher`
 * l'image expose les ports `1025` et `1080`
 * ajouter le lien dans les services qui doivent accéder au serveur

#### exemple
```
mailcatcher:
  image: schickling/mailcatcher
  ports:
    - "1080:1080"
    - "1025:1025
  networks: 
    local_network:
      aliases:
        - mail.server
```

#### usage
 Dans un service php déclarant le lien mailcatcher :
```
 web:
     image: canals/php
     ...
     networks:
        - localnetwork
     depends_on:
       - mailcatcher
```

 il faut utiliser le serveur de mail nommé `mail.server` sur le port `1025`.

 Par exemple, avec SwiftMailer :
```
 $mailer = new Swift_Mailer( new Swift_SmtpTransport('mail.server', 1025) );
```

