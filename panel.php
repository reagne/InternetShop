<?php

require_once("./src/connection.php");

if (!isset($_SESSION['adminId'])) {
    header("Location: index.php");
}
require_once("./src/Header.php");

?>

<h1>Zarządzaj:</h1>
<p>
    <a href="clientsPanel.php">Użytkownikami</a>
</p>
<p>
    <a href="productsPanel.php">Przedmiotami</a>
</p>
<p>
    <a href="categoriesPanel.php">Kategoriami</a>
</p>
<p>
    <a href="ordersPanel.php">Zamówieniami</a>
</p>


<p>
    Dodaj administratora:
    <a href='addAdmin.php'>Dodaj</a>
</p>
<?php
require_once("./src/Footer.php");