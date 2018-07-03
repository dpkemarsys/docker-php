###Tests for the 7.2, 7.1 and 5.6 php/apache images

####php7.2 image :

```shell
$ docker-compose -f docker-compose.test.7.2.yml up
Creating web.test.canals.php.7.2
Attaching to web.test.canals.php.7.2
...

```

should lead to the creation and enaction of a container named _web.test.canals.php.7.2_ .

To verify that everything goes well, just point your preferred browser to the following urls:

+ http://localhost:27080/
+ http://localhost:27080/index.html
+ http://localhost:27080/info.php
+ https://localhost:27443/
+ https://localhost:27443/index.html
+ https://localhost:27443/info.php

####php7.1 image :

```shell
$ docker-compose -f docker-compose.test.7.1.yml up
Creating web.test.canals.php.7.1
Attaching to web.test.canals.php.7.1
...

```

should lead to the creation and enaction of a container named _web.test.canals.php.7.1_ .

To verify that everything goes well, just point your preferred browser to the following urls:

+ http://localhost:25080/
+ http://localhost:25080/index.html
+ http://localhost:25080/info.php
+ https://localhost:25443/
+ https://localhost:25443/index.html
+ https://localhost:25443/info.php


####php5.6 image :

```shell
$ docker-compose -f docker-compose.test.5.6.yml up
  Creating web.test.canals.php.5.6
  Attaching to web.test.canals.php.5.6
...

```

should lead to the creation and enaction of a container named _web.test.canals.php.5.6_ .

To verify that everything goes well, just point your preferred browser to the following urls:

* http://localhost:26080/
* http://localhost:26080/index.html
* http://localhost:26080/info.php
* https://localhost:26443/
* https://localhost:26443/index.html
* https://localhost:26443/info.php