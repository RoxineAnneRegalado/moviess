<?php
include 'db.php';

if (isset($_GET['id'])) {
    $movie_id = intval($_GET['id']);

    // Delete movie from the database
    $sql = "DELETE FROM movies WHERE movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Movie deleted successfully.');
            window.location.href = 'movie_table.php';
        </script>";
    } else {
        echo "<script>
            alert('Error deleting the movie.');
            window.location.href = 'movie_table.php';
        </script>";
    }

    $stmt->close();
}

$conn->close();
?>
