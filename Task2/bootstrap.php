<?php
/**
 * Created by PhpStorm.
 * User: hovsep
 * Date: 03.02.19
 * Time: 23:50
 */

//Autoloader
spl_autoload_register(function($className) {
    require_once 'lib/' . $className . '.php';
});

//Error page
set_exception_handler(function(Throwable $e) {
    echo 'Sorry. Something went wrong', '<br>', 'Details:' . $e->getMessage();
});