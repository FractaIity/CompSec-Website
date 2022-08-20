<?php
include 'credentials.php'; 
  session_start();
// values come from user, through webform
 $email = $_SESSION['useremail'];
 $password1 = mysqli_real_escape_string($conn,$_POST['txtPassword']);
 $password2 = mysqli_real_escape_string($conn,$_POST['txtPassword2']);
  // Create a variable to indicate if an error has occurred or not, 0=false and 1=true. 
 $errorOccurred = 0;
 
 

 // query
 $userQuery = "SELECT * FROM SystemUser";
 $userResult = $conn->query($userQuery);

 // flag variable
 $userFound = 0;
// query
 $userQuery = "SELECT * FROM SystemUser";
 $userResult = $conn->query($userQuery);

 // flag variable
 $userFound = 0;
 
 //checking if password is secure
  if ($password1=="" OR $password2==""){
   echo "Password empty, check it. <br/>";
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
//Check to make sure that password values match
 if ($password1 != $password2){
   echo "The passwords are different! Please re-enter and confirm they are the same. <br/>";
   $errorOccurred = 1; 
 }
 //Password Encryption https://www.geeksforgeeks.org/how-to-encrypt-and-decrypt-passwords-using-php/
 $hash = password_hash($password1, PASSWORD_DEFAULT);

 echo "<table border='1'>";
  if($errorOccurred == 0){
  if ($userResult -> num_rows > 0)
  {
    while ($userRow = $userResult -> fetch_assoc())
    {
      if ($userRow['Email'] == $email)
      {
        $sql = "UPDATE SystemUser SET Password='$hash' WHERE Email='$email'";
		if ($conn->query($sql) === TRUE){
		echo "Password updated successfully";} 
		else{
	    echo "Error updating password: " . $conn->error;}
      }
    }
  }
  } else {
	  echo "Ensure passwords are the same and contain at least one capital letter, number and symbol!";
  }
  echo "</table>";

?>