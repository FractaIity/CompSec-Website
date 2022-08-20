<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

set_include_path('../login_Application_Student_V2/');

include 'credentials.php'; //credentials for the database so passwords are not hardcoded into the pages.
//require for phpmailer
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

 // Copy all of the data from the form into variables + sanitising input
 $forename = mysqli_real_escape_string($conn, $_POST['txtForename']);
 $surname = mysqli_real_escape_string($conn, $_POST['txtSurname']);
 $username = mysqli_real_escape_string($conn, $_POST['txtUsername']);
 $verification_key = md5($username);
 $telephonenumber = mysqli_real_escape_string($conn, $_POST['txtTelephone']);
 $email1 = mysqli_real_escape_string($conn, $_POST['txtEmail1']);
 $email2 = mysqli_real_escape_string($conn, $_POST['txtEmail2']);
 $password1 = mysqli_real_escape_string($conn, $_POST['txtPassword1']);
 $password2 = mysqli_real_escape_string($conn, $_POST['txtPassword2']);
 $secAns1 = mysqli_real_escape_string($conn, $_POST['txtSecQ1']);
 $secAns1_2 = mysqli_real_escape_string($conn, $_POST['txtSecQ1_2']);
 $secAns2 = mysqli_real_escape_string($conn, $_POST['txtSecQ2']);
 $secAns2_2 = mysqli_real_escape_string($conn, $_POST['txtSecQ2_2']);
 

 // Create a variable to indicate if an error has occurred or not, 0=false and 1=true. 
 $errorOccurred = 0;

 // Make sure that all text boxes were not blank.
 if ($forename == ""){
   echo "Forename was blank !<br/>";
   $errorOccurred = 1;}

 if ($surname == ""){
  echo "Surname was blank <br/>";
  $errorOccurred = 1;}

 if ($username==""){
  echo "username was blank !<br/>";
  $errorOccurred = 1;}
 
 if ($telephonenumber==""){
  echo "telephone number was blank !<br/>";
  $errorOccurred = 1;}
 
 if (strlen($telephonenumber) !=11){
  echo "Telephone number must be 11 digits long! <br/>";
  $errorOccurred =1;}

 if (!is_numeric($telephonenumber)){
  echo "Telephone number must only contain numbers! <br/>";
  $errorOccurred =1;}

 if ($email1=="" OR $email2==""){
   echo "Email not provided <br/>";
   $errorOccurred = 1;}

 if ($password1=="" OR $password2==""){
   echo "Password empty, check it. <br/>";
   $errorOccurred = 1;}
 
  if ($secAns1=="" OR $secAns2==""){
   echo "Security answers empty, check it. <br/>";
   $errorOccurred = 1;}
 
 //password entropy using tutorial https://www.codexworld.com/how-to/validate-password-strength-in-php/
$uppercase = preg_match('@[A-Z]@', $password1);
$lowercase = preg_match('@[a-z]@', $password1);
$number    = preg_match('@[0-9]@', $password1);
$specialChars = preg_match('@[^\w]@', $password1);

//password entropy check
if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password1) < 8) {
    echo 'Password should be at least 8 characters. Password should include at least one upper case letter, one number, and one special character.';
	$errorOccurred =1;
}

 // Check if username already exists in the database. 
 $userResult = $conn -> query("SELECT * FROM SystemUser");
 
 //Loop through from the first to the last record
 while ($userRow = mysqli_fetch_array($userResult))
 {
	 // CHeck to see if the curren user' username matchs the one from the user
	 if ($userRow['Username'] == $username)
	 {
	  echo "The username has already been used ! <br/>";
	  $errorOccurred = 1;
	 }
 }

 // Check to see if the email address is registered.
 $userResult = $conn -> query("SELECT * FROM SystemUser");

 // Loop from the first to the last record
 while ($userRow = mysqli_fetch_array($userResult))
 {
    // CHeck to see if the Email entered matches with any value in the database. 
    if ($userRow['Email'] == $email1)
    {
      echo "This email address has already been used. <br/>";
      $errorOccurred = 1;
    }
 }

 // Check to make sure that email address contain @
 if (strpos ($email1, "@") == false OR strpos($email2,"@") == false)
 {
  echo "The second email address are not valid <br/>";
 }

 // Check to make sure that emails match
 if($email1 != $email2)
  {
   echo "Emails do not match <br/>";
 }

 //Check to make sure that password values match
 if ($password1 != $password2)
 {
   echo "The passwords are different! Please re-enter and confirm they are the same. <br/>";
   $errorOccurred = 1; 
 }
 
  if ($secAns1 != $secAns1_2 OR $secAns2 != $secAns2_2)
 {
   echo "The security answers are different! Please re-enter and confirm they are the same. <br/>";
   $errorOccurred = 1; 
 }
 

 
 //Password Encryption https://www.geeksforgeeks.org/how-to-encrypt-and-decrypt-passwords-using-php/
 $hash = password_hash($password1, PASSWORD_DEFAULT);
 $secQ1Hash = password_hash($secAns1, PASSWORD_DEFAULT);
 $secQ2Hash = password_hash($secAns2, PASSWORD_DEFAULT);
 
 
   // Check to see if an error has occurred. Then add the details to the database. 
 if ($errorOccurred == 0)
 {
   // add all of the contents of the variables to the SystemUser table
    	
    $sql = "INSERT INTO SystemUser (Username, Password, Forename, Surname, Email, Telephone_Number, SecurityAns1, SecurityAns2, verification_key)
	  VALUES ('$username', '$hash', '$forename', '$surname', '$email1', '$telephonenumber', '$secQ1Hash', '$secQ2Hash' , '$verification_key')";
     if ($conn -> query ($sql) === TRUE)
      {
         // Thank the new user for joining.
	 echo htmlspecialchars("Hello " .$username);
   echo "<br/>";
	 echo "Thank you for joining Lovejoy's Antique Website.";
   
   //phpmailer code
   $subject = "Verify Your Account";

   $phpmailer = new PHPMailer();
   $phpmailer->isSMTP();
   $phpmailer->Mailer='smtp';
   $phpmailer->Host = 'smtp.gmail.com';
   $phpmailer->SMTPAuth = true;
   $phpmailer->SMTPSecure = 'ssl';
   $phpmailer->Port=465;
   $phpmailer->Username = $smtpuser;
   $phpmailer->Password = $smtppass;
 
   $phpmailer->setFrom('');
   $phpmailer->addAddress($email1); 
 
   $phpmailer->Subject = $subject;
   $phpmailer->Body    = "Your verification code is " .$verification_key . " Please verify your email address to activate your account by clicking on this link https://users.sussex.ac.uk/~lhjp20/login_Application_Student/verify.php";
 
			if(!$phpmailer->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
			} else {
			    echo ' An email has been sent to your inbox. Please verify your account.';
			}
      } 
 }
?>
