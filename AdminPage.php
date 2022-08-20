<?php
include 'credentials.php'; 
session_start();


if(!isset($_SESSION['admin'])){
    echo "<br/> You do not have permission to access this page.";
    header("Location:complexLoginForm.php");

}

echo "Welcome to the antique evaluation page <br/>";
echo "Here are the current evaluation requests and the preferred method of contact for each user that has requested evaluation.";
echo "<br/> <br/> To logout click <a href='logout.php'> HERE </a>";
echo "<br/><br/><br/><hr>";


$evalQuery = "SELECT * FROM EvaluationRequests";
$evalResult = $conn->query($evalQuery);

if($evalResult -> num_rows > 0)
while($info = $evalResult -> fetch_assoc()){
    echo "<b>Antique Evaluation requested by: <b/>".$info['User']."<br/>";
    echo "<img src=https://users.sussex.ac.uk/~lhjp20/login_Application_Student/Images/".$info['Image'] ."><br/>";
    echo "<b>Item Description: <b/>".$info['Item_Description']."<br/>";
    if($info['Contact_Method'] == "Phone"){
        echo "<br/> Preferred contact method: Phone <br/>";
        echo "<b>Telephone Number: <b/>".$info['Telephone_Number']."<br/>";
        echo "<br/><br/><br/><hr>";
    }
    if($info['Contact_Method'] == "Email"){
        echo "<br/> Preferred contact method: Email <br/>";
        echo "<b>Email: <b/>".$info['Email']."<br/>";
        echo "<br/><br/><br/><hr>";
    }
}

?>