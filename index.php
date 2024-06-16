<?php

require_once 'utils/DB.php';
require_once 'utils/NewsManager.php';
require_once 'utils/CommentManager.php';

// Create a new database connection instance.
$db = new DB();

// Instantiate the NewsManager with the DB connection.
$newsManager = new NewsManager($db);

// Instantiate the CommentManager with the DB connection.
$commentManager = new CommentManager($db);

// Fetch all news items.
$newsItems = $newsManager->listNews();

// Display each news item and its comments.
foreach ($newsItems as $news) {
    echo "<h1>News: " . htmlspecialchars($news->getTitle()) . "</h1>";
    echo "<p>" . nl2br(htmlspecialchars($news->getBody())) . "</p>";
    
    // Fetch comments for the current news item.
    $comments = $commentManager->listCommentsByNewsId($news->getId());
    if (count($comments) > 0) {
        echo "<h3>Comments:</h3>";
        echo "<ul>";
        foreach ($comments as $comment) {
            echo "<li>" . htmlspecialchars($comment->getBody()) . " (Posted on: " . htmlspecialchars($comment->getCreatedAt()) . ")</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No comments yet.</p>";
    }
}

?>
