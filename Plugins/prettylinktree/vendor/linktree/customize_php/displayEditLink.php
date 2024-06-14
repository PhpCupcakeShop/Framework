<?php
/*this would be a good file to copy/paste/edit to install with your user links example "Hi User! logout?" and "login | register"*/
       function displayEditLink() {
            if (isset($_SESSION['edit']) && $_SESSION['edit'] == 1) {
                include 'vendor/linktree/components/leaveEditModeLink.htm';
                if (isset($echo)) { echo $echo; }
            } else {
                include 'vendor/linktree/components/editModeLink.htm';
            }
        }
