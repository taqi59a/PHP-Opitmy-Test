<?php

class DB {
    private $pdo; // PDO connection object

    // Constructor to establish the database connection
    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=test'; // Data source name
        $user = 'root'; // Database username, default for XAMPP
        $password = ''; // Database password, default for XAMPP with no password

        try {
            // Create a new PDO instance with error mode set to exception
            $this->pdo = new PDO($dsn, $user, $password);
            // Set error mode to exception to handle any connection errors
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Handle any exceptions/errors
            die("DB connection failed: " . $e->getMessage());
        }
    }

    // Method to execute a SQL select query
    public function select($sql) {
        $stmt = $this->pdo->prepare($sql); // Prepare the SQL statement
        $stmt->execute(); // Execute the statement
        return $stmt->fetchAll(); // Return all rows
    }

    // Method to execute SQL queries like insert, update, delete
    public function exec($sql) {
        return $this->pdo->exec($sql); // Execute the SQL statement and return the number of affected rows
    }

    // Method to prepare and execute a SQL statement with parameters
    public function prepareAndExecute($sql, $params) {
        $stmt = $this->pdo->prepare($sql); // Prepare the SQL statement
        $stmt->execute($params); // Execute the statement with parameters
        return $stmt; // Return the statement object
    }

    // Method to get the last inserted ID
    public function lastInsertId() {
        return $this->pdo->lastInsertId(); // Return the last inserted ID from the database
    }
}

?>
