<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html>

<head>

<title>importcsv</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">

<?
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;

echo "<table width=\"600\">";
echo "<form action=" . $_SERVER["PHP_SELF"] ." method='post' enctype='multipart/form-data'>";

echo "<tr>";
echo "<td width='20%'>Select file</td>";
echo "<td width='80%'><input type='file' name='file' id='file' ></td>";
echo "<tr>";

echo "<tr>";
echo "<td>Submit</td>";
echo "<td><input type='submit' name='submit' /></td>";
echo "<tr>";

echo "</form>";
echo "</table>";

$connexion =Connexion ($user_sql, $password, $dsn, $host);

if ( isset($_POST["submit"]) ) {
   if ( isset($_FILES["file"])) {
            //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }
        else {
                 //Print file details
             echo "Upload: " . $_FILES["file"]["name"] . "<br />";
             echo "Type: " . $_FILES["file"]["type"] . "<br />";
             echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
             echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

                 //if file already exists
             if (file_exists("upload/" . $_FILES["file"]["name"])) {
            echo $_FILES["file"]["name"] . " already exists. ";
             }
             else {
                    //Store file in directory "upload" with the name of "uploaded_file.txt"
            $storagename = "uploaded_file.txt";
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);
            echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
            }
        }
     } else {
             echo "No file selected <br />";
     }
}

if ( $file = fopen( "upload/" . $storagename , 'r' ) ) {
    echo "File opened.<br />";
    $firstline = fgets ($file, 4096 );
        //Gets the number of fields, in CSV-files the names of the fields are mostly given in the first line
    $num = strlen($firstline) - strlen(str_replace(";", "", $firstline));
        //save the different fields of the firstline in an array called fields
    $fields = array();
    $fields = explode( ";", $firstline, ($num+1) );
    $line = array();
    $i = 0;
        //CSV: one line is one record and the cells/fields are seperated by ";"
        //so $dsatz is an two dimensional array saving the records like this: $dsatz[number of record][number of cell]
    while ( $line[$i] = fgets ($file, 4096) ) {
        $dsatz[$i] = array();
        $dsatz[$i] = explode( ";", $line[$i], ($num+1) );
        $i++;
    }
//echo print_r($dsatz);
        echo "<table>";
        echo "<tr>";
    for ( $k = 0; $k != ($num+1); $k++ ) {
        echo "<td>".$fields[$k]."</td>";
    }
        echo "</tr>";

    foreach ($dsatz as $key => $number) {
                //new table row for every record
        echo "<tr>";
        foreach ($number as $k1 => $content) {
                        //new table cell for every field of the record
            echo "<td>" . $content . "</td>";
        }
    }

    echo "</table>";
}
mysql_close($connexion);
echo"</body>";
echo "</html>";
?>