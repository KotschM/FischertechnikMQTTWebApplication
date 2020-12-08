<!DOCTYPE html>
<html>
    <head>
        <Title>Fischertechnik 4.0</Title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="singlePage.css">
        <link rel="stylesheet" type="text/css" href="file:///var/www/html/Bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" scr="file:///var/www/html/Bootstrap/css/bootstrap.min.css"></script>
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
                <table id="course_table" class=" table table-stribed">
                    <thead bgcolor="#6cd8dc">
                        <tr class="table-primary">
                            <th width="30%">ID</th>
                            <th width="50%">Topic</th>
                            <th width="30%">Message</th>
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