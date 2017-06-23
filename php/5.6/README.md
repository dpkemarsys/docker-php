# canals/php

**a PHP docker image for pedagogical purposes**



```bash
$ docker run -d --name vhost-php -e "VHOST_HOSTNAME=vost.php.local" -e "VHOST_DOCROOT=/var/www/vost" -p 9080:80 -p 9443:443 -v /Users/canals/dev/docker-test/test-php/api:/var/www/vost -v /Users/canals/dev/docker-test/test-php/src:/var/www/src canals/php:v2
```