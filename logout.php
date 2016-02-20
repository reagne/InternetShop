<?php
require_once("./src/connection.php");

unset($_SESSION['clientId']);
unset($_SESSION['adminId']);

header("Location: index.php");

?>