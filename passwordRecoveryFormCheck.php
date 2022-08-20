<?php
include 'credentials.php'; 
session_start();
// values come from user, through webform
 $email =mysqli_real_escape_string($conn,$_POST['txtEmail']);
 $secQ1 = mysqli_real_escape_string($conn,$_POST['txtQ1']);
 $secQ2 = mysqli_real_escape_string($conn,$_POST['txtQ2']);
 $_SESSION['useremail'] =$email;
 
 
 // query
 $userQuery = "SELECT * FROM SystemUser";
 $userResult = $conn->query($userQuery);

 // flag variable
 $userFound = 0;
 
 

 echo "<table border='1'>";
 
  if ($userResult -> num_rows > 0)
  {
    while ($userRow = $userResult -> fetch_assoc())
    {
      if ($userRow['Email'] == $email)
      {
        $userFound = 1;
		$hash1 = $userRow['SecurityAns1'];
		$hash2 = $userRow['SecurityAns2'];
		$verify1 = password_verify($secQ1, $hash1);
		$verify2 = password_verify($secQ2, $hash2);
	 //password encryption check https://www.geeksforgeeks.org/how-to-encrypt-and-decrypt-passwords-using-php/
	  if($verify1 && $verify2){
		  echo "<form action='passwordUpdateCheck.php' method='POST'>";
		  echo "Security questions confirmed";
          echo "<br />Enter new password";
          echo "   <input name='txtPassword' type='password'/>";
		  echo "<br />Confirm new password";
          echo "   <input name='txtPassword2' type='password'/>";
		  echo "<br /> <br/> <input type='submit' value='Update Password'>";
		  echo "</pre>";
          echo "</form>";
		  }
	  else
	  {
	    echo "Incorrect security questions";
	  }
      }
    }
  }
  echo "</table>";

  if ($userFound == 0)
  {
   echo "This user was not found in our database";
  }

?>