<?php

    function displayAddLink() {
                    ob_start();
                if (isset($_SESSION['edit']) && $_SESSION['edit'] == 1) {
                    include 'vendor/linktree/components/inEditMode.htm';
                } else {
                    include 'vendor/linktree/components/outOfEditMode.htm';
                }
                    $addLink = ob_get_clean();
                    echo $addLink;
            }
?>