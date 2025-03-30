<?php
// Connect to InfinityFree MySQL database
$conn = new mysqli('sql105.infinityfree.com', 'if0_38611818', 'G3qGqzf0wjjY', 'if0_38611818_tiffin_service');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    $ReceipeName = $_POST['ReceipeName'];
    $Price = $_POST['Price'];
    $threeday = $_POST['threeday'];
    $oneweek = $_POST['oneweek'];
    $twoweek = $_POST['twoweek'];
    $onemonth = $_POST['onemonth'];

    // Image Upload Processing
    $image_name = $_FILES['my_image']['name'];
    $image_tmp = $_FILES['my_image']['tmp_name'];
    $image_size = $_FILES['my_image']['size'];
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($image_ext, $allowed_extensions) && $image_size < 5000000) { // 5MB limit
        $newfilename = uniqid("IMG_", true) . '.' . $image_ext;
        $uploadpath = "uploads/" . $newfilename;

        if (move_uploaded_file($image_tmp, $uploadpath)) {
            // Use prepared statements to prevent SQL injection
            $sql = "INSERT INTO image_upload (ReceipeName, Price, threeday, oneweek, twoweek, onemonth, imagesss) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $ReceipeName, $Price, $threeday, $oneweek, $twoweek, $onemonth, $newfilename);

            if ($stmt->execute()) {
                echo "Data inserted into database successfully!";
            } else {
                echo "Failed to insert data into database: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Image upload failed.";
        }
    } else {
        echo "Invalid file type or size too large!";
    }
}

$conn->close();
?>
