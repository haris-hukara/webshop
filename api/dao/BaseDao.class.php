<?php
require_once dirname(__FILE__)."/../config.php";

class BaseDao{
    

    protected $connection;

    public function __construct(){
        try {
          $this->connection = new PDO("mysql:host=".Config::DB_HOST.
                                         ";dbname=".Config::DB_SCHEME,
                                                    Config::DB_USERNAME,
                                                    Config::DB_PASSWORD);
  
          $this->connection->setAttribute(PDO::ATTR_ERRMODE,
                                          PDO::ERRMODE_EXCEPTION);
  
        } catch(PDOException $e) {
          throw $e;
        }
      }

        // key = column
        public function insert($tableName, $entity){
            $query = "INSERT INTO ${tableName} (";
            
            foreach ($entity as $column => $value) {
              $query .= $column.", ";
            }
            
            $query = substr($query, 0, -2);
            $query .= ") VALUES (";
            
            foreach ($entity as $column => $value) {
              $query .= ":".$column.", ";
            }

            $query = substr($query, 0, -2);
            $query .= ")";
        
            $stmt= $this->connection->prepare($query);
            $stmt->execute($entity);

            $entity['id'] = $this->connection->lastInsertId();
            return $entity;
          }


        public function update($tableName, $id, $entity, $id_column = "id"){
            $query = "UPDATE ${tableName} SET ";

            foreach($entity as $key => $value){
                $query .= $key ." = :". $key. ", ";
            }
            
            $query = substr($query, 0, -2);
            $query .= " WHERE ${id_column} = :id";
    
            $stmt = $this->connection->prepare($query);
            $entity['id'] = $id;
            $stmt->execute($entity);
        }


        public function query($query, $params){
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function query_unique($query, $params){
            $results = $this->query($query, $params);
            return reset($results);
        }





    }
    ?>