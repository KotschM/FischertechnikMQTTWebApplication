<!DOCTYPE html>
<html>
	<head>
		<style>
			#b1 {
    			background-color: rgb(255,242,0);
			}

			#b1.toggled {
    			background-color: rgb(244,113,33);
			}
		</style>
		<title>
			Processing Station
		</title>
	</head>
	<body>
		<h2>
			Zurück zur Übersicht!
		</h2>
		<input type="button" onclick="location.href='index.php';" value="Übersicht" />
		<h4>
			Steuerung der Druckluft!
		</h4>
		<form method="post">
			<p>
				<button id="b2" onclick="myFunction()" name="buttonCompressor">Druckluft</button>
				<button id="b1"  name="buttonCompressor">Druckluft</button>
			</p>
		</form>
		<h4>
			Steuerung des Ofens!
		</h4>
		<form method="post">
			<p>
				<button name="buttonOvenLight">Licht des Ofens</button>
				<button name="buttonOvenGate">Tür des Ofens</button>
			</p>
		</form>
		<h4>
			Steuerung der Kette!
		</h4>
		<form method="post">
			<p>
				<button name="buttonBelt">Förderkette</button>
			</p>
		</form>
		<h4>
			Steuerung der Säge!
		</h4>
		<form method="post">
			<p>
				<button name="buttonSaw">Säge</button>
			</p>
		</form>

		<script>
		function myFunction(){
			//document.getElementById("b1").style.background = "green";
			var property = document.getElementById("b1");
    		property.className = 'toggled' == property.className ? '' : 'toggled';
		}
		</script>

	</body>
</html>

<?php
	if (isset($_POST['buttonSaw']))
	{
		$text = "Saw";
		$cmd = 'sudo python /var/www/html/factoryWebsite/ProcessingStation.py "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonCompressor']))
	{
		$text = "AirCompressor";
		$cmd = 'sudo python /var/www/html/factoryWebsite/ProcessingStation.py "'.$text.'"';
		shell_exec($cmd);
		
		myFunction();
	}
	if (isset($_POST['buttonBelt']))
	{
		$text = "Belt";
		$cmd = 'sudo python /var/www/html/factoryWebsite/ProcessingStation.py "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonOvenLight']))
	{
		$text = "OvenLight";
		$cmd = 'sudo python /var/www/html/factoryWebsite/ProcessingStation.py "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonOvenGate']))
	{
		$text = "OvenGate";
		$cmd = 'sudo python /var/www/html/factoryWebsite/ProcessingStation.py "'.$text.'"';
		shell_exec($cmd);
	}
?>