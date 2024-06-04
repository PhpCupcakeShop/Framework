<?php

namespace PhpCupcakes\Helpers;

class IconHelper
   {
       public static function renderIcon($link, $name, $attributes = [])
       {    

            if ($name == 'trash') {
                $html = '<a href="' . $link . '" onclick="return confirm(\'Are you sure?\')">';

            } else {
            $html = '<a href="' . $link . '">';
            }
            $html .= '<i class="fa fa-' . $name . '"';

            foreach ($attributes as $key => $val) {
               $html .= ' ' . $key . '="' . $val . '"';
           }

            $html .= '></i></a>';

            return $html;
       }
   }