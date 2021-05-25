<?php
    /**
     * Abstract WebApi class
     */
    abstract class WebApi
    {
        public $db;
        public $result;
        public $mapper;
        public $auth;

        function __construct()
        {
            $this->db = new Database();
            $this->result = array();
            $this->mapper = new AutoMapper();
            $this->auth = new Authentification(); 
        }

        /**
         * Used for getting input values from json [from body]
         */
        function getDataInput(){
            return json_decode(file_get_contents('php://input'), true)[0];
        }

        /**
         * Used for authentificated data input
         */
        function getAuthDataInput()
        {
            $this->auth->validate();
            $data = json_decode(file_get_contents('php://input'), true)[0];
            return $data;
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

        /**
         * Get result data
         */
        function getResult($data){
            $this->result = $data;
        }
    }
?>