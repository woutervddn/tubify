<?php
	if(!isset($_REQUEST['uri'])){
		echo "No URI given!";
	}else{
	
		$uri = $_REQUEST['uri'];
		$isURI = strpos($uri, 'spotify:');
		if($isURI !== FALSE){
			$command = "/usr/bin/perl /var/www/spottube/api/spotify-scrape.pl '$uri'";
			exec($command, $output);
			foreach($output as &$title) {
				if(($pos = strpos($title, '. ')) !== false)
				{
				   $new_title = substr($title, $pos + 1);
				}
				else
				{
				    $new_title = $title;
				}
				$title = $new_title;
		
				$transform = "echo '$title' | sed -e 's/ - / /g' | sed 's/ /+/g'";
				$response = shell_exec($transform);
				$yturl = "http://gdata.youtube.com/feeds/api/videos?q=".$response."&max-results=1&v=2";
				$ytpage = file_get_contents($yturl);
		
				$ytpage = str_replace("><",">\n<",$ytpage); 
				$ytline = strstr($ytpage, 'media:player');
				$ytlinecut = strstr($ytline, 'http://www.youtube.com/watch?v=');
				$ytlink = strstr($ytlinecut, "&amp;", true);
		
				//$linkcommand = "echo '$ytline'"; #| grep 'media:player' | sed \"s/<media:player url='//g\" |sed \"s/'\/>//g\"";
				//$ytlink = shell_exec($linkcommand);

				echo "$ytlink,";
			}
		}else{echo "<p>No valid URI given!</p>";}
	}
?>
