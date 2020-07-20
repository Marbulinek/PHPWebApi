<?php
include_once "database.php";
include_once "automapper.php";

abstract class WebApi{

    public $db;
    public $result;
    public $mapper;

    function __construct()
    {
        $this->db = new Database();
        $this->result = array();
        $this->mapper = new Automapper();
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
        //return api
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->result, JSON_UNESCAPED_UNICODE);
    }
}
?>