<?php
include "../core/database.php";

abstract class WebApi{

    public $db;
    public $result;

    function __construct()
    {
        $this->db = new Database();
        $this->result = array();
    }

    /**
     * Used for getting input values from json [from body]
     */
    function getDataInput(){
        return json_decode(file_get_contents('php://input'), true)[0];
    }

    /**
     * Used for printing GET headers 
     */
    function printHeaders(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->result, JSON_UNESCAPED_UNICODE);
    }
}
?>