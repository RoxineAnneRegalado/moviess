<?php
include 'db.php';

if (isset($_GET['id'])) {
    $movieId = $_GET['id'];
    $result = $conn->query("SELECT * FROM movies WHERE movie_id = '$movieId'");
    $movie = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = $_POST['movieId'];
    $title = $_POST['title'];
    $director = $_POST['director'];
    $releaseDate = $_POST['releaseDate'];
    $genre = $_POST['genre'];
    $characters = isset($_POST['characters']) ? implode(", ", $_POST['characters']) : '';

    $stmt = $conn->prepare("UPDATE movies SET title=?, director=?, release_date=?, genre=?, characters=? WHERE movie_id=?");
    $stmt->bind_param("ssssss", $title, $director, $releaseDate, $genre, $characters, $movieId);

    if ($stmt->execute()) {
        header("Location: movie_table.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>Edit Movie</title>
<style>
    #charactersContainer label {
        display: inline-block;
        width: 120px;
        margin-right: 322px;
        vertical-align: top;
        text-align: left;
        font-family: "Tempus Sans ITC";
    }

    #characterName, .character-input {
        width: calc(95% - 110px);
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    #addCharacterBtn {
        display: inline-block;
        width: 150px;
        background-color: #ff0000;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    #addCharacterBtn:hover {
        background-color: green;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    select:focus {
        outline: none;
        border-color: #ff5722;
        box-shadow: 0 0 10px rgba(255, 87, 34, 0.5);
        background-color: #e0f7fa;
    }

    ::placeholder {
        font-family: "Bradley Hand ITC";
        color: black;
        font-weight: bold;
    }
</style>
    }
</style>
</head>
<body>
    <form id="movieForm" method="POST" action="">
        <h2>Edit Movie</h2>

        <label for="movieId">Movie ID</label>
        <input type="text" id="movieId" name="movieId" value="<?= htmlspecialchars($movie['movie_id']) ?>" readonly><br><br>

        <label for="title">Movie Title</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required><br><br>

        <label for="director">Director</label>
        <input type="text" id="director" name="director" value="<?= htmlspecialchars($movie['director']) ?>" required><br><br>

        <label for="releaseDate">Release Date</label>
        <input type="date" id="releaseDate" name="releaseDate" 
               value="<?= htmlspecialchars($movie['release_date']) ?>" required><br><br>

        <label for="genre">Genre</label>
        <select id="genre" name="genre" required>
            <option value="Comedy" <?= $movie['genre'] === 'Comedy' ? 'selected' : '' ?>>Comedy</option>
            <option value="Drama" <?= $movie['genre'] === 'Drama' ? 'selected' : '' ?>>Drama</option>
            <option value="Fantasy" <?= $movie['genre'] === 'Fantasy' ? 'selected' : '' ?>>Fantasy</option>
            <option value="Action" <?= $movie['genre'] === 'Action' ? 'selected' : '' ?>>Action</option>
            <option value="Science-Fiction" <?= $movie['genre'] === 'Science-Fiction' ? 'selected' : '' ?>>Science-Fiction</option>
        </select><br><br>

        <label>Characters</label>
        <div id="charactersContainer">
            <?php
            $characters = explode(", ", $movie['characters']);
            foreach ($characters as $character) {
                echo "<input type='text' name='characters[]' value='" . htmlspecialchars($character) . "' class='character-input' placeholder='Enter Character Name' required>";
            }
            ?>
        </div>

        <button type="button" id="addCharacterBtn">Add Character</button><br><br>

        <input type="submit" value="Save Changes" class="button">
    </form>

    <script>
        // Add additional character fields
        document.getElementById('addCharacterBtn').addEventListener('click', function () {
            const container = document.getElementById('charactersContainer');
            const characterInput = document.createElement('input');
            characterInput.type = 'text';
            characterInput.name = 'characters[]';
            characterInput.placeholder = 'Enter Character Name';
            characterInput.required = true;
            characterInput.className = 'character-input';
            container.appendChild(characterInput);
        });
    </script>
</body>
</html>
