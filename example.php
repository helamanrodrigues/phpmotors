<?php
$passwordPostInput = "example2021";
$hashOnDataBase = password_hash($passwordPostInput,PASSWORD_DEFAULT);
if (password_verify($passwordPostInput,$hashOnDataBase)){
    echo "Successful Login";
}else{
    echo "Wrong password";
}
?>