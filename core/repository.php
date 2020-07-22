<?php
    class Repository{
        
        public $repository;
        private $db;
        private $outputSQL;
        private $mapper;
        private $queryState;

        function __construct($repository)
        {
            $this->repository = $repository;
            $this->db = new Database();
            $this->mapper = new Automapper();
        }

        function select($params = "*")
        {
            $params = $this->db->escape($params);
            $this->queryState = QueryState::SELECT;

            $columns = "";
            $params = explode(',', $params);
            
            foreach ($params as $key=>$value) 
            {      
                    $arrayKey = trim(current($params));
                    $columns .= "`".$arrayKey."`," . " ";
                    next($params);
            }
            $columns = trim(rtrim($columns, ", "));

            $this->outputSQL = sprintf('SELECT %s FROM `%s` ', $columns, get_class($this->repository));
            return $this;
        }

        function where($params)
        {
            $this->outputSQL .= sprintf('WHERE %s', $params);
            return $this;
        }

        function order($params)
        {
            $this->outputSQL .= sprintf('ORDER BY %s', $params);
            return $this;
        }

        function group($params)
        {
            $this->outputSQL .= sprintf('GROUP BY %s', $params);
            return $this;
        }

        function insert($params)
        {
            $this->queryState = QueryState::INSERT;
            $propertiesArray = $params->getProperties();

            $columns = "";
            $values = "";
            foreach ($propertiesArray as $key=>$value)
            {      
                $arrayKey = key($propertiesArray);

                if(current($propertiesArray) != null){
                    $columns .= "`".$arrayKey."`," . " ";
                    $values .= "\"".current($propertiesArray)."\"," . " ";
                }

                next($propertiesArray);
            }

            $columns = rtrim($columns, ", ");
            $values = rtrim($values, ", ");

            $this->outputSQL = sprintf("INSERT INTO `%s` (%s) VALUES ( %s )", get_class($this->repository), $columns, $values);
            return $this;
        }

        function update($params)
        {
            $this->queryState = QueryState::UPDATE;
            $propertiesArray = $params->getProperties();

            //find ID
            $id = $this->repository->getID();

            $sql = "";
            $foundIds = array();
            foreach ($propertiesArray as $key=>$value)
            {       
                $arrayKey = key($propertiesArray);
                $arrayValue = current($propertiesArray);

                if(in_array($arrayKey, $id)){
                    $foundIds[] = $arrayValue;
                }else{
                    if($arrayValue != null)
                    {
                        $sql .= "`".$arrayKey."` = \"".$arrayValue."\"," . " ";
                    }
                }

                next($propertiesArray);
            }
            $sql = rtrim($sql, ", ");

            $this->outputSQL = sprintf("UPDATE `%s` SET %s", get_class($this->repository), $sql);

            $idsString = null;
            for($i = 0; $i < count($foundIds); $i++)
            {
                $idsString .= sprintf("`%s` = \"%s\" AND ", $id[$i], $foundIds[$i]);
            }
        
            $idsString = rtrim($idsString, "AND ");
            $this->outputSQL .= sprintf(" WHERE %s ", $idsString);

            return $this;
        }

        function delete($params)
        {
            $this->queryState = QueryState::DELETE;
            $propertiesArray = $params->getProperties();

            //find ID
            $id = $this->repository->getID();

            $sql = "";
            $foundIds = array();
            foreach ($propertiesArray as $key=>$value)
            {       
                $arrayKey = key($propertiesArray);
                $arrayValue = current($propertiesArray);

                if(in_array($arrayKey, $id)){
                    $foundIds[] = $arrayValue;
                }else{
                    if($arrayValue != null)
                    {
                        $sql .= "`".$arrayKey."` = \"".$arrayValue."\"," . " ";
                    }
                }

                next($propertiesArray);
            }
            $sql = rtrim($sql, ", ");

            $this->outputSQL = sprintf("DELETE FROM `%s`", get_class($this->repository), $sql);

            $idsString = null;
            for($i = 0; $i < count($foundIds); $i++)
            {
                $idsString .= sprintf("`%s` = \"%s\" AND ", $id[$i], $foundIds[$i]);
            }
        
            $idsString = rtrim($idsString, "AND ");
            $this->outputSQL .= sprintf(" WHERE %s ", $idsString);

            return $this;
        }

        function build()
        {
            $result = [];

            switch($this->queryState)
            {
                case QueryState::SELECT: 
                    $query = $this->db->query($this->outputSQL);
                    while($row = $query->fetch_array(MYSQLI_ASSOC)){
                        $result[] = $this->mapper->map($row, new $this->repository);
                    }
                break;

                case QueryState::INSERT:
                    $result = $this->db->queryRetID($this->outputSQL);
                break;

                case QueryState::UPDATE:
                    $this->db->query($this->outputSQL);
                break;

                case QueryState::DELETE:
                    $this->db->query($this->outputSQL);
            }

            return $result;
        }
    }
?>