<?php
// Ensure no output has been sent before redirecting
if (!headers_sent()) {
    // Redirect to index.html
    header("Location: index.html");
    exit();
} else {
    // Handle error if headers are already sent
    die("Error: Headers already sent, cannot redirect.");
}
?>
