<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to your MySQL database
    $conn = new mysqli("localhost", "root", "", "onlineorders");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input from the form
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $_POST["password"];

    // Query to check if the username and password match in the Customers table
    $sql = "SELECT * FROM Customers WHERE Username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["Password"])) {
            // Successful login, fetch customer details
            echo "<h2>Customer Details</h2>";
            echo "CustomerID: " . $row["CustomerID"] . "<br>";
            echo "FirstName: " . $row["FirstName"] . "<br>";
            echo "LastName: " . $row["LastName"] . "<br>";
            echo "Email: " . $row["Email"] . "<br>";
            echo "Phone: " . $row["Phone"] . "<br>";
            echo "Address: " . $row["Address"] . "<br><br>";

            // Fetch product details
            $productsQuery = "SELECT * FROM Products";
            $productsResult = $conn->query($productsQuery);

            // Display product details and form for creating an order
            if ($productsResult->num_rows > 0) {
                echo "<h2>Select Products</h2>";
                echo "<form action='Customer_order.php' method='post'>";
                echo "<input type='hidden' name='customer' value='" . $row["CustomerID"] . "'>";
                while ($productRow = $productsResult->fetch_assoc()) {
                    echo "<input type='checkbox' name='products[]' value='" . $productRow["ProductID"] . "'>";
                    echo $productRow["ProductName"] . "<br>";
                    echo "Quantity: <input type='text' name='quantities[" . $productRow["ProductID"] . "]' value='1'><br>";
                }
                echo "<button type='submit'>Create Order</button>";
                echo "</form>";
            } else {
                echo "No products available.";
            }

            // Fetch order details for the customer
            $customerID = $row["CustomerID"];
            $ordersQuery = "SELECT Orders.OrderID, Orders.OrderDate, Orders.TotalAmount, OrderDetails.ProductID, OrderDetails.Quantity, OrderDetails.Subtotal, Products.ProductName FROM Orders INNER JOIN OrderDetails ON Orders.OrderID = OrderDetails.OrderID INNER JOIN Products ON OrderDetails.ProductID = Products.ProductID WHERE Orders.CustomerID='$customerID'";
            $ordersResult = $conn->query($ordersQuery);

            // Display order details for the customer
            if ($ordersResult->num_rows > 0) {
                echo "<h2>Order History</h2>";
                $currentOrderID = null;
                while ($orderRow = $ordersResult->fetch_assoc()) {
                    if ($orderRow["OrderID"] != $currentOrderID) {
                        // New order, display order header
                        if ($currentOrderID !== null) {
                            echo "</ul>";
                        }
                        echo "<ul>";
                        echo "<li>OrderID: " . $orderRow["OrderID"] . ", OrderDate: " . $orderRow["OrderDate"] . ", TotalAmount: $" . $orderRow["TotalAmount"] . "</li>";
                        $currentOrderID = $orderRow["OrderID"];
                    }
                    // Display order detail
                    echo "<li>Product Name: " . $orderRow["ProductName"] . ", Quantity: " . $orderRow["Quantity"] . ", Subtotal: $" . $orderRow["Subtotal"] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No orders found for this customer.</p>";
            }
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "Invalid username. Please try again.";
    }

    // Close the database connection
    $conn->close();
}
?>