<img src="/phpmotors/images/site/logo.png" alt="logo PHP Motors">
<?php if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['loggedin']){
        echo "<h3> <a href='/phpmotors/accounts'>Welcome ".$_SESSION['clientData']['clientFirstname']."</a>";
        echo " | <a href='/phpmotors/accounts?action=Logout'>Logout</a> </h3>";
    }
    
} else{
    echo "<h3><a href='/phpmotors/accounts/index.php?action=". urlencode('login')."'>My Account</a> </h3>";
}?>
