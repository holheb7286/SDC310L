<?php
declare(strict_types=1);

$host = 'localhost';
$db   = 'sdc310l_hebert';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

/**
 * Enable mysqli exceptions so errors behave similarly to PDO::ERRMODE_EXCEPTION
 */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $mysqli = new mysqli($host, $user, $pass, $db);
    $mysqli->set_charset($charset);
} catch (mysqli_sql_exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}