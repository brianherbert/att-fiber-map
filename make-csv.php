<?php
require_once 'db.php';

$res = $mysqli->query("SELECT lon, lat FROM addresses WHERE lightGig = 1");

$fh = fopen('hasGig.csv', 'w') or die("Can't create file");
fwrite($fh, "latitude,longitude\n");

$i = 0;
while ($row = $res->fetch_assoc()) {
    fwrite($fh, $row['lat'].",".$row['lon']."\n");
    $i++;
}

echo "Created file with ".number_format($i)." locations.\n";