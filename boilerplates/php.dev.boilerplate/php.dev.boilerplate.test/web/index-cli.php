<?php
/**
 * File:  index.php
 * Creation Date: 23/06/2017
 * description:
 *
 * @author: canals
 */
require __DIR__ . '/../src/vendor/autoload.php';
require_once __DIR__ . '/../src/sample.php';

print "request uri : " . $_SERVER['REQUEST_URI'] . "<br>";
print "request method " . $_SERVER['REQUEST_METHOD']. "<br><br>";

print "<h2>connexion mysql-mariadb :</h2>" . "<br>";
try {
    $pdo = new PDO( 'mysql:host=db;dbname=mysql', 'root', 'root66');
} catch (PDOException $e) {
    print 'erreur connexion mysql : ' . $e->getMessage() . '<br>' ;
    die();
}

print 'connexion etablie <br>';

foreach ($pdo->query('select host, user from user') as $row) {
    print $row['host'] . '  :  ' . $row['user'] . '<br>';
};

print "<br><h2>connexion mongo :</h2>" . "<br>";

$client = new MongoDB\Client("mongodb://mongo:27017");
$collection = $client->demo->beers;

$result = $collection->insertOne( [ 'name' => 'Hinterland', 'brewery' => 'BrewDog' ] );

echo "Inserted with Object ID '{$result->getInsertedId()}'" . '<br>';

$result = $collection->insertOne( [ 'name' => 'Houblon Chouffe', 'brewery' => 'Brasserie d\'Achouffe' ] );

echo "Inserted with Object ID '{$result->getInsertedId()}'";