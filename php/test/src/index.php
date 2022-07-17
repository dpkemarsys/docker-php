<?php
/**
 * Created by PhpStorm.
 * User: canals5
 * Date: 23/09/2019
 * Time: 11:30
 */

echo "php is running !". '<br>';

echo "uri : ". ( isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "/") ;
