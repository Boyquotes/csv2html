<html>
<head>
	<meta charset="utf-8">
	<title>Recrutement candidature</title>
	
	<link rel="stylesheet" href="./js/jquery-ui/jquery-ui.theme.css">
	<link rel="stylesheet" type="text/css" href="./csv2html.css">

	<script src="./js/jquery-2.1.4.min.js"></script>
	<script src="./js/jquery-ui/jquery-ui.min.js"></script>
	
	<script>
		jQuery(document).ready(function(){
			$("#tags").autocomplete({
			minLength: 2,
			select: function(event, ui) {
				if(ui.item){
					//console.log(ui);
					//console.log(ui.item);
					//console.log(ui.item.value);
				}
				$('html, body').animate({
					scrollTop: $("#"+ui.item.value).offset().top
				}, 100);
			}
			});
		});
	</script>
</head>

<body>

<div class="ui-widget">
  <label for="tags">Candidat : </label>
  <input id="tags">
</div>

<?php
$f = fopen("candidatures.csv", "r");
$fnotes = fopen("notes.csv", "r");
$i = 0;
$j = 0;
$modulo = 0;
$count = 0;
$liste = '';
$listeTags = '';

while (($line = fgetcsv($f)) !== false) {
    $count = $count+1;
    $tab_candidat[] = $line;
    if($i != 0 ){
        $liste .= "<li> ".$i." - <a href='#".$i."' id='#".$i."'>".$line[1]." ".$line[2]."</a></li>";
        $listeTags .= '{ label:"'.$line[1].' '.$line[2].'", value:"'.$i.'" },';
// - <a href='https://www.google.fr/search?q=".$line[1]."+".$line[2]."' target='_blank'> Googliser</a></li>";
    }
    $i++;
}

echo '<script>
  $(function() {
    var availableCandidats = [
      '.$listeTags.'
    ];
    $( "#tags" ).autocomplete({
      source: availableCandidats
    });
  });
  </script>';

$i = 0;
echo "Nombres de candidat.e.s: ";
echo $count-1;

echo "<ul class='list'>";
	print_r($liste);
echo "<div class='clear'></div>";
echo "</ul>";


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
		$li = "<div class='box ".$alternance."' id='".$i."'>";
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
		echo "<div class='clear'></div>";
		echo "</div>";
      }
    $i++;
}

fclose($f);
?>

</body>
</html>
