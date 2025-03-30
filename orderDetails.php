<?php
session_start();
include 'db_config.php';

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in to view your orders.'); window.location.href='login.html';</script>";
    exit;
}

$username = $_SESSION['username'];

// Use prepared statements for security
$stmt = $conn->prepare("SELECT order_id, meal_name, amount, order_date, address FROM orders WHERE username = ? ORDER BY order_date DESC");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Orders</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; padding: 20px; }
        .container { max-width: 800px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(128, 0, 128, 0.4); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        th { background-color: purple; color: white; }
        .no-orders { color: red; font-weight: bold; }
        .content { margin-top: 15%; }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="logo.png" alt="Logo" height="50"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="fetch.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="contactUs.html">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link" href="save_review.php">Review</a></li>
                <li class="nav-item"><a class="nav-link" href="customised.php">Customised Meal</a></li>
                <li class="nav-item"><a class="nav-link" href="chatbot.html">Help Me</a></li>
            </ul>
            <div id="user-info">
                <span id="user-name" class="me-3"></span>
                <a id="logout-btn" class="btn btn-outline-danger" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</nav>

<div class="content">
    <h2>My Orders</h2>
    <?php if ($result->num_rows > 0) : ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Meal Name</th>
                <th>Amount Paid (₹)</th>
                <th>Order Date</th>
                <th>Delivery Address</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['order_id']) ?></td>
                    <td><?= htmlspecialchars($row['meal_name']) ?></td>
                    <td><?= htmlspecialchars($row['amount']) ?></td>
                    <td><?= htmlspecialchars($row['order_date']) ?></td>
                    <td><?= htmlspecialchars($row['address'] ?? 'No Address Provided') ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p class="no-orders">No orders found.</p>
    <?php endif; ?>
</div>

<script type="module">
document.addEventListener("DOMContentLoaded", async () => {
    const userNameElement = document.getElementById("user-name");
    try {
        const response = await fetch('getUserDetails.php');
        const data = await response.json();
        if (data && data.name) {
            userNameElement.textContent = `Welcome, ${data.name}`;
        } else {
            userNameElement.textContent = "Welcome, Guest";
        }
    } catch (error) {
        console.error('Error fetching user details:', error);
    }
});
</script>

</body>
</html>

<?php $stmt->close(); $conn->close(); ?>
