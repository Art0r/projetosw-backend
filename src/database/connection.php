<?php
class Connection
{
    private $instance;
    private $host;
    private $user;
    private $password;
    private $db;

    public function __construct()
    {
        $this->host = $_ENV["HOST"];
        $this->user = $_ENV["USER"];
        $this->password = $_ENV["PASSWORD"];
        $this->db = $_ENV["DATABASE"];
    }

    public function getConn()
    {
        try {
            $this->instance = new PDO("mysql:dbname=$this->db;host=$this->host", $this->user, $this->password);
        } catch (Exception $e) {
            error_log($e->getMessage());
            exit('Error connecting to database');
        }
        return $this->instance;
    }
}
