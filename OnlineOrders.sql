Create DATABASE OnlineOrders
-- Create Customers Table
CREATE TABLE Customers (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Email VARCHAR(100),
    Phone VARCHAR(20),
    Address VARCHAR(255),
    Username VARCHAR(50),
    Password VARCHAR(255)
);

-- Create Products Table
CREATE TABLE Products (
    ProductID INT PRIMARY KEY AUTO_INCREMENT,
    ProductName VARCHAR(100),
    Description TEXT,
    Price DECIMAL(10, 2),
    StockQuantity INT
);

-- Create Orders Table
CREATE TABLE Orders (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT,
    OrderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    TotalAmount DECIMAL(10, 2),
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);

-- Create OrderDetails Table
CREATE TABLE OrderDetails (
    OrderDetailID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT,
    ProductID INT,
    Quantity INT,
    Subtotal DECIMAL(10, 2),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);
-- Create Staff Table
CREATE TABLE Staff (
    StaffID INT PRIMARY KEY AUTO_INCREMENT,
    FullName VARCHAR(100),
    EmailID VARCHAR(100),
    Contact VARCHAR(20),
    Username VARCHAR(50) UNIQUE,
    Password VARCHAR(255)
);

-- Insert sample customers
INSERT INTO Customers (FirstName, LastName, Email, Phone, Address, Username, Password)
VALUES
    ('Thor', 'Odinson', 'thor.odinson@email.com', '111-111-1111', 'Asgard', 'thor_odinson', '$2y$10$cnc2J74/k.Iu9DleaOM0K.RgB2QIuSdPb2uQGLX1oeYyQYfLlbKh.'),
    ('Tony', 'Stark', 'tony.stark@email.com', '222-222-2222', 'Stark Tower', 'tony_stark', '$2y$10$cnc2J74/k.Iu9DleaOM0K.RgB2QIuSdPb2uQGLX1oeYyQYfLlbKh.'),
    ('Bruce', 'Banner', 'bruce.banner@email.com', '333-333-3333', 'Gamma Lab', 'bruce_banner', '$2y$10$cnc2J74/k.Iu9DleaOM0K.RgB2QIuSdPb2uQGLX1oeYyQYfLlbKh.'),
    ('Stephen', 'Strange', 'stephen.strange@email.com', '444-444-4444', 'Sanctum Sanctorum', 'stephen_strange', '$2y$10$cnc2J74/k.Iu9DleaOM0K.RgB2QIuSdPb2uQGLX1oeYyQYfLlbKh.');

-- Insert sample products
INSERT INTO Products (ProductName, Description, Price, StockQuantity)
VALUES
    ('Thrusters', 'Rocket thrusters for enhanced mobility', 199.99, 20),
    ('Wands', 'Magical wands for casting spells', 149.99, 15),
    ('Hammers', 'Mjolnir-like hammers for a thunderous impact', 299.99, 10),
    ('Donuts', 'Delicious assorted donuts', 9.99, 50),
    ('Suits', 'Advanced superhero suits with AI integration', 999.99, 5);

-- Insert sample orders
INSERT INTO Orders (CustomerID,OrderDate TotalAmount)
VALUES
    (1, CURRENT_TIMESTAMP, 59.97),
    (2, CURRENT_TIMESTAMP, 89.96),
    (3, CURRENT_TIMESTAMP, 29.98),
    (4, CURRENT_TIMESTAMP, 119.95),
    (1, CURRENT_TIMESTAMP, 39.98),
    (3, CURRENT_TIMESTAMP, 69.97),
    (2, CURRENT_TIMESTAMP, 49.99);

-- Insert sample order details
INSERT INTO OrderDetails (OrderID, ProductID, Quantity, Subtotal)
VALUES
    (1, 1, 2, 399.98),
    (1, 3, 1, 299.99),
    (2, 2, 3, 449.97),
    (3, 4, 1, 9.99),
    (4, 5, 2, 1999.98),
    (5, 1, 1, 199.99),
    (6, 3, 2, 599.98),
    (7, 2, 1, 999.99);
-- Insert sample staff members
INSERT INTO Staff (FullName, EmailID, Contact, Username, Password)
VALUES
    ('Bruce Wayne', 'bruce.wayne@email.com', '111-111-1111', 'bruce_wayne', '$2y$10$cnc2J74/k.Iu9DleaOM0K.RgB2QIuSdPb2uQGLX1oeYyQYfLlbKh.'),
    ('Clark Kent', 'clark.kent@email.com', '222-222-2222', 'superman', '$2y$10$cnc2J74/k.Iu9DleaOM0K.RgB2QIuSdPb2uQGLX1oeYyQYfLlbKh.'),
    ('Barry Allen', 'barry.allen@email.com', '333-333-3333', 'flash', '$2y$10$cnc2J74/k.Iu9DleaOM0K.RgB2QIuSdPb2uQGLX1oeYyQYfLlbKh.');


