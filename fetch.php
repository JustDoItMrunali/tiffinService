<?php
session_start();
$conn = mysqli_connect('sql105.infinityfree.com', 'if0_38611818', 'G3qGqzf0wjjY', 'if0_38611818_tiffin_service');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Redirect to login if session is inactive
$sql = "SELECT * FROM image_upload";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PHP Image CRUD</title>
    <link rel="stylesheet" href="styles.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fetch.css">
    <style>
        body {
            background-image: linear-gradient(to right, rgb(255, 255, 255), rgb(247, 223, 254));
        }
        .custom-logout {
            color: red !important;
            font-weight: bold;
            border: 1px solid red !important;
            background-color: white !important;
            padding: 5px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .custom-logout:hover {
            background-color: red !important;
            color: white !important;
            border-color: red;
            box-shadow: 0 4px 8px rgba(255, 0, 0, 0.3);
        }

        .navbar-nav .nav-link {
            transition: all 0.3s ease-in-out;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 500 !important;
        }

        .navbar-nav .nav-link:hover {
            background-color: #570151;
            color: #fff !important;
            transform: scale(1.1);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-light fixed-top">
    <div class="container-fluid">
        <a class="logo"><img src="logo.png" alt="" class="img-fluid" height="50px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample04">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="fetch.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="contactUs.html">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link" href="save_review.php">Review</a></li>
                <li class="nav-item"><a class="nav-link" href="customised.php">Customised Meal</a></li>
                <li class="nav-item"><a class="nav-link" href="chatbot.html">Help Me</a></li>
                <li class="nav-item"><a class="nav-link" href="myorders.php">My order</a></li>
            </ul>
            <div id="user-info">
                <span id="user-name" class="me-3"></span>
                <a id="logout-btn" class="btn btn-outline-danger round-button" style="display: none; color: red !important" href="logout.php">Logout</a>
                <button id="login-btn" class="btn btn-outline-primary round-button" onclick="location.href='login.html'">Login</button>
            </div>          
        </div>
    </div>
</nav>

<div class="container mt-5 pt-5">
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="uploads/<?php echo htmlspecialchars($row['imagesss']); ?>" 
                         class="card-img-top" alt="Tiffin Image" 
                         style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title text-primary center-a">
                            <?php echo htmlspecialchars($row['ReceipeName']); ?>
                        </h5>
                        
                        <ul class="list-group list-group-flush center-align">
                            <li class="list-group-item center-align">
                                <strong>3 Days Plan:</strong> ₹<?php echo htmlspecialchars($row['threeday']); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>1 Week Plan:</strong> ₹<?php echo htmlspecialchars($row['oneweek']); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>2 Weeks Plan:</strong> ₹<?php echo htmlspecialchars($row['twoweek']); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>1 Month Plan:</strong> ₹<?php echo htmlspecialchars($row['onemonth']); ?>
                            </li>
                        </ul>
                        <br>
                        <a href="<?php echo isset($_SESSION['username']) 
                            ? 'mealorder.html?name=' . urlencode($row['ReceipeName']) . 
                            '&threeday=' . urlencode($row['threeday']) . 
                            '&oneweek=' . urlencode($row['oneweek']) . 
                            '&twoweek=' . urlencode($row['twoweek']) . 
                            '&onemonth=' . urlencode($row['onemonth']) . 
                            '&username=' . urlencode($_SESSION['username'])
                            : '#'; ?>" 
                        class="btn d-block button-center"
                        onclick="<?php echo isset($_SESSION['username']) ? '' : "alert('Please log in to place an order.')"; ?>">
                        Order Now
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script type="module">
  document.addEventListener("DOMContentLoaded", async () => {
    const userInfo = await fetchUserDetails();
    const userNameElement = document.getElementById("user-name");
    const loginBtn = document.getElementById("login-btn");
    const logoutBtn = document.getElementById("logout-btn");

    if (userInfo && userInfo.name) {
      userNameElement.textContent = `Welcome, ${userInfo.name}`;
      loginBtn.style.display = 'none';
      logoutBtn.style.display = 'inline-block';
    } else {
      userNameElement.textContent = "Welcome, Guest";
      loginBtn.style.display = 'inline-block';
      logoutBtn.style.display = 'none';
    }

    logoutBtn.addEventListener("click", () => {
      clearUserSession();
      window.location.href = "login.html";
    });
  });

  async function fetchUserDetails() {
    try {
      const response = await fetch('getUserDetails.php');
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error fetching user details:', error);
      return null;
    }
  }

  function clearUserSession() {
    localStorage.removeItem("user");
  }
</script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>

</body>
</html>
