<?php



function connectDB(): PDO 
{
    # Vorschlag für eine Standard-PDO-Verbindung

    ## Daten für den DSN
    $driver = 'mysql';
    $host = 'localhost';
    $dbname = 'benutzerverwaltung';
    $port = '3306';
    $charset = 'utf8mb4';

    ## Benutzerdaten
    $user = 'root';
    $password = 'S20@24';

    ## Konfigurationsdaten für PDO
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // für die Entwicklung
        // PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // für das Testen
        // PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT, // im Produktivbetrieb
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $db = new PDO("$driver:host=$host;dbname=$dbname;Port=$port;charset=$charset", $user, $password, $options);

    return $db;
}
