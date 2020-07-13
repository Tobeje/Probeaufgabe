<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// create GET HTTP request
$app->get('/nutzer', function( Request $request, Response $response){
     $sql = "SELECT * FROM nutzer";
 
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

// create POST HTTP request
$app->post('/nutzer', function( Request $request, Response $response){

  // get the parameter from the form submit
  $lastname = $request->getParam('Nachname');
  $firstname = $request->getParam('Vorname');
  $date = $request->getParam('Geburtsdatum');
  $gender = $request->getParam('Geschlecht');
  
  $sql = "INSERT INTO nutzer (Nachname, Vorname, Geburtsdatum, Geschlecht) 
          VALUES(:lastname,:firstname,:date,:gender)";
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
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':gender', $gender);

    // execute sql
    $stmt->execute();
    
    // return the message as json format
    echo '{"notice" : {"msg" : "New User Added."}';

  } catch( PDOException $e ) {

    // return error message as Json format
    echo '{"error": {"msg": ' . $e->getMessage() . '}';
  }
});

// create PUT HTTP request
$app->put('/nutzer/{id}', function( Request $request, Response $response){
  // get attribute from URL
  $id = $request->getAttribute('id');
  
  // get the parameter from the form submit
  $lastname = $request->getParam('Nachname');
  $firstname = $request->getParam('Vorname');
  $date = $request->getParam('Geburtsdatum');
  $gender = $request->getParam('Geschlecht');
  
  $sql = "UPDATE nutzer SET 
          Nachname = :lastname,
          Vorname = :firstname,
          Geburtsdatum = :date,
          Geschlecht = :gender
          WHERE Kundennummer = $id";

  try {
    // Get DB Object
    $db = new db();

    // connect to DB
    $db = $db->connect();

    // https://www.php.net/manual/en/pdo.prepare.php
    $stmt = $db->prepare( $sql );

    // bind each paramenter
    // https://www.php.net/manual/en/pdostatement.bindparam.php
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':gender', $gender);

    // execute sql
    $stmt->execute();
    
    // return the message as json format
    echo '{"notice" : {"msg" : "User Updated."}';

  } catch( PDOException $e ) {

    // return error message as Json format
    echo '{"error": {"msg": ' . $e->getMessage() . '}';
  }
});