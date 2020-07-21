<?php

function autoloadModels($className)
{
    $className = strtolower($className);
    $filename = "../models/" . $className . ".php";
    if (is_readable($filename)) {
        include_once $filename;
    }
}

function autoloadControls($className)
{
    $className = strtolower($className);
    $filename = "../controls/" . $className . ".php";
    if (is_readable($filename)) {
        include_once $filename;
    }
}

function autoloadCore($className)
{
    $className = strtolower($className);
    $filename = "../core/" . $className . ".php";
    if (is_readable($filename)) {
        include_once $filename;
    }
}

function autoloadRepository($className)
{
    $className = strtolower($className);
    $filename = "../core/repository/" . $className . ".php";
    if (is_readable($filename)) {
        include_once $filename;
    }
}

spl_autoload_register("autoloadCore");
spl_autoload_register("autoloadRepository");
spl_autoload_register("autoloadModels");
spl_autoload_register("autoloadControls");
?>