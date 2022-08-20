<?php
echo "<form action='complexLoginCheck.php' method='POST'>";
echo "<pre>";
echo "Username";
echo "   <input name='txtUsername' type='text' />";
echo "<br />Password";
echo "   <input name='txtPassword' type='password'/>";
// captcha form below from https://www.the-art-of-web.com/php/captcha/
echo "<p><img src='https://users.sussex.ac.uk/~lhjp20/login_Application_Student/captcha.php' width='120' height='30' border='1' alt='CAPTCHA'></p>";
echo "<p><input type='text' size='6' maxlength='5' name='captcha' value=''><br>";
echo "<small>Enter the digits above to complete the captcha.</small></p>";
echo "<br /> <br/> <input type='submit' value='Login'>";
echo "<br/> <br/> Not registered yet? Click <a href='registerForm.php'> HERE </a>";
echo "<br/> <br/> Forgotten password? Click <a href='passwordRecoveryForm.php'> HERE </a>";
echo "</pre>";
echo "</form>";
?>
