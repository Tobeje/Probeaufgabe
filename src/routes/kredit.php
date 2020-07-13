<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/Credit', function( Request $request, Response $response){
    $sql = "SELECT * FROM kreditkarte";

   try {
     // Get DB Object
     $db = new db();
 
     // connect to DB
     $db = $db->connect();
 
     // query
     $stmt = $db->query( $sql );
     $items = $stmt->fetchAll( PDO::FETCH_OBJ );
     $db = null; // clear db object
 
     // print out the result as json format
     echo json_encode( $items );    
       
   } catch( PDOException $e ) {
     // show error message as Json format
     echo '{"error": {"msg": ' . $e->getMessage() . '}';
   }
});

$app->get('/Credit/{id}', function( Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM kreditkarte WHERE Kartennummer = $id";

   try {
     // Get DB Object
     $db = new db();
 
     // connect to DB
     $db = $db->connect();
 
     // query
     $stmt = $db->query( $sql );
     $items = $stmt->fetchAll( PDO::FETCH_OBJ );
     $db = null; // clear db object
 
     // print out the result as json format
     echo json_encode( $items );    
       
   } catch( PDOException $e ) {
     // show error message as Json format
     echo '{"error": {"msg": ' . $e->getMessage() . '}';
   }
});

$app->post('/Credit', function( Request $request, Response $response){

    // get the parameter from the form submit
    $name = $request->getParam('Name');
    $pin = $request->getParam('PIN');
    $creditlimit = $request->getParam('Kreditlimit');
    $giroFK = $request->getParam('Kontonummer_GK');
    
    $sql = "INSERT INTO kreditkarte (Name, PIN, Kreditlimit, Guthaben, Kontonummer_GK) 
            VALUES(:name,:pin,:creditlimit, 0, :giroFK)";
            echo "hello";
  
    try {
      // Get DB Object
      $db = new db();
  
      // connect to DB
      $db = $db->connect();
  
      // https://www.php.net/manual/en/pdo.prepare.php
      $stmt = $db->prepare( $sql );
  
      // bind each paramenter
      // https://www.php.net/manual/en/pdostatement.bindparam.php
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':pin', $pin);
      $stmt->bindParam(':creditlimit', $creditlimit);
      $stmt->bindParam(':giroFK', $giroFK);
  
      // execute sql
      $stmt->execute();
      
      // return the message as json format
      echo '{"notice" : {"msg" : "New Credit Added."}';
  
    } catch( PDOException $e ) {
  
      // return error message as Json format
      echo '{"error": {"msg": ' . $e->getMessage() . '}';
    }
  });

    // create PUT HTTP request
$app->put('/Credit/sub/{id}', function( Request $request, Response $response){
    // get attribute from URL
    $id = $request->getAttribute('id');
    
    // get the parameter from the form submit
    $credit = $request->getParam('Guthaben');
    $pin = $request->getParam('PIN');

    $sql = "UPDATE kreditkarte 
            INNER JOIN girokonto ON kreditkarte.Kontonummer_GK = girokonto.Kontonummer_GK 
            SET kreditkarte.Guthaben = if(kreditkarte.Guthaben + girokonto.Guthaben + girokonto.Dispolimit > :credit AND kreditkarte.PIN = :pin, kreditkarte.Guthaben - :credit, kreditkarte.Guthaben) 
            WHERE Kartennummer = $id AND girokonto.Kontonummer_GK = kreditkarte.Kontonummer_GK ";
  
    try {
      // Get DB Object
      $db = new db();
  
      // connect to DB
      $db = $db->connect();
  
      // https://www.php.net/manual/en/pdo.prepare.php
      $stmt = $db->prepare( $sql );
  
      // bind each paramenter
      // https://www.php.net/manual/en/pdostatement.bindparam.php
      $stmt->bindParam(':credit', $credit);
      $stmt->bindParam(':pin', $pin);
  
      // execute sql
      $stmt->execute();
      
      // return the message as json format
      echo '{"notice" : {"msg" : "credit Updated."}';
  
    } catch( PDOException $e ) {
  
      // return error message as Json format
      echo '{"error": {"msg": ' . $e->getMessage() . '}';
    }
  });