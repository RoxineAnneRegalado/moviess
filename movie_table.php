<?php
include 'db.php';

$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <title>Movie List</title>
    <style>
        .add-movie-btn {
            position: absolute;
            right: 0; /* Align to the right */
            top: 10px; /* Place it above the table */
            display: inline-block;
            padding: 10px 15px;
            background-color: #28a745; /* Green color */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .add-movie-btn:hover {
            background-color: #0056b3;
        }

        .action-icon {
            cursor: pointer;
            font-size: 18px;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .action-icon.edit {
            color: #007bff; /* Blue for edit */
        }

        .action-icon.edit:hover {
            color: #0056b3;
        }

        .action-icon.delete {
            color: red; /* Red for delete */
        }

        .action-icon.delete:hover {
            color: darkred;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 15px;
        }

        .container {
            margin: 20px auto;
            max-width: 1000px;
            text-align: center;
        }
    </style>
    <script>
        function confirmDelete(id) {
            const confirmation = confirm("Are you sure you want to delete this movie?");
            if (confirmation) {
                window.location.href = `delete_movie.php?id=${id}`;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Movie List</h2>
        <a href="index.php" class="add-movie-btn">Add Movie</a> <!-- Add Movie Button -->
        <table id="movieTable" border="1" cellspacing="0" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Movie Title</th>
                    <th>Director</th>
                    <th>Release Date</th>
                    <th>Genre</th>
                    <th>Characters</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['movie_id']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['director']) ?></td>
                    <td>
                        <?= date("M d, Y", strtotime($row['release_date'])) ?> <!-- Full Date Format -->
                    </td>
                    <td><?= htmlspecialchars($row['genre']) ?></td>
                    <td><?= htmlspecialchars($row['characters']) ?></td>
                    <td>
                        <!-- Edit Icon -->
                        <a href="edit_movie.php?id=<?= $row['movie_id'] ?>" title="Edit">
                            <i class="fas fa-edit action-icon edit"></i>
                        </a>
                        <!-- Delete Icon -->
                        <i class="fas fa-trash action-icon delete" title="Delete" onclick="confirmDelete(<?= $row['movie_id'] ?>)"></i>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
