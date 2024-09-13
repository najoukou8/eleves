<?php
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=export_base_eleves_" . date("d-m-Y").".csv");
print urldecode(($_POST['csv_output']));

?>

