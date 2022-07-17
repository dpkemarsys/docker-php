#!/usr/local/bin/bash

tag="latest"
if [ $# -ge 1 ]; then
    tag=$1
fi

echo "running a canals/php based container with tag : $tag"

docker run --rm\
       -p 9080:80 -p 9443:443 \
       -v "$PWD"/html:/var/www/html \
       -v "$PWD"/src:/var/www/src \
       canals/php:$tag
