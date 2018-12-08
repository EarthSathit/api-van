<?php
  define("hostname", "localhost");
  define("username", "tonrukfa_sathit1");
  define("password", "sathit1234");
  define("db", "tonrukfa_sathit");


  function connect(){
    $conn = new mysqli(hostname, username, password, db);
    $conn->set_charset('utf8');

    return $conn;
  }
 ?>
