<?php
    spl_autoload_register('carregarClasses');

    function carregarClasses($class){
        if(file_exists('classes/'.$class.'.php')){
            require_once 'classes/'.$class.'.php';
        }
    }
?>