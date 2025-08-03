<?php

//Starts session if not active already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//Array for status of every service/info
$statuses = [];


require_once 'db_connection.php'; // links to the db connection file

//Determine the status of the database connection
if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
    //Retrieve database connection details
    $dbHostInfo = $conn->host_info ?? 'Unknown host info';
    $dbServerIp = gethostbyname(parse_url($conn->host_info, PHP_URL_HOST) ?: $conn->host_info);
    $statuses['Database'] = ['status' => 'Online', 'details' => "Connected to DB server: $dbHostInfo (IP: $dbServerIp)"];
} else {

    //in the event of a failed connection
    $errorDetail = $conn->connect_error ?? 'No connection object.';
    $statuses['Database'] = ['status' => 'Offline', 'details' => $errorDetail];
}

//Retrieve some available server details
$serverIp = $_SERVER['SERVER_ADDR'] ?? 'Unknown';
$serverName = $_SERVER['SERVER_NAME'] ?? 'Unknown';
$phpVersion = phpversion();
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';

//Determine the status of the current session
$sessionStatus = session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive';

//Get the current time of the server
$currentTime = date( 'Y-m-d H:i:s T');

//Storing server info in statuses array
$statuses['Server IP'] = ['status' => 'Info', 'details' => $serverIp];
$statuses['Server Name'] = ['status' => 'Info', 'details' => $serverName];
$statuses['PHP Version'] = ['status' => 'Info', 'details' => $phpVersion];
$statuses['Server Software'] = ['status' => 'Info', 'details' => $serverSoftware];
$statuses['Session Status'] = ['status' => 'Info', 'details' => $sessionStatus];
$statuses['Server Time'] = ['status' => 'Info', 'details' => $currentTime];
?>

<!--
Name: Adrianno Fallone
Date: July 30, 2025
Description: Final Project Submission
Professor: Dr. Ziad Kobti-->

<!-- Initial declarations, metatags-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Server Status" />
    <meta name="keywords" content="supplements, protein, gym, fitness, creatine, pre-workout, server status" />
    <meta name="author" content="Adrianno Fallone" />
    <link id="themeStyle" rel="stylesheet" href="css_files/cart.css">
    
    <a style="text-decoration: none; font-weight: bold; color: limegreen" href="admin.php">Back To Admin Panel</a>
    <title>System Status Page</title> <!--title-->
    
    <!--inline css styling of page-->
    <style>
        
        /*body styling*/
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #0d0d0d;
            color: #f0f0f0;
            padding: 2rem;
            margin: 0;
        }

        /*status section container styling*/
        .status-section {
            max-width: 700px;
            margin: auto;
            background-color: #121212;
            border-radius: 8px;
            padding: 1.5rem 2rem;
            box-shadow: 0 0 15px rgba(50, 205, 50, 0.6);
        }
        
        /*heading styling*/
        h2 {
            color: limegreen;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 700;
            letter-spacing: 1.5px;
        }
        
        /*table and table elements styling properties*/
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #2f2f2f;
            text-align: left;
        }
        th {
            background-color: #1a1a1a;
            color: limegreen;
            font-weight: 600;
            font-size: 1rem;
        }
        td {
            font-size: 0.95rem;
        }

        /*online status styling*/
        .status-Online {
            color: #32cd32;
            font-weight: bold;
        }

        /*offline status styling*/
        .status-Offline {
            color: #ff4500;
            font-weight: bold;
        }

        /*status info styling*/
        .status-Info {
            color: #99ff99;
            font-style: italic;
        }
    </style>
</head>

<!--body section-->
<body>
    <div class="status-section"> <!--Container for system monitoring-->
        <h2>System Monitoring Status</h2>
        <table>
            <thead>
                <tr>
                <!--table headers: service, status, details-->
                    <th>Service / Info</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                
                <!--Iterates each service in the statuses array-->
                <?php foreach ($statuses as $service => $data): ?>
                    <tr>
                        <td><?= htmlspecialchars($service) ?></td> <!--service name-->
                        <td class="status-<?= htmlspecialchars($data['status']) ?>"> <!--dynamic status status field-->
                            <?= htmlspecialchars($data['status']) ?>
                        </td>
                        <td><?= htmlspecialchars($data['details']) ?></td> <!--additional details-->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
