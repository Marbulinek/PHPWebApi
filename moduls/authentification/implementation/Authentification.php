<?php
/**
 * Authentification class
 */
class Authentification implements IAuthentification
{
    private $repository;
    private $validationQuery;
    private $mapper;

    function __construct()
    {
        $this->repository = new Repository(new Auth());
        $this->mapper = new AutoMapper();
    }

    /**
     * Validate request with token
     */
    public function validate()
    {
        $token = $this->getBearerToken();
        $auth = $this->repository->select()
                                 ->where(" `token` LIKE '".$token."' AND `expiration` > NOW()")
                                 ->build();

        if($token == null || empty($auth))
        {
            header('HTTP/1.1 401 Unauthorized');
            exit();
        }
    }

    /**
     * Refresh expiration data
     */
    public function refresh()
    {
        $authEntity = $this->getActualAuthEntity();

        $authEntity->expiration = $this->generateExpirationDateTime();

        $this->repository->update($authEntity)
                         ->build();
    }
    
    /**
     * Generate token and expiration datetime
     */
    public function generate()
    {
        $authEntity = $this->getActualAuthEntity();

        $authEntity->expiration = $this->generateExpirationDateTime();
        $authEntity->token = $this->generateTokenHash();

        $this->repository->update($authEntity)
                         ->build();
    }

    private function getActualAuthEntity()
    {
        // retrieve actual token
        $token = $this->getBearerToken();

        // select authentification entity from db
        $auth = $this->repository->select()
                ->where(" `token` LIKE '".$token."' ")
                ->build();
        
        $auth = $auth[0];
        $auth = $this->mapper->map($auth, new Auth());
        return $auth;
    }

    /**
     * Generate expiration datetime
     */
    private function generateExpirationDateTime()
    {
        $date = new DateTime();
        $date->add(new DateInterval('PT1H'));
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Generate token hash
     */
    private function generateTokenHash()
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * get bearer token
     */
    private function getBearerToken() 
    {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    /**
     * get authorization header
     */
    private function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
}
?>