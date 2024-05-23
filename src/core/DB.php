<?php
class DB {
    private $host = 'localhost';
    private $db = 'coffee_db';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8mb4';
    protected $pdo;

    public function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // Phương thức tiện ích để thực thi câu lệnh SELECT
    protected function query($sql, $params = []) {
    try {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        // Ghi log hoặc xử lý lỗi tại đây
        error_log($e->getMessage());
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
    }

    // Phương thức tiện ích để thực thi câu lệnh INSERT, UPDATE, DELETE
    protected function execute($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            // Ghi log hoặc xử lý lỗi tại đây
            error_log($e->getMessage());
            return false;
        }
    }
}
?>
