#!/usr/local/bin/bash


if [ $# -lt 1 ]; then
    echo "no tag present, stopping"
    exit 1
fi



docker run --rm -it \
             -p 8000:8000 \
             -v "$PWD"/src:/var/php \
             -w /var/php \
             canals/php:"$1" \
             php -S 0.0.0.0:8000
