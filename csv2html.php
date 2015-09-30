<html>
<head>
	<meta charset="utf-8">
	<title>Recrutement candidature</title>
	<link rel="stylesheet" type="text/css" href="./csv2html.css"
</head>

<body>

<?php
$f = fopen("candidatures.csv", "r");
$i = 0;
$j = 0;
$modulo = 0;
$count = 0;
$liste = '';

while (($line = fgetcsv($f)) !== false) {
    $count = $count+1;
    $tab_candidat[] = $line;
    if($i != 0 ){
        $liste .= "<li> ".$i." - <a href='#".$i."'>".$line[1]." ".$line[2]."</a></li>";
// - <a href='https://www.google.fr/search?q=".$line[1]."+".$line[2]."' target='_blank'> Googliser</a></li>";
    }
    $i++;
}

$i = 0;
echo "Nombres de candidat.e.s: ";
echo $count-1;

echo "<ul class='list'>";
	print_r($liste);
echo "<div class='clear'></div>";
echo "</ul>";

echo "<ul>";
foreach ($tab_candidat as $candidat) {
    $modulo = $i%2;

    if($modulo == 0){
        $alternance = "color_one";
    }
    if($modulo == 1){
        $alternance = "color_two";
    }
	if($i == 0){
		foreach ($candidat as $cell) {
			$content = htmlspecialchars($cell); 
			switch($j){
				case 0:
					$class = "horodateur";
					break;
				case 1:
					$class = "prenom";
					break;
				case 2:
					$class = "nom";
					break;
				case 3:
					$class = "age";
					break;
				case 6:
					$class = "adresse";
					break;
				case 7:
					$class = "email";
					break;
				case 8:
					$class = "numero";
					break;
						default: 
								$class = "normal";
					break;
			}
			$entete[$j] = "<span class='".$class."'><b>".$content. "</b><br />";
			$j++;
		}
    }
	else{
		$li = "<li class='box ".$alternance."' id='".$i."'>";
		echo $li;
		$j = 0;
		foreach ($candidat as $cell) {
			$content = htmlspecialchars($cell); 
			if($j == "3"){
				$this_year = date('Y');
				list($month, $day, $year) = explode('/', $content);
				$age = $this_year - $year;
				$content = $content.' - '.$age.' ans';
			}            
			if($j == "14"){
				$content = "<a href='".$content."' target='_blank'>".$content."</a>"; 
			}               
			if($j == "15"){
				$content = "<a href='".$content."' target='_blank'>".$content."</a>"; 
			}               
			echo $entete[$j];
			echo $content;
			echo "</span>";
			$j++;
		}
      echo "</li>";
      }
    echo "</ul>";   
    $i++;
}
fclose($f);
?>
</ul>
</body>
</html>
