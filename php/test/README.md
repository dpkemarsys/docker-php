###Tests for the  php/apache images

####for php-apache images :

```shell
$ ./docker-php-apache.test.sh tag
...

```

should lead to the creation and enaction of a docker container based on image canals/php:tag.
Default value for tag is `latest`

To verify that everything goes well, just point your preferred browser to the following urls:

+ http://localhost:9080/
+ http://localhost:9080/index.html
+ http://localhost:9080/info.php
+ https://localhost:9443/
+ https://localhost:9443/index.html
+ https://localhost:9443/info.php

####for php-cli images :

```shell
$ ./docker-php-cli.test.sh tag
...
```

should lead to the creation and enaction of a docker container based on the image canals/php:tag
The container runs the following command :
```shell
php -S 0.0.0.0:8000
```

To verify that everything goes well, just point your preferred browser to the following urls:

+ http://localhost:8000/
+ http://localhost:8000/fofo



