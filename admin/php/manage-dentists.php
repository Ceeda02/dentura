<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginadmin.php");
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Use your database password
$dbname = "dentura"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                // Logic to add a new dentist with a photo
                $name = $_POST['name'];
                
                // Handle the image upload
                $photo = $_FILES['photo'];
                $target_dir = "uploads/"; // Ensure this directory exists and is writable
                $target_file = $target_dir . basename($photo['name']);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if the file is an actual image
                $check = getimagesize($photo['tmp_name']);
                if ($check === false) {
                    $_SESSION['message'] = "File is not an image.";
                    $uploadOk = 0;
                }

                // Check file size (5MB limit)
                if ($photo['size'] > 5000000) {
                    $_SESSION['message'] = "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow only certain file formats
                $allowed_file_types = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($imageFileType, $allowed_file_types)) {
                    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // If the image passes all checks, proceed with the upload and database insertion
                if ($uploadOk === 1) {
                    if (move_uploaded_file($photo['tmp_name'], $target_file)) {
                        // Prepare the insert statement with the image path
                        $stmt = $conn->prepare("INSERT INTO dentists (name, photo) VALUES (?, ?)");
                        $stmt->bind_param("ss", $name, $target_file);

                        if ($stmt->execute()) {
                            $_SESSION['message'] = "Dentist added successfully.";
                        } else {
                            $_SESSION['message'] = "Error adding dentist: " . $stmt->error;
                        }

                        $stmt->close();
                    } else {
                        $_SESSION['message'] = "Sorry, there was an error uploading your file.";
                    }
                }
                break;

            case 'update':
                // Logic to update an existing dentist's name and photo if provided
                $id = $_POST['id'];
                $name = $_POST['name'];
                $photoPath = null;

                // Handle the image update if a new file is uploaded
                if (!empty($_FILES['photo']['name'])) {
                    $photo = $_FILES['photo'];
                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($photo['name']);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    $check = getimagesize($photo['tmp_name']);
                    if ($check && $photo['size'] <= 5000000 && in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                        if (move_uploaded_file($photo['tmp_name'], $target_file)) {
                            $photoPath = $target_file;
                        } else {
                            $_SESSION['message'] = "Error uploading file.";
                        }
                    }
                }

                // Update the database with the new name and optional photo path
                if ($photoPath) {
                    $stmt = $conn->prepare("UPDATE dentists SET name = ?, photo = ? WHERE id = ?");
                    $stmt->bind_param("ssi", $name, $photoPath, $id);
                } else {
                    $stmt = $conn->prepare("UPDATE dentists SET name = ? WHERE id = ?");
                    $stmt->bind_param("si", $name, $id);
                }

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Dentist updated successfully.";
                } else {
                    $_SESSION['message'] = "Error updating dentist: " . $stmt->error;
                }
                $stmt->close();
                break;

            case 'delete':
                // Logic to delete a dentist
                $id = $_POST['id'];
                $stmt = $conn->prepare("DELETE FROM dentists WHERE id = ?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $_SESSION['message'] = "Dentist deleted successfully.";
                } else {
                    $_SESSION['message'] = "Error deleting dentist: " . $stmt->error;
                }
                $stmt->close();
                break;
        }
        
        // Redirect back to the dentist management page
        header("Location: frontend/view_dentists.php");
        exit();
    }
}

// Fetch dentists for display, including their photos
$result = $conn->query("SELECT * FROM dentists");
$dentists = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dentists[] = $row;
    }
}

$conn->close();
?>
