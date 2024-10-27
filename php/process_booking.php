<?php
session_start();

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

// Check if form data is set and the user is logged in
if (isset($_SESSION['user_id'], $_POST['name'], $_POST['email'], $_POST['number'], $_POST['reason'], $_POST['branch'], $_POST['date'], $_POST['time'])) {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO bookings (uid, name, email, number, reason, branch, date, time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $user_id, $name, $email, $number, $reason, $branch, $date, $time);

    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $reason = $_POST['reason'];
    $branch = $_POST['branch'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Execute the statement
    if ($stmt->execute()) {
        // Send confirmation email using mail()
        $to = $email; // User email
        $subject = 'Booking Confirmation';
        $body = nl2br("Dear $name,<br><br>Thank you for booking with us!<br><br>Your booking details are as follows:<br>Name: $name<br>Email: $email<br>Number: $number<br>Reason: $reason<br>Branch: $branch<br>Date: $date<br>Time: $time<br><br>We look forward to seeing you!<br><br>Best Regards,<br>Dentura Team");
        $headers = "From: noreply@dentura.com\r\n"; // Sender email
        $headers .= "Reply-To: noreply@dentura.com\r\n";
        $headers .= "Content-type: text/html\r\n"; // Set HTML email format

        // Send the email
        if (mail($to, $subject, $body, $headers)) {
            $_SESSION['booking_success'] = true; // Set session variable for success
        } else {
            $_SESSION['booking_success'] = false; // Email sending failed
            $_SESSION['email_error'] = "Email sending failed."; // Store the error message
        }
        
        header("Location: booking_form.php"); // Redirect to the booking form
        exit();
    } else {
        echo "Error: " . $stmt->error; // Database insertion error
    }

    $stmt->close();
} else {
    echo "Error: Missing form data or user not logged in.";
}

$conn->close();
?>
