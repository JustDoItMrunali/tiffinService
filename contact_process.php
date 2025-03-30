<?php
session_start(); // Start session to access stored user data

// Database connection settings (Updated for InfinityFree)
$host = "sql105.infinityfree.com"; // Use the MySQL host from InfinityFree
$username = "if0_38611818"; // Use the MySQL username from InfinityFree
$password = "G3qGqzf0wjjY"; // Use the MySQL password from InfinityFree
$database = "if0_38611818_tiffin_service"; // Use the correct database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the correct name from session
    $name = isset($_SESSION['username']) ? mysqli_real_escape_string($conn, $_SESSION['username']) : '';
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    // Insert data into the database
    $sql = "INSERT INTO contact_us (name, email, phone, comment) 
            VALUES ('$name', '$email', '$phone', '$comment')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Message sent successfully!'); window.location.href='contactUs.html';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "'); window.location.href='contactUs.html';</script>";
    }
}

$conn->close();
?>
