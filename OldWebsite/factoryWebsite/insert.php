<?php 
include('database connection.php');
include('function.php');

if(isset($_POST["operation"]))
{
    if($_POST["operation"] == "Add")
    {
        $statement = $connection->prepare("INSERT INTO MQTTMessage (topic, message) VALUES (:topic, :message)");
        $result = $statement->execute(
             array(
                ':topic'   =>  $_POST["topic"],
                ':message' =>  $_POST["message"],
             )
        );
    }
    if($_POST["operation"] == "Edit")
    {
        $statement = $connection->prepare("UPDATE MQTTMessage SET topic = :topic, message = :message WHERE id = :id");
        $result = $statement->execute(
             array(
                ':topic'   =>  $_POST["topic"],
                ':message' =>  $_POST["message"],
                ':id'       =>  $_POST["course_id"]
             )
        );
    }
    
}
?>
                           