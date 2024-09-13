<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>Pivot GI promos</title>
        <!-- external libs from cdnjs -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>

        <!-- PivotTable.js libs from ../dist -->
        <link rel="stylesheet" type="text/css" href="../dist/pivot.css">
        <script type="text/javascript" src="../dist/pivot.js"></script>
        <script type="text/javascript" src="../dist/pivot.fr.js"></script>
        <script type="text/javascript" src="../dist/export_renderers.js"></script>
        <script type="text/javascript" src="../dist/d3_renderers.js"></script>
        <script type="text/javascript" src="../dist/c3_renderers.js"></script>
        <style>
            body {font-family: Verdana;}
            .node {
              border: solid 1px white;
              font: 10px sans-serif;
              line-height: 12px;
              overflow: hidden;
              position: absolute;
              text-indent: 2px;
            }
            .c3-line, .c3-focused {stroke-width: 3px !important;}
            .c3-bar {stroke: white !important; stroke-width: 1;}
            .c3 text { font-size: 12px; color: grey;}
            .tick line {stroke: white;}
            .c3-axis path {stroke: grey;}
            .c3-circle { opacity: 1 !important; }
            .c3-xgrid-focus {visibility: hidden !important;}
        </style>
<SCRIPT TYPE="text/javascript" SRC="../../../filterlist.js"></SCRIPT>
        <!-- optional: mobile support with jqueryui-touch-punch -->
<!--      
	  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

        <!-- for examples only! script to show code to user 
      <script type="text/javascript" src="show_code.js"></script>-->
    </head>
    <body>
       
 <?php
require ("../../../param.php");
require ("../../../function.php");
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);

//-------------------------------------------------
       echo " <p><a href='../../../accueil_stats.php'>&laquo; retour accueil stats</a></p>	";	
if (  !isset($_GET['groupe'])){
	if (!isset($_POST['groupe']))
	{
		
		$_POST['groupe']='2402';
	}
}
	else
	{
		$_POST['groupe']=$_GET['groupe'];
	}
	
	
if (  !isset($_GET['row_affiche']))
	{	
	$row_affiche='statut_final';
	}
	else
	{
		$row_affiche=$_GET['row_affiche'];
	}
	
if (  !isset($_GET['multian']))
	{
	if (  !isset($_POST['multian']))
		{	
		$multian='0';
		}
		else
		{
		$multian=$_POST['multian'];
		}	
	}
	else
	{
		$multian='1';
	}

	
  echo "<center><table  border=0>";
  echo "<tr><td>";
echo "</td></tr><tr><td>";
   echo "</td><td>"; 

echo    "<form method=post action=".$_SERVER['PHP_SELF']." name='monform'> ";
echo "<input type=hidden name='multian' value='".$multian."'";
echo "choisir le groupe : <br>";
echo "</td></tr><tr><td>"; 
echo "<INPUT NAME=regexp onKeyUp='myfilter.set(this.value)' size=30>";
echo "<br>";
echo "( vous pouvez saisir une partie du nom
du groupe pour filtrer la liste )";
echo "</td><td>"; 
   if ($multian)
   {
$sql="select * from groupes where (archive='oui' ) or (groupe_officiel='oui' and type_gpe_auto='') or libelle='TOUS' order by libelle";
   }
   else
   {
$sql="select * from groupes where  (archive!='oui' and groupe_officiel='oui' and type_gpe_auto='')  order by libelle";	   
   }
echo affichemenusql('','groupe','code',$sql,'libelle',$_POST['groupe'],$connexion,'  onchange=\'monform.submit()\' onkeypress=\'monform.submit()\' ','');
echo "</td><td>"; 
echo "<SCRIPT TYPE='text/javascript'>";
echo "var myfilter = new filterlist(document.monform.groupe)";
echo "</SCRIPT>";	  
echo "</tr><tr><td>";  
	//echo "<input type='Submit' name='mod' value='OK'> "; 
     echo "</td></tr>";
    echo "</table>";
echo "</form>";

//----------------------------------------------------------



echo " <script type='text/javascript'>";
echo "    $.ajax({
        type: 'GET',
        url: '../../../statsjson2.php?groupe=".$_POST['groupe']."&multian=".$multian."',
        success: function (response) {
        var renderers = $.extend(
            $.pivotUtilities.renderers,
            $.pivotUtilities.c3_renderers,
            $.pivotUtilities.d3_renderers,
            $.pivotUtilities.export_renderers
            );
			//console.log ('success');
			//console.log('mps : ', response);
			data = response.trim();
			mps = JSON.parse(data);
			//console.log('mps :', mps);
            $('#output').pivotUI(mps, {
					renderers: renderers,
					rows: ['".$row_affiche."']
					
               
            });
        },
		error: function () {
			console.log ('Error !');
		}
    });
        </script>
		";
		

		


		
		
if ($multian) echo "<i> comme vous avez accès aux données des années passées, le jeu de variables est restreint aux variables 'immuables'</i><br>";		
echo "	Instructions : choisir une  variable  et la déposer dans la zone Count  'lignes'<br>
choisir une autre  variable et la déposer dans la zone Count  'colonnes'<br>
(si nécessaire enlever les variables inutiles en les tirant vers la zone 'variables' 	<br>
on peut aussi filtrer sur certaines valeurs en cliquant sur le triangle à coté du nom de la variable)<br>";
?>
        <div id="output" style="margin: 30px;"></div>

    </body>
</html>
