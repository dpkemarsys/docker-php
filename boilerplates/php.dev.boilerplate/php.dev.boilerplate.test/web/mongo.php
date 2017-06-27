<?php
/**
 * File:  mongo.php
 * Creation Date: 27/06/2017
 * description:
 *
 * @author: canals
 */

require __DIR__ . '/../src/vendor/autoload.php';

$client = new MongoDB\Client("mongodb://mongo:27017");
$collection = $client->demo->beers;

$result = $collection->insertOne( [ 'name' => 'Hinterland', 'brewery' => 'BrewDog' ] );

echo "Inserted with Object ID '{$result->getInsertedId()}'" . '<br>';

$result = $collection->insertOne( [ 'name' => 'Houblon Chouffe', 'brewery' => 'Brasserie d\'Achouffe' ] );

echo "Inserted with Object ID '{$result->getInsertedId()}'";