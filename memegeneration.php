<?php
function makememe(){

// first, we initialize some Tufts-related content

// an array of dining halls, weighted towards carm and dewick
// {{dininghall}}
$dininghalls = array("Carm", "Dewick", "brown and brew", "hodgdon", "hotung", "pax et lox", "carm", "dewick", "carm", "dewick");

// an array of dorms
// {{dorm}}
$dorms = array("hill", "hodgdon" );

// an array of student types
// {{students}}
$studenttypes = array("IR majors", "CS majors", "SMFA students", "engineers", "non-engineers");

// next, we make some meme structures
$sentences = array("tfw when there are too many {{students}} at {{dininghall}}");
$meme = $sentences[mt_rand(0,count($sentences) - 1)];


// do the substitutions
$meme = str_ireplace("{{dininghall}}", $dininghalls[mt_rand(0, count($dininghalls) - 1)], $meme);
$meme = str_ireplace("{{dorm}}", $dorms[mt_rand(0, count($dorms) - 1)], $meme);
  $meme = str_ireplace("{{students}}", $studenttypes[mt_rand(0, count($studenttypes) - 1)], $meme);


return $meme;


}

echo makememe();
 ?>
