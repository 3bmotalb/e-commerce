<?php 
include 'connect.php';
$temp = 'include/templete/';
$css = 'design/css/';
$js = 'design/js/';
$func='include/function/';

include $func . 'function.php';

include $temp . 'header.php';

if(!isset($nonav))
{
    include $temp .'navbar.php';
}