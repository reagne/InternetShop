<?php
require_once("./src/connection.php");

unset($_SESSION['userId']);
unset($_SESSION['adminId']);

header("Location: index.php");

?>