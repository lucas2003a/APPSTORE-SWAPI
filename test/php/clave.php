<?php

$clave = "123";
$claveEncriptada = password_hash($clave, PASSWORD_BCRYPT);

var_dump($claveEncriptada);