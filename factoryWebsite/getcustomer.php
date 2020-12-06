<?php
$mysqli = new mysqli("localhost", "raspberry", "ftpiuser", "FromWebToFactory");

if($mysqli->connect_error) {
  exit('Could not connect');
}

$sql = "SELECT id, topic, message
FROM MQTTMessage WHERE id = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($cid, $cname, $name);
$stmt->fetch();
$stmt->close();

echo "<table>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>Topic</th>";
echo "<th>Message</th>";
echo "</tr>";
echo "<tr>";
echo "<td>" . $cid . "</td>";
echo "<td>" . $cname . "</td>";
echo "<td>" . $name . "</td>";
echo "</tr>";
echo "</table>";
?>