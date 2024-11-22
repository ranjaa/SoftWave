<?php
// Database configuration using environment variables
$servername = getenv('DB_SERVER');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log the error and show a generic message
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed, please try again later.");
}

// Form submission handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $query_topic = htmlspecialchars(trim($_POST['query_topic']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Insert data into the database
    $sql = "INSERT INTO contact_messages (fullname, lastname, email, phone, query_topic, message) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $fullname, $lastname, $email, $phone, $query_topic, $message);

    if ($stmt->execute()) {
        echo "Message submitted successfully!";
    } else {
        // Log the error and show a generic message
        error_log("Error: " . $stmt->error);
        echo "There was an issue submitting your message. Please try again later.";
    }

    $stmt->close();
}

// Close the connection
$conn->close();
?>
