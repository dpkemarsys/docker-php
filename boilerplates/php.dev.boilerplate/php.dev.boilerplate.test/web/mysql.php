<?php
/**
 * File:  mysql.php
 * Creation Date: 27/06/2017
 * description:
 *
 * @author: canals
 */

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
