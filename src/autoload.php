<?php

require("lib/Casper-API-Developers-PHP/CasperDevelopersAPI.php");
require("lib/JsonMapper/JsonMapper.php");
require("lib/JsonMapper/JsonMapperException.php");

spl_autoload_register(function($class){

    $prefix = "Snapchat\\";
    $base_dir = __DIR__ . "/";

    $len = strlen($prefix);
    if(strncmp($prefix, $class, $len) !== 0){
        return;
    }

    $relative_class = substr($class, $len);

    $file = $base_dir . str_replace("\\", "/", $relative_class) . ".php";

    if(file_exists($file)){
        require($file);
    }

});