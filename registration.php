<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to your MySQL database
    $conn = new mysqli("localhost", "root", "", "yourdatabase");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input from the form
    $firstName = $conn->real_escape_string($_POST["firstName"]);
    $lastName = $conn->real_escape_string($_POST["lastName"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $phone = $conn->real_escape_string($_POST["phone"]);
    $address = $conn->real_escape_string($_POST["address"]);
    $username = $conn->real_escape_string($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO Customers (FirstName, LastName, Email, Phone, Address, Username, Password)
            VALUES ('$firstName', '$lastName', '$email', '$phone', '$address', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
