<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to your MySQL database
    $conn = new mysqli("localhost", "root", "", "onlineorders");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input from the form
    $customerID = $_POST["customer"];
    $selectedProducts = isset($_POST["products"]) ? $_POST["products"] : array();
    $quantities = isset($_POST["quantities"]) ? $_POST["quantities"] : array();

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Insert into Orders table
        $insertOrder = "INSERT INTO Orders (CustomerID, TotalAmount) VALUES ('$customerID', 0)";
        $conn->query($insertOrder);

        // Get the newly inserted OrderID
        $orderID = $conn->insert_id;

        // Iterate through selected products and insert into OrderDetails table
        foreach ($selectedProducts as $productID) {
            $quantity = $quantities[$productID];

            // Fetch product details
            $productQuery = "SELECT * FROM Products WHERE ProductID='$productID'";
            $productResult = $conn->query($productQuery);

            if ($productResult->num_rows > 0) {
                $productRow = $productResult->fetch_assoc();
                $subtotal = $quantity * $productRow["Price"];

                // Insert into OrderDetails table
                $insertOrderDetails = "INSERT INTO OrderDetails (OrderID, ProductID, Quantity, Subtotal)
                                       VALUES ('$orderID', '$productID', '$quantity', '$subtotal')";
                $conn->query($insertOrderDetails);
            } else {
                throw new Exception("Invalid product selection.");
            }
        }

        // Update the TotalAmount in the Orders table
        $updateOrderTotal = "UPDATE Orders SET TotalAmount = (SELECT SUM(Subtotal) FROM OrderDetails WHERE OrderID='$orderID') WHERE OrderID='$orderID'";
        $conn->query($updateOrderTotal);

        // Commit the transaction
        $conn->commit();

        echo "Order created successfully!";
    } catch (Exception $e) {
        // Rollback the transaction on exception
        $conn->rollback();

        echo "Error creating order: " . $e->getMessage();
    }

    // Close the database connection
    $conn->close();
}
?>