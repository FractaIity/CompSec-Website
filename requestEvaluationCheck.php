<?php
include 'credentials.php'; 
session_start();
// flag variable
$userFound = 0;

$username = $_SESSION['username'];
$comment =  mysqli_real_escape_string($conn,$_POST['txtComment']);
$uploadOk = 1;
$target = "Images/";
$target = $target . basename( $_FILES['photo']['name']);
$imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
$pic= mysqli_real_escape_string($conn,($_FILES['photo']['name']));
$contactMethod =  mysqli_real_escape_string($conn,$_POST['contactMethod']);
$errorOccurred = 0;

// query for SystemUser
$userQuery = "SELECT * FROM SystemUser";
$userResult = $conn->query($userQuery);


if($contactMethod ==''){
    echo "<br/>Please select contact method! <br/>";
    $errorOccurred =1;
}

if ($userResult -> num_rows > 0){
  while ($userRow = $userResult -> fetch_assoc()){
    if ($userRow['Username'] == $username){
      $userFound = 1;
      $userEmail = $userRow['Email'];
      $userTelephone = $userRow['Telephone_Number'];
      break;
    }
  } 
}

if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
  echo "File uploaded must be an image! Only JPG, JPEG and PNG files are accepted!";
  $uploadOk = 0;
}

 if ($errorOccurred == 0){
   // add all of the contents of the variables to the SystemUser table
    if($uploadOk ==1 ){
    $sql = "INSERT INTO EvaluationRequests (User, Telephone_Number, Email, Contact_Method, Item_Description, Image)
	  VALUES ('$username', '$userTelephone', '$userEmail', '$contactMethod', '$comment', '$pic' )";
     if ($conn -> query ($sql) === TRUE)
      {
	    echo "Your evaluation request has been received.";
        echo "<br/> Your antique will be reviewed and you will be contacted via your preferred contact method.";
        echo "<br/> Thank you for using Lovejoy's Antique Evaluation website";
        if(move_uploaded_file($_FILES['photo']['tmp_name'],$target)){
            echo "<br/>";
            echo htmlspecialchars("The file ". basename($_FILES['photo']['name']). " has been uploaded"); //htmlspecialchars added to protect against xss 

        }
      } 
    }
 }

?>