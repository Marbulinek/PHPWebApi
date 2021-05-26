<?php
    function autoload_authentification_implementation($className)
    {
        $filename = "../moduls/authentification/implementation/" . $className . ".php";
        if (is_readable($filename)) {
            include_once $filename;
        }
    }

    function autoload_authentification_interfaces($className)
    {
        $filename = "../moduls/authentification/interfaces/" . $className . ".php";
        if (is_readable($filename)) {
            include_once $filename;
        }
    }

    function autoload_authentification_models($className)
    {
        $filename = "../moduls/authentification/models/" . $className . ".php";
        if (is_readable($filename)) {
            include_once $filename;
        }
    }

    spl_autoload_register("autoload_authentification_implementation");
    spl_autoload_register("autoload_authentification_interfaces");
    spl_autoload_register("autoload_authentification_models");
?>