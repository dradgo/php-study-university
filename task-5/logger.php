<?php

// Define the LoggerInterface with the log method
interface LoggerInterface {
    public function log(string $message): void;
}

class DatabaseLogger implements LoggerInterface {
    protected $pdo;

    public function __construct() {
        // Initialize database connection
        $user = 'root';
        $password = 'mypass';
        $db = 'php_study';
        $host = '127.0.0.1';
        $port = 3306;
        $conn = mysqli_connect($host, $user, $password, $db);
        $this->pdo = $conn;
    }

    // Implement the log method as specified in the interface
    public function log(string $message): void {
        // Insert the log message into the database
        $sql = "INSERT INTO logs (message, created_at) VALUES (?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bind_param("s", $message);
        $stmt->execute();
        $stmt->close();
    }
}


// Usage example
$logger = new DatabaseLogger();
$logger->log("This is a test message.");

?>