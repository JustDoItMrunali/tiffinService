<?php
// Database connection
$conn = new mysqli("sql105.infinityfree.com", "if0_38611818", "G3qGqzf0wjjY", "if0_38611818_tiffin_service");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT * FROM contact_us ORDER BY created_at DESC";
$result = $conn->query($sql);

// Display data
echo "<h2>Contact Messages</h2>";
echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Comment</th><th>Submitted At</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['comment']}</td>
                <td>{$row['created_at']}</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No messages found.</td></tr>";
}
echo "</table>";

// Close connection
$conn->close();
?>
