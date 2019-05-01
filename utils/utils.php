<?php 

 	function lineCount($files)
	{
		$count =count($files);
		if ($count) {
		
			$linecount = 0;
			foreach ($files as $key => $file) {
				$file = "texts/".$file;
				$handle = fopen($file, "r");
				while(!feof($handle)){
				  $line = fgets($handle);
				  $linecount++;
				}
				fclose($handle);
			}
			
			return ($linecount/ count($files))." Average Lines";
		}else{
			return "No Files Available!";
		}
	}
	function replaceDates($files)
	{
		$count =count($files);
		if ($count) {
		
			$replacecounts = 0;
			foreach ($files as $key => $file) {
				$filename = $file;
				$file = "texts/".$file;
				$file = file_get_contents($file);
				$pattern = "^\\d{1,2}/\\d{2}/\\d{4}^";
				
				$matches = array();
				if (preg_match_all($pattern, $file, $matches)) {
					
				   foreach ($matches[0] as $value) {
			   			$date = str_replace('/', '-', $value);
				   		$file = str_replace($value, $date, $file);
				   		$replacecounts++;
				   }
					$filename = 'output_texts/'.$filename;
					file_put_contents($filename, $file);
				}
			}
			return $replacecounts;
		}else{
			return "No Files Available!";
		}
	}
    
if ($argc > 2) {
	
	$seperator = $argv[1];
	$function = $argv[2];

	if ($seperator == "comma") {
		$seperator = ",";
	}else if ($seperator == "semicolon") {
		$seperator = ";";
	}else{
		exit;
	}
	
		$csvfile = 'people.csv';
		$file_handle = fopen($csvfile, 'r');
		$users  = array();

		while(!feof($file_handle))
		{
		  $users = fgetcsv($file_handle, 1024);
		}
		fclose($file_handle);
		$res= "";
		foreach ($users as $key => $value) {
			$files = $result = array();
			$result = explode($seperator, $value);
			$files = preg_grep('~^'.$result[0].'-.*\.(txt)$~', scandir("texts/"));
			switch ($function) {
			 	case 'countAverageLineCount':
			 		{
						$res = lineCount($files);
						echo "ID:   ".$result[0]."      Username:    ".$result[1]."       AverageLineNumbers:    ".$res."\n";
			 			break;
			 		}
		 		case 'replaceDates':
			 		{
			 			$res = replaceDates($files);
						echo "ID:   ".$result[0]."      Username:    ".$result[1]."       Number of Date Replacements:    ".$res."\n";
			 			break;
			 		}
			 	default:
			 		break;
			 }

		}



}



?>