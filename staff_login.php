<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "onlineorders");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM Staff WHERE Username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["Password"])) {
            echo "<h2>Staff Details</h2>";
            echo "StaffID: " . $row["StaffID"] . "<br>";
            echo "FullName: " . $row["FullName"] . "<br>";
            echo "EmailID: " . $row["EmailID"] . "<br>";
            echo "Contact: " . $row["Contact"] . "<br>";
            echo "Username: " . $row["Username"] . "<br><br>";

            echo "<h2>All Products</h2>";
            $productsQuery = "SELECT * FROM Products";
            $productsResult = $conn->query($productsQuery);

            if ($productsResult->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr><th>ProductID</th><th>ProductName</th><th>Description</th><th>Price</th><th>StockQuantity</th></tr>";
                while ($productRow = $productsResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $productRow["ProductID"] . "</td>";
                    echo "<td>" . $productRow["ProductName"] . "</td>";
                    echo "<td>" . $productRow["Description"] . "</td>";
                    echo "<td>" . $productRow["Price"] . "</td>";
                    echo "<td>" . $productRow["StockQuantity"] . "</td>";
                    echo "</tr>";
                }
                echo "</table><br>";
            } else {
                echo "No products available.";
            }

            echo "<h2>Add New Product</h2>";
            echo "<form action='add_products.php' method='post'>";
            echo "<label for='productName'>Product Name:</label>";
            echo "<input type='text' name='productName' id='productName'><br>";
            echo "<label for='description'>Description:</label>";
            echo "<input type='text' name='description' id='description'><br>";
            echo "<label for='price'>Price:</label>";
            echo "<input type='text' name='price' id='price'><br>";
            echo "<label for='stockQuantity'>Stock Quantity:</label>";
            echo "<input type='text' name='stockQuantity' id='stockQuantity'><br>";
            echo "<button type='submit'>Add Product</button>";
            echo "</form>";

            echo "<h2>Update Customer Details</h2>";
            echo "<form action='update_customer.php' method='post'>";
            echo "<label for='customer'>Select Customer:</label>";

            $customersQuery = "SELECT * FROM Customers";
            $customersResult = $conn->query($customersQuery);

            if ($customersResult === false) {
                echo "Error: " . $conn->error;
            } elseif ($customersResult->num_rows > 0) {
                echo "<select name='customer' id='customer'>";
                while ($customerRow = $customersResult->fetch_assoc()) {
                    echo "<option value='" . $customerRow["CustomerID"] . "'>" . $customerRow["FirstName"] . " " . $customerRow["LastName"] . "</option>";
                }
                echo "</select><br>";

                echo "<label for='newFirstName'>New First Name:</label>";
                echo "<input type='text' name='newFirstName' id='newFirstName'><br>";
                echo "<label for='newLastName'>New Last Name:</label>";
                echo "<input type='text' name='newLastName' id='newLastName'><br>";
                echo "<label for='newEmail'>New Email:</label>";
                echo "<input type='text' name='newEmail' id='newEmail'><br>";
                echo "<label for='newContact'>New Contact:</label>";
                echo "<input type='text' name='newContact' id='newContact'><br>";
                echo "<button type='submit'>Update Customer</button>";
            } else {
                echo "No customers available.";
            }

            echo "</form>";

            $conn->close();
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "Invalid username. Please try again.";
    }
}

?>
