<style>
.error {color: #FF0000;}
</style>
<?php
// define variables and set to empty values
$urls = "";
$urlsarray = array();
$urlsErr = null;
$MAX_NUM_OF_URLS_ALLOWED = 5;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["urls"])) {
	   $urlsErr = "URL is required";
   }
   else {
		$urls = test_input($_POST["urls"]);
		$urlsarray = explode("\n", $urls);
		(count($urlsarray) > $MAX_NUM_OF_URLS_ALLOWED) ? ($urlsErr .= "Max allowed number of URLs: ".$MAX_NUM_OF_URLS_ALLOWED):null;
		$urlsarray = array_filter($urlsarray, 'trim');		
		foreach($urlsarray as $url)
			(is_valid_url($url)) ? null : ($urlsErr .= "Invalid url:".$url);
	}
}

function is_valid_url($enteredurl){
	return (!filter_var($enteredurl, FILTER_VALIDATE_URL) or
	(preg_match("@^(https?|ftp)://[^\s/$.?#].[^\s]*$@iS",$enteredurl))
	);
	}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
     URLs: <textarea name="urls" rows="5" cols="40"><?php echo $urls;?></textarea>
	<span class="error"><?php echo "<br>".$urlsErr."<br>";?></span>
   <input type="submit" name="submit" value="Submit">
</form>

<?php
if($urlsErr==null){
foreach($urlsarray as $url)
	echo $url."<br>";
}
?>
