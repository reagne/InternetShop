<?php

$dbUser = "root";
$dbPassword = "coderslab";
$dbHost = "localhost";
$dbBaseName = "InternetShop";

/*

CREATE TABLE Products(
    id INT AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DOUBLE NOT NULL,
    description TEXT(1500),
    PRIMARY KEY (id)
    );

CREATE TABLE Images(
    id INT AUTO_INCREMENT,
    product_id INT,
    path_to_file varchar(280),
    PRIMARY KEY(id),
    FOREIGN KEY(product_id) REFERENCES Products(id)
    ON DELETE CASCADE
    );

CREATE TABLE Users(
    id INT AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(70) NOT NULL,
    address VARCHAR(150) NOT NULL,
    PRIMARY KEY(id)
    );

CREATE TABLE Admins(
    id INT AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(70) NOT NULL,
    PRIMARY KEY(id)
    );

CREATE TABLE Orders(
    id INT AUTO_INCREMENT,
    user_id INT NOT NULL,
    status INT,
    price_sum DOUBLE,
    PRIMARY KEY (id),
    FOREIGN KEY(user_id) REFERENCES Users(id)
    ON DELETE CASCADE
    );

CREATE TABLE Products_Orders(
    id INT AUTO_INCREMENT,
    product_id INT NOT NULL,
    order_id INT NOT NULL,
    product_quantity INT NOT NULL,
    product_price DOUBLE NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(product_id) REFERENCES Products(id),
    FOREIGN KEY(order_id) REFERENCES Orders(id)
    ON DELETE CASCADE
    );

*/

?>