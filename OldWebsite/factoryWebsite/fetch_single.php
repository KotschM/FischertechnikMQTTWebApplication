<?php 
include('database connection.php');
include('function.php');

if(isset($_POST["course_id"]))
{
    $output = array();
    $statement = $connection->prepare("SELECT * FROM MQTTMessage WHERE id = '".$_POST["course_id"]."' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        $output["id"] = $row["id"];
        $output["topic"] = $row["topic"];
        $output["message"] = $row["message"];
    }
    echo json_encode($output);
}
?>
                           