<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/fest', function( Request $request, Response $response){
    $sql = "SELECT * FROM festgeldkonto";

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

$app->get('/fest/{id}', function( Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM festgeldkonto WHERE Kontonummer_FK = $id";

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

$app->post('/fest', function( Request $request, Response $response){

    // get the parameter from the form submit
    $name = $request->getParam('Name');
    $pin = $request->getParam('PIN');
    $zins = $request->getParam('Zinssatz');
    
    $sql = "INSERT INTO festgeldkonto (Name, PIN, Zinssatz) 
            VALUES(:name,:pin,:zins)";
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
      $stmt->bindParam(':zins', $zins);
  
      // execute sql
      $stmt->execute();
      
      // return the message as json format
      echo '{"notice" : {"msg" : "New fest Added."}';
  
    } catch( PDOException $e ) {
  
      // return error message as Json format
      echo '{"error": {"msg": ' . $e->getMessage() . '}';
    }
  });

  // create PUT HTTP request
$app->put('/fest/add/{id}', function( Request $request, Response $response){
    // get attribute from URL
    $id = $request->getAttribute('id');
    
    // get the parameter from the form submit
    $credit = $request->getParam('Guthaben');
    $pin = $request->getParam('PIN');
    
    $sql = "UPDATE festgeldkonto 
            SET Guthaben = Guthaben + :credit ,
                Letztezahlung = NOW()
            WHERE Kontonummer_FK = $id";
  
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
  
      // execute sql
      $stmt->execute();
      
      // return the message as json format
      echo '{"notice" : {"msg" : "User Updated."}';
  
    } catch( PDOException $e ) {
  
      // return error message as Json format
      echo '{"error": {"msg": ' . $e->getMessage() . '}';
    }
  });

    // create PUT HTTP request
$app->put('/fest/sub/{id}', function( Request $request, Response $response){
    // get attribute from URL
    $id = $request->getAttribute('id');
    
    // get the parameter from the form submit
    $credit = $request->getParam('Guthaben');
    $pin = $request->getParam('PIN');

    $sql = "UPDATE festgeldkonto 
            WHERE Kontonummer_FK = $id";
  
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
      echo '{"notice" : {"msg" : "User Updated."}';
  
    } catch( PDOException $e ) {
  
      // return error message as Json format
      echo '{"error": {"msg": ' . $e->getMessage() . '}';
    }
  });

  $app->post('/connectfest', function( Request $request, Response $response){

    // get the parameter from the form submit
    $userID = $request->getParam('Kundennummer');
    $AccountID = $request->getParam('Kontonummer_FK');
    
    $sql = "INSERT INTO nutzerfest (Kundennummer, Kontonummer_FK) 
            VALUES(:kundennummer,:Kontonummer_FK)";
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
      $stmt->bindParam(':kundennummer', $userID);
      $stmt->bindParam(':Kontonummer_FK', $AccountID);
  
      // execute sql
      $stmt->execute();
      
      // return the message as json format
      echo '{"notice" : {"msg" : "New User to fest Added."}';
  
    } catch( PDOException $e ) {
  
      // return error message as Json format
      echo '{"error": {"msg": ' . $e->getMessage() . '}';
    }
  });