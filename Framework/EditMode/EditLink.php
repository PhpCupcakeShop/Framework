<?php

namespace PhpCupcakes\EditMode;
use PhpCupcakes\Config\ConfigVars;

class EditLink {

/*this would be a good file to copy/paste/edit to install with your user links example "Hi User! logout?" and "login | register"*/
       public static function displayEditLink() {
            if (isset($_SESSION['edit']) && $_SESSION['edit'] == 1) {
                include ConfigVars::getDocRoot() . '/Views/components/editmode/leaveEditModeLink.phtml';       /*linkhere*/
                if (isset($echo)) { echo $echo; }
            } else {
                include ConfigVars::getDocRoot() . '/Views/components/editmode/editModeLink.phtml';       /*linkhere*/
            }
        }
        
    public static function displayEditModeNav() {
        if (isset($_SESSION['edit']) && $_SESSION['edit'] == 1) {
            include ConfigVars::getDocRoot() . '/Views/components/editmode/inEditMode.phtml';       /*linkhere*/
            if (isset($echo)) { echo $echo; }
        } else {
            include ConfigVars::getDocRoot() . '/Views/components/editmode/outOfEditMode.phtml';       /*linkhere*/
        }
    }
    }
