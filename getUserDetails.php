<?php
session_start();

// Connection variables for InfinityFree MySQL database
$servername = "sql105.infinityfree.com";
$username = "if0_38611818";
$password = "G3qGqzf0wjjY";
$dbname = "if0_38611818_tiffin_service";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

// Check if the session variable for email exists (indicating the user is logged in)
if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];

    // Fetch the user details from the database
    $stmt = $conn->prepare("SELECT name, email FROM register1 WHERE email = ?");
    $stmt->bind_param("s", $email);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // User found, send back the user details as a JSON response
            $user = $result->fetch_assoc();
            echo json_encode([
                'name' => htmlspecialchars($user['name']),
                'email' => htmlspecialchars($user['email'])
            ]);
        } else {
            echo json_encode(['error' => 'User not found']);
        }
    } else {
        echo json_encode(['error' => 'Error executing query']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['error' => 'User not logged in']);
}

// Close the connection
$conn->close();
?>
