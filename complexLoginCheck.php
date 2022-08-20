<?php
include 'credentials.php'; 

session_start();

// values come from user, through webform // input sanitised where needed
 $username = mysqli_real_escape_string($conn,$_POST['txtUsername']);
 $password =  mysqli_real_escape_string($conn,$_POST['txtPassword']);
 $ip = $_SERVER["REMOTE_ADDR"]; //gets ip address of user logging in - used to protect against brute force attacks
 $_SESSION['username'] =  mysqli_real_escape_string($conn,$_POST['txtUsername']);
 $_SESSION['user'] = $username; //tracks who is logged in
 
 //Captcha form check -- https://www.the-art-of-web.com/php/captcha/
 if($_POST && "all required variables are present") {
  if($_POST['captcha'] != $_SESSION['digit']) {
    die("Sorry, the CAPTCHA code entered was incorrect! <br/> <br/> To go back to the login page click <a href='complexLoginForm.php'> HERE </a>");
    session_destroy();
  }
}


 // query
 $userQuery = "SELECT * FROM SystemUser";
 $userResult = $conn->query($userQuery);

 // flag variable
 $userFound = 0;
 
 //used for checking the amount of times an IP has used incorrect login details -- after 3 incorrect attempts the user is blocked for 10 minutes
 //https://stackoverflow.com/questions/37120328/how-to-limit-the-number-of-login-attempts-in-a-login-script/37120660
 $result = mysqli_query($conn, "SELECT COUNT(*) FROM `ip` WHERE `address` LIKE '$ip' AND `timestamp` > (now() - interval 10 minute)");
 $count = mysqli_fetch_array($result, MYSQLI_NUM);

 echo "<table border='1'>";
 
  if ($userResult -> num_rows > 0)
  {
    while ($userRow = $userResult -> fetch_assoc())
    {
      if ($userRow['Username'] == $username)
      {
        $userFound = 1;
		$hash = $userRow['Password'];
    $verified = $userRow['active']; //checks if account has been verified by email
		$verify = password_verify($password, $hash);
    $admin = $userRow['Admin'];

	 //password encryption check https://www.geeksforgeeks.org/how-to-encrypt-and-decrypt-passwords-using-php/
	  if($verify && $count[0] <=2 && ($verified == 1)){
      if($admin !=1){
      echo "<form enctype='multipart/form-data' action='requestEvaluationCheck.php' method='POST'>";
		  echo htmlspecialchars("Hi " .$username . "!");
	      echo "<br/> Welcome to Lovejoy's Antique Evaluation website";
        echo "<br/>";
        echo "<br/> Start evaluation request";
        echo "<br/>";
        echo "<br/> What is your preferred method of contact?";
        echo "<br /><select name='contactMethod'><option value=''>Select...</option><option value='Phone'>Phone</option><option value='Email'>Email</option></select>";
        echo "<br/>";
        echo "<br/> Write a description of the item in the box below:";
        echo "<br/>   <textarea name='txtComment' type='comment' rows='5' cols='40' type='text'>"; 
        echo "</textarea>"; 
        echo "<br/><br/> *optional* Upload a photo of the antique";
        echo "<br/><input type='file' name='photo' accept='.png,.jpg,.jpeg'>";
        echo "<br/> <br/> <input type='submit' value='Submit Evaluation Request'>";
        echo "<br/> <br/> To logout click <a href='logout.php'> HERE </a>";
        echo "</form>";} else {
          $_SESSION['admin']= 1;
          echo "<br/>";
          echo htmlspecialchars(" Hi " .$username . "!");
          echo "<br/> <br/> Click <a href='AdminPage.php'> HERE </a>";
          echo "to view new antique evaluation requests!";
        }
	  }
	  else
	  {
      if($verified !=1){
        echo "Your email has not been verified. Please check your email for your code.";
      }
      if($count[0] >= 3){
        echo "<br/> Login attempts exceeded <br/>";}
        else {
          echo "Incorrect login details";
          mysqli_query($conn, "INSERT INTO `ip` (`address` ,`timestamp`)VALUES ('$ip',CURRENT_TIMESTAMP)");
        }  
      echo "<br/> <br/> Go back to the login page <a href='complexLoginForm.php'> here</a>";
	  }
      }
    }
  }

  if ($userFound == 0)
  {
   echo "This user was not found in our database";
  }

?>
