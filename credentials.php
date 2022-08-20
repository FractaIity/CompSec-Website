<?php
// Server and db connection
 $mysql_host="";
 // 
 $mysql_database="";    // name of the database, it is empty for now
 $mysql_user="";    // type your username
 $mysql_password="";  //  type the password, it is Mysql_<Personcod> You will need to replace person code with number from your ID card.
 // 

// Create connection
$conn = new mysqli($mysql_host, $mysql_user,$mysql_password, $mysql_database);

 // Check connection
 if ($conn->connect_error)
 {
  die ("Connection failed" .$conn->connect_error);
  }

  //credientials for SMTP using mailtrap.io
  //stored into credientials.php to avoid hardcoding credentials in the pages

  $smtpuser = "";
  $smtppass = "";

?>