<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/giro', function( Request $request, Response $response){
    $sql = "SELECT * FROM girokonto";

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

$app->get('/giro/{id}', function( Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM girokonto WHERE Kontonummer_GK = $id";

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

$app->post('/giro', function( Request $request, Response $response){

    // get the parameter from the form submit
    $name = $request->getParam('Name');
    $pin = $request->getParam('PIN');
    $dispolimit = $request->getParam('Dispolimit');
    
    $sql = "INSERT INTO girokonto (Name, PIN, Dispolimit) 
            VALUES(:name,:pin,:dispolimit)";
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
      $stmt->bindParam(':dispolimit', $dispolimit);
  
      // execute sql
      $stmt->execute();
      
      // return the message as json format
      echo '{"notice" : {"msg" : "New Giro Added."}';
  
    } catch( PDOException $e ) {
  
      // return error message as Json format
      echo '{"error": {"msg": ' . $e->getMessage() . '}';
    }
  });

  // create PUT HTTP request
$app->put('/giro/add/{id}', function( Request $request, Response $response){
    // get attribute from URL
    $id = $request->getAttribute('id');
    
    // get the parameter from the form submit
    $credit = $request->getParam('Guthaben');
    $pin = $request->getParam('PIN');
    
    $sql = "UPDATE girokonto 
            SET Guthaben = Guthaben + :credit 
            WHERE Kontonummer_GK = $id";
  
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
$app->put('/giro/sub/{id}', function( Request $request, Response $response){
    // get attribute from URL
    $id = $request->getAttribute('id');
    
    // get the parameter from the form submit
    $credit = $request->getParam('Guthaben');
    $pin = $request->getParam('PIN');
    
    //TODO: Error Handling when Guthaben + Dispolimit > credit

    $sql = "UPDATE girokonto 
            SET Guthaben = if(Guthaben + Dispolimit > :credit AND `PIN` = :pin,Guthaben - :credit,Guthaben) 
            WHERE Kontonummer_GK = $id";
  
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

  $app->post('/connectGiro', function( Request $request, Response $response){

    // get the parameter from the form submit
    $userID = $request->getParam('Kundennummer');
    $AccountID = $request->getParam('Kontonummer_GK');
    
    $sql = "INSERT INTO nutzergiro (Kundennummer, Kontonummer_GK) 
            VALUES(:kundennummer,:kontonummer_GK)";
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
      $stmt->bindParam(':kontonummer_GK', $AccountID);
  
      // execute sql
      $stmt->execute();
      
      // return the message as json format
      echo '{"notice" : {"msg" : "New User to Giro Added."}';
  
    } catch( PDOException $e ) {
  
      // return error message as Json format
      echo '{"error": {"msg": ' . $e->getMessage() . '}';
    }
  });