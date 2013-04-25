<?php
	if(!isset($_REQUEST['uri'])){
		echo "No URI given!";
	}else{
	
		$uri = $_REQUEST['uri'];
		$isURI = strpos($uri, 'spotify:');
		if($isURI !== FALSE){
			$command = "/usr/bin/perl /var/www/spottube/api/spotify-scrape.pl '$uri'";
			exec($command, $output);
			echo "<ul>";
			foreach($output as &$value) {
				if(($pos = strpos($value, '. ')) !== false)
				{
				   $new_value = substr($value, $pos + 1);
				}
				else
				{
				   $new_value = $value;
				}
				$value = $new_value;
				echo "<li>$value</li>";
			}
			echo "</ul>";
		}else{echo "<p>No valid URI given!</p>";}
	}
?>
