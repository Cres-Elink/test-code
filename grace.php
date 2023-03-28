<?php
$url = $_GET['url'];
$hiyoca = $_GET['hiyoca'];
 $grace = header("location: $hiyoca",true, 301);
 $adv = header("location: $url",true, 301);
echo  $adv;

?>