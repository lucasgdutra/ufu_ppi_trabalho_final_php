<?php
class Database {
    private $host = '127.0.0.1';
    private $db = 'mariadb';
    private $user = 'mariadb';
    private $pass = 'mariadb';
    private $charset = 'utf8mb4';
    private $dialect = 'mysql'; // Default to MySQL/MariaDB

    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    public $conn = null;

    public function __construct($dialect = 'mysql')
    {
        $this->dialect = $dialect;
        $this->connect();
    }

    private function connect()
    {
        if ($this->dialect == 'mysql' || $this->dialect == 'mariadb') {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        } elseif ($this->dialect == 'pgsql') {
            $dsn = "pgsql:host={$this->host};dbname={$this->db};options='--client_encoding={$this->charset}'";
        } elseif ($this->dialect == 'sqlite') {
            $dsn = "sqlite:{$this->db}.db";
        } else {
            throw new \InvalidArgumentException("Unsupported database dialect: {$this->dialect}");
        }

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $this->options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        $this->conn = null;
    }
}
