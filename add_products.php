<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to your MySQL database
    $conn = new mysqli("localhost", "root", "", "onlineorders");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input from the form
    $productName = $conn->real_escape_string($_POST["productName"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $price = $_POST["price"];
    $stockQuantity = $_POST["stockQuantity"];

    // Insert the new product into the Products table
    $insertQuery = "INSERT INTO Products (ProductName, Description, Price, StockQuantity) VALUES ('$productName', '$description', '$price', '$stockQuantity')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "Product added successfully.";
    } else {
        echo "Error adding product: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}

?>
