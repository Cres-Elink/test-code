<?php
    $str = "09125323234Grasya";
    $delete  = preg_replace('~\D~', '', $str);
    echo $delete;
?>