<!DOCTYPE html>
<html>
    <head>
        <Title>Fischertechnik 4.0</Title>
        <meta charset="utf-8">

        <!-- bootstrap Lib -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- datatable lib -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="singlePage.css">

    </head>

    <body>
        <!-- HEADER -->
        <header>
            <div id="logo">
                <a href="#">
                    <img src="img/avatar.png">
                </a>
            </div>

            <nav id="main-nav">
                <ul>
                    <li><a href="#overview">Übersicht</a></li>
                    <li><a href="#street">Straße</a></li>
                    <li><a href="#production">Fertigung</a></li>
                    <li><a href="#warehouse">Lager</a></li>
                    <li><a href="#statistic">Statistik</a></li>
                </ul>
            </nav>
        </header>

        <!-- OVERVIEW -->

        <section id="overview">
            <hr>
            <h1>Fischertechnik 4.0</h1>
            <h2>DHBW Stuttgart Campus Horb</h2>
            <a href="#street">
                <img src="img/pfeil.png">
            </a>
        </section>

        <!-- SORTING STREET -->

        <section id="street">
            <h3>Sortierstraße</h3>
            <hr>
            <h4>
                Steuerung der Druckluft!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonCompressorSortingLine">Druckluft</button>
                </p>
            </form>
            <h4>
                Steuerung der Schieber!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonWhiteSortingLine">Weiß</button>
                    <button name="buttonRedSortingLine">Rot</button>
                    <button name="buttonBlueSortingLine">Blau</button>
                </p>
            </form>
            <h4>
                Steuerung der Kette!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonBeltSortingLine">Förderkette</button>
                </p>
            </form>
        </section>

        <!-- PRODUCTION -->

        <section id="production">
            <h3>Fertigungsstraße</h3>
            <hr>
            <h4>
			Steuerung der Druckluft!
            </h4>
            <form method="post" target="frame">
                <p>
                    <!--
                        <button id="b2" onclick="myFunction()" name="buttonCompressor">Druckluft</button>
                    -->
                        <button id="b1" name="buttonCompressorProcessingStation">Druckluft</button>
                </p>
            </form>
            <h4>
                Steuerung des Ofens!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonOvenLightProcessingStation">Licht des Ofens</button>
                    <button name="buttonOvenGateProcessingStation">Tür des Ofens</button>
                </p>
            </form>
            <h4>
                Steuerung der Kette!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonBeltProcessingStation">Förderkette</button>
                </p>
            </form>
            <h4>
                Steuerung der Säge!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonSawProcessingStation">Säge</button>
                </p>
            </form>
        </section>

        <!-- WAREHOUSE -->

        <section id="warehouse">
            <h3>Hochregallager</h3>
            <hr>
            <h4>
                ToDo...
            </h4>
        </section>

        <!-- Statistik -->

        <section id="statistic">
            <h3>MQTT-Statistik</h3>
            <hr>

            <form action=""> 
                <select name="customers" onchange="showCustomer(this.value)">
                    <option value=""> Select a topic: </option>
                    <option value="1"> SortingLine </option>
                    <option value="2"> Processing Station </option>
                    <option value="3"> Warehouse Unit </option>
                </select>
            </form>
            <br>
            <div id="txtHint">Messages will be listed here...</div>

            <script>
            function showCustomer(str) {
            var xhttp;  
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "getcustomer.php?q="+str, true);
            xhttp.send();
            }
            </script>

            <br>

            <div class="content">
                <table id="course_table" class="table table-striped">  
                    <thead bgcolor="#6cd8dc">
                        <tr class="table-primary">
                           <th width="30%">ID</th>
                           <th width="50%">Course Name</th>  
                           <th width="30%">Number of Students</th>
                           <th scope="col" width="5%">Edit</th>
                           <th scope="col" width="5%">Delete</th>
                        </tr>
                    </thead>
                </table>
                <br>
                <div align="right">
                <button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success">Add Course</button>
                </div>

            </div>
        </section>
    
        <!-- FOOTER -->

        <footer>
            <p>
                &copy; 2020 / Moris Kotsch / DHBW Stuttgart Campus Horb
            </p>
        </footer>
        <iframe name="frame"></iframe>
    </body>
</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="course_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Add Course</h4>
                </div>
                <div class="modal-body">
                    <label>Enter Course Name</label>
                    <input type="text" name="course" id="course" class="form-control"/><br>
                    <label>Enter Number of Students</label>
                    <input type="text" name="students" id="students" class="form-control"/><br>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="course_id" id="course_id"/>
                    <input type="hidden" name="operation" id="operation"/>
                    <input type="submit" name="action" id="action" class="btn btn-primary" value="Add" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#add_button').click(function(){
            $('#course_form')[0].reset();
            $('.modal-title').text("Add Course Details");
            $('#action').val("Add");
            $('#operation').val("Add")
        });

     var dataTable = $('#course_table').DataTable({
        "paging":true,
        "processing":true,
        "serverSide":true,
        "order": [],
        "info":true,
        "ajax":{
            url:"fetch.php",
            type:"POST"
        },
        "columnDefs":[
           {
            "target":[0,3,4],
            "orderable":false,
           },
        ],
     });

     $(document).on('submit', '#course_form', function(event){
        event.preventDefault();
        var id = $('#id').val();
        var course = $('#course').val();
        var students = $('#students').val();
        
        if(course != '' && students != '')
        {
            $.ajax({
                url:"insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                    $('#course_form')[0].reset();
                    $('#userModal').modal('hide');
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            alert("Course Name, Number of students Fields are Required");
        }
    });
    
    $(document).on('click', '.update', function(){
        var course_id = $(this).attr("id");
        $.ajax({
            url:"fetch_single.php",
            method:"POST",
            data:{course_id:course_id},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');
                $('#id').val(data.id);
                $('#course').val(data.course);
                $('#students').val(data.students);
                $('.modal-title').text("Edit Course Details");
                $('#course_id').val(course_id);
                $('#action').val("Save");
                $('#operation').val("Edit");
            }
        });
     });

    $(document).on('click','.delete', function(){

        var course_id = $(this).attr("id");
        if(confirm("Are you sure want to delete this user?"))
        {
            $.ajax({
                url:"delete.php",
                method:"POST",
                data:{course_id:course_id},
                success:function(data)
                {
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
     });

    });
</script>

<?php   
    // Sorting Line
    $mysqli = new mysqli("localhost", "raspberry", "ftpiuser", "FromWebToFactory");
    if($mysqli->connect_error) {
    exit('Could not connect');
    }

    $topicSortingLine = "/factory/sortingLine";
	if (isset($_POST['buttonCompressorSortingLine']))
	{
		$text = "AirCompressor";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topicSortingLine.'" "'.$text.'"';
        shell_exec($cmd);
        $sql = 'INSERT INTO MQTTMessage (topic, message) VALUES ("'.$topicSortingLine.'", "'.$text.'")';
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
	}
	if (isset($_POST['buttonWhiteSortingLine']))
	{
		$text = "White";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topicSortingLine.'" "'.$text.'"';
        shell_exec($cmd);
        $sql = 'INSERT INTO MQTTMessage (topic, message) VALUES ("'.$topicSortingLine.'", "'.$text.'")';
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
	}
	if (isset($_POST['buttonRedSortingLine']))
	{
		$text = "Red";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topicSortingLine.'" "'.$text.'"';
        shell_exec($cmd);
        $sql = 'INSERT INTO MQTTMessage (topic, message) VALUES ("'.$topicSortingLine.'", "'.$text.'")';
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
	}
	if (isset($_POST['buttonBlueSortingLine']))
	{
		$text = "Blue";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topicSortingLine.'" "'.$text.'"';
        shell_exec($cmd);
        $sql = 'INSERT INTO MQTTMessage (topic, message) VALUES ("'.$topicSortingLine.'", "'.$text.'")';
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
	}
	if (isset($_POST['buttonBeltSortingLine']))
	{
		$text = "Belt";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topicSortingLine.'" "'.$text.'"';
        shell_exec($cmd);
        $sql = 'INSERT INTO MQTTMessage (topic, message) VALUES ("'.$topicSortingLine.'", "'.$text.'")';
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
    }

    //Processing Station
    $topicProcessingStation = "/factory/processingStation";
    if (isset($_POST['buttonSawProcessingStation']))
	{
		$text = "Saw";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
        shell_exec($cmd);
        $sql = 'INSERT INTO MQTTMessage (topic, message) VALUES ("'.$topicProcessingStation.'", "'.$text.'")';
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
	}
	if (isset($_POST['buttonCompressorProcessingStation']))
	{
		$text = "AirCompressor";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
        shell_exec($cmd);
        $sql = 'INSERT INTO MQTTMessage (topic, message) VALUES ("'.$topicProcessingStation.'", "'.$text.'")';
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
		
		myFunction();
	}
	if (isset($_POST['buttonBeltProcessingStation']))
	{
		$text = "Belt";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
        shell_exec($cmd);
        $sql = 'INSERT INTO MQTTMessage (topic, message) VALUES ("'.$topicProcessingStation.'", "'.$text.'")';
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
	}
	if (isset($_POST['buttonOvenLightProcessingStation']))
	{
		$text = "OvenLight";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
        shell_exec($cmd);
        $sql = 'INSERT INTO MQTTMessage (topic, message) VALUES ("'.$topicProcessingStation.'", "'.$text.'")';
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
	}
	if (isset($_POST['buttonOvenGateProcessingStation']))
	{
		$text = "OvenGate";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
        shell_exec($cmd);
        $sql = 'INSERT INTO MQTTMessage (topic, message) VALUES ("'.$topicProcessingStation.'", "'.$text.'")';
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
    }
    
    $stmt->close();
?>