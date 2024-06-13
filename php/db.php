<?php
$serverName = "DESKTOP-HURB5A2\SQLEXPRESS";
$databaseName = "VRITRF";
try {
    $conn = new PDO("sqlsrv:server=$serverName;database=$databaseName", NULL, NULL);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
