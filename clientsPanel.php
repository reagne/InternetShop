<?php

require_once("./src/connection.php");

if (!isset($_SESSION['adminId'])) {
    header("Location: index.php");
}

require_once("./src/Header.php");

$allClients = Client::GetAllClients();

//var_dump($allClients);
echo("<h1>Użytkownicy</h1>");
echo("<table><tr><td>Id</td><td>Imię</td><td>Nazwisko</td><td>Email</td><td>Adres</td><td>Edytuj</td><td>Usuń</td></tr>");

foreach($allClients as $clientToSee){
    $clientId = $clientToSee->getId();
    echo("<tr>");
    echo("<td>" . $clientId . "</td>");
    echo("<td>{$clientToSee->getFirstName()}</td>");
    echo("<td>{$clientToSee->getLastName()}</td>");
    echo("<td>{$clientToSee->getEmail()}</td>");
    echo("<td>{$clientToSee->getAddress()}</td>");
    echo("<td><a href='clientPanel.php?id=$clientId'>Edytuj</a></td>");
    echo("<td><a href='removeClient.php?id=$clientId'>Usuń</a></td>");

    echo("</tr>");

}

require_once("./src/Footer.php");