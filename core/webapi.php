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
            if(CORS)
            {
                $this->cors();
            }
            return json_decode(file_get_contents('php://input'), true);
        }

        /**
         * Used for authentificated data input
         */
        function getAuthDataInput()
        {
            if(CORS)
            {
                $this->cors();
            }
            $this->auth->validate();
            return json_decode(file_get_contents('php://input'), true);
        }
       
        /**
         * Used for printing GET headers 
         */
        function getResponse()
        { 
            if(CORS)
            {
                $this->cors();
            }
            header('Content-Type: application/json; charset=utf-8');
            //Allow from any origin
            echo json_encode($this->result, JSON_UNESCAPED_UNICODE);
        }

        /**
         * Get result data
         */
        public function setResult($data)
        {
            $this->result = $data;
        }

        /**
         * CORS policy
         */
        private function cors() 
        {
            // Allow from any origin
            if (isset($_SERVER['HTTP_ORIGIN'])) 
            {
                // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
                // you want to allow, and if so:
                header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 86400');    // cache for 1 day
            }
            
            // Access-Control headers are received during OPTIONS requests
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
            {
                
                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                    // may also be using PUT, PATCH, HEAD etc
                    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
                
                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            
                exit(0);
            }
        }
    }
?>