<?php
session_start();

echo "<br/> Successfully logged out. <br/>";
session_destroy();
header("Location:complexLoginForm.php");



?>