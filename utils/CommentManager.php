<?php

require_once('CommentManager.php'); // Include the Comment class for creating comment objects.

class CommentManager {
    private $db; // Database connection object

    // Constructor with dependency injection of the database connection.
    public function __construct($db) {
        $this->db = $db; // Assign the database connection to a class property.
    }

    // Method to list all comments from the database.
    public function listComments() {
        $rows = $this->db->select('SELECT * FROM comment'); // Execute a SELECT query to get all comments.
        $comments = []; // Initialize an empty array to store comment objects.
        foreach ($rows as $row) {
            $comment = new Comment(); // Create a new Comment object.
            $comments[] = $comment->setId($row['id']) // Set the ID of the comment.
                                  ->setBody($row['body']) // Set the body of the comment.
                                  ->setCreatedAt($row['created_at']) // Set the creation date of the comment.
                                  ->setNewsId($row['news_id']); // Set the associated news ID.
        }
        return $comments; // Return the array of comment objects.
    }

    // Method to add a new comment to a specific news item.
    public function addComment($body, $newsId) {
        $sql = "INSERT INTO comment (body, created_at, news_id) VALUES (?, NOW(), ?)";
        $stmt = $this->db->prepare($sql); // Prepare the SQL query.
        $stmt->execute([$body, $newsId]); // Execute the query with the provided values.
        return $this->db->lastInsertId(); // Return the ID of the newly created comment.
    }

    // Method to delete a comment by its ID.
    public function deleteComment($id) {
        $sql = "DELETE FROM comment WHERE id = ?";
        $stmt = $this->db->prepare($sql); // Prepare the SQL query.
        $stmt->execute([$id]); // Execute the query with the provided ID.
    }
}
