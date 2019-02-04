<?php

class Database {

    protected $host = 'localhost';
    protected $db = 'PHP_Validation';
    protected $username = 'root';
    protected $password = '';
    protected $stmt;
    protected $table;
    public $pdo;


    public function __construct(){
        try{
        $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->username, $this->password);
        }catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    } 

    public function table($table){
        $this->table=$table;
        return $this;
    }

  public function exists($data){
        $field= array_keys($data)[0];
        return $this->where($field, '=', $data[$field])->count() ? true : false;
  }

  public function where($field, $operator, $value){
        $sql="SELECT * FROM {$this->table} WHERE {$field} {$operator} ?";

        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute([$value]);
        return $this;
  }

  public function count(){
        return $this->stmt->rowCount();
  }

}