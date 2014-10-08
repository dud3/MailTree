<?php

$arr_email = ["Assembly", "Mailing", "for", "-", "%", "6", "California"];
$arr_keyw = ["California", "Assembly", "Mailing"];


$out_arr = array_intersect($arr_email, $arr_keyw);

var_dump($out_arr);


