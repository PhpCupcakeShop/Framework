<?php
/*this would be a good file to copy/paste/edit for installing with your user authorization logic for CUD operations*/
if (isset($_GET['startsession']) && $_GET['startsession'] == "edit") {
    $echo = '<br>You are now in edit mode.';
    $_SESSION['edit'] = 1;
    header('Location: '.$_GET['redirect']);
} else {
    $echo = '';
    
}

if (isset($_GET['endsession']) && $_GET['endsession'] == "edit") {
    //set this to be sure and...
    $_SESSION['edit'] = 0;
    //destroy
    session_destroy();
    header('Location: '.$_GET['redirect']);
} else {
    
}