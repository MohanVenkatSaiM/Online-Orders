<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "onlineorders");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $customerID = $_POST["customer"];
    $newFirstName = $conn->real_escape_string($_POST["newFirstName"]);
    $newLastName = $conn->real_escape_string($_POST["newLastName"]);
    $newEmail = $conn->real_escape_string($_POST["newEmail"]);
    $newContact = $conn->real_escape_string($_POST["newContact"]);

    $updateQuery = "UPDATE Customers SET FirstName='$newFirstName', LastName='$newLastName', Email='$newEmail', Phone='$newContact' WHERE CustomerID='$customerID'";

    if ($conn->query($updateQuery) === TRUE) {
        echo "Customer details updated successfully.";
    } else {
        echo "Error updating customer details: " . $conn->error;
    }

    $conn->close();
}

?>
