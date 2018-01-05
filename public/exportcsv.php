<?php 
$delimter = ",";
$filename = "members_".date('y-m-d').".csv";

var_dump($_GET);
exit();
$f = fopen('php://memory','w');

$fields = array("Date","Entry Num","Project");

fputcsv($f,$fields,$delimter);

// foreach($ledgers as $ledger){
    
//     $lineData = array(date('d/m/Y', strtotime($ledger->date_post)),$ledger->entryNum,$ledger->project);

// fputcsv($f,$lineData,$delimter);
// }

fseek($f,0);
header('Content-Type: text/csv');
header('Content-Disposition: attachement; filename="'.$filename.'"');

fpassthru($f);


?>