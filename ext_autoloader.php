<?php

function autoloader($class) {
    // strtolower() is used to avoid case issues
    require_once 'classes/ext_' . strtolower($class) . '.class.php';
}

spl_autoload_register('autoloader');