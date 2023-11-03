<?php 
  $dbname = "account";
  $user = "root";
  $password = "";
  $port = 3306;
  $dsn = "mysql:host=localhost;port=$port;dbname=$dbname;charset=UTF8";

  // $dbname = "accountbook";
  // $user = "root";
  // $password = "840111";
  // $host = "concise-atlas-403603:us-central1:littlekaotwdb";
  // $dsn = "mysql:unix_socket=/cloudsql/$host;dbname=$dbname";


  $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_CASE => PDO::CASE_NATURAL];
  $pdo = new PDO($dsn, $user, $password, $options);
?>