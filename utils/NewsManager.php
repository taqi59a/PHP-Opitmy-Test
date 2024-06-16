<?php

require_once('NewsManager.php'); // Make sure to include the News class.

class NewsManager {
    private $db; // Property to hold the database connection.

    // Constructor with dependency injection of the database connection.
    public function __construct($db) {
        $this->db = $db; // Assign the passed database connection to the class property.
    }

    // Method to list all news items from the database.
    public function listNews() {
        $rows = $this->db->select('SELECT * FROM news'); // Execute a SELECT query to fetch all news items.
        $newsItems = []; // Initialize an array to hold the news objects.
        foreach ($rows as $row) {
            $news = new News(); // Create a new instance of the News class.
            // Set the news properties using setters.
            $news->setId($row['id'])
                 ->setTitle($row['title'])
                 ->setBody($row['body'])
                 ->setCreatedAt($row['created_at']);
            $newsItems[] = $news; // Add the news object to the array.
        }
        return $newsItems; // Return the array of news objects.
    }

    // Method to add a new news item to the database.
    public function addNews($title, $body) {
        // Prepare the SQL statement with placeholders for safety against SQL injection.
        $sql = "INSERT INTO news (title, body, created_at) VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($sql); // Prepare the SQL query.
        $stmt->execute([$title, $body]); // Execute the query with the provided values.
        return $this->db->lastInsertId(); // Return the ID of the newly inserted news item.
    }

    // Method to delete a news item by ID.
    public function deleteNews($id) {
        $sql = "DELETE FROM news WHERE id = ?";
        $stmt = $this->db->prepare($sql); // Prepare the SQL statement.
        $stmt->execute([$id]); // Execute the query with the news ID.
    }
}

?>
