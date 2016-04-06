<?php
require_once("./src/connection.php");
require_once("./src/Header.php");

unset($_SESSION['clientId']);
unset($_SESSION['adminId']);
unset($_SESSION['orderId']);

header("Location: index.php");

require_once("./src/Footer.php");