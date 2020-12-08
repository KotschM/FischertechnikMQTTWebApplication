<?php 
include('database connection.php');
include('function.php');

if(isset($_POST["operation"]))
{
    if($_POST["operation"] == "Add")
    {
        $statement = $connection->prepare("INSERT INTO course (course, students) VALUES (:course, :students)");
        $result = $statement->execute(
             array(
                ':course'   =>  $_POST["course"],
                ':students' =>  $_POST["students"],
             )
        );
    }
    if($_POST["operation"] == "Edit")
    {
        $statement = $connection->prepare("UPDATE course SET course = :course, students = :students WHERE id = :id");
        $result = $statement->execute(
             array(
                ':course'   =>  $_POST["course"],
                ':students' =>  $_POST["students"],
                ':id'       =>  $_POST["course_id"]
             )
        );
    }
    
}
?>
                           