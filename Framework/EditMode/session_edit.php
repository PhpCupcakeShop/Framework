<?php
/*this would be a good file to copy/paste/edit for installing with your user authorization logic for CRUD operations*/
if (isset($_POST['startsession']) && $param2nth == "on") {
    $echo = '<br>You are now in edit mode.';
    echo $echo;
    $returnurl = urldecode($_POST['returnurl']);
    $_SESSION['edit'] = 1;
    header('Location: '.$returnurl);
} else {
    $echo = '';
    
}

if (isset($_POST['endsession']) && $param2nth == "off") {
    $echo = '<br>You are now leaving edit mode.';
    echo $echo;
    //set this to be sure and...
    $returnurl = urldecode($_POST['returnurl']);
    $_SESSION['edit'] = 0;
    //destroy
    session_destroy();
    header('Location: '.$returnurl);
} else {
    
}