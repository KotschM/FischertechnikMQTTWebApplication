<html>
	<head>
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
				<button name="buttonCompressor">Druckluft</button>
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