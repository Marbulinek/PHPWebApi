<?php
    function autoloadModels($className)
    {
        $filename = "../models/" . $className . ".php";
        if (is_readable($filename)) {
            include_once $filename;
        }
    }

    function autoloadControllers($className)
    {
        $filename = "../controllers/" . $className . ".php";
        if (is_readable($filename)) {
            include_once $filename;
        }
    }

    function autoloadCore($className)
    {
        $filename = "../core/" . $className . ".php";
        if (is_readable($filename)) {
            include_once $filename;
        }
    }

    function autoloadRepository($className)
    {
        $filename = "../core/repository/" . $className . ".php";
        if (is_readable($filename)) {
            include_once $filename;
        }
    }

    function autoloadServices($className)
    {
        $filename = "../services/" . $className . ".php";
        if (is_readable($filename)) {
            include_once $filename;
        }
    }

    spl_autoload_register("autoloadCore");
    spl_autoload_register("autoloadRepository");
    spl_autoload_register("autoloadModels");
    spl_autoload_register("autoloadControllers");
    spl_autoload_register("autoloadServices");

    // add autoloads from modules
    include_once "modules/authentification/autoload.php";
?>