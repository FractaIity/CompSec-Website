<?php
echo "<form action='registerFormCheck.php' method='POST'>";
echo "<h1> Please register your details below: </h1>";
echo "<pre>";
echo "Type in your Forename";
echo "       <input name='txtForename' type='text' />";
echo "<br/>Type in your Surname";
echo "        <input name='txtSurname' type='text' />";
echo "<br /> Type in your Username";
echo "       <input name='txtUsername' type='text' />";
echo "<br /> Type in your Telephone Number";
echo "       <input name='txtTelephone' type='text' />";
echo "<br/> Type in your Email address";
echo "  <input name='txtEmail1' type='text' />";
echo "<br/> Type your email address again";
echo "<input name='txtEmail2' type='text' />";
echo "<br/> Type in your password";
echo "       <input name='txtPassword1' type='password' />";
echo "<br/> Type your password again";
echo "     <input name='txtPassword2' type='password' />";
echo "<br/>Security Questions";
echo "<br/>What is your mother's maiden name?";
echo "       <input name='txtSecQ1' type='password' />";
echo "<br/> Type your answer again";
echo "     <input name='txtSecQ1_2' type='password' />";
echo "<br/>What is the name of the first school you attended?";
echo "       <input name='txtSecQ2' type='password' />";
echo "<br/> Type your answer again";
echo "     <input name='txtSecQ2_2' type='password' />";
echo "</pre>";

echo "<br/> <input type='submit' value='Register'>";
echo "</form>";
?>



























