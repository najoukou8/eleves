<?

require __DIR__."/vendor/autoload.php" ;
use Symfony\Component\Yaml\Yaml;

class Parameters {

    public static function getParameters(){
        return Yaml::parseFile(__DIR__."/config/parameters.yaml");
    }

    public static function getEMGiUsers() {
        $boot = require __DIR__."/bootstrap-cli.php";
        return $boot["DB_GI_USERS"]->getConnection() ;
    }

}


function Connexion ($nom, $passe, $base, $server)
{

// Connexion au serveur
$cnx = mysqli_connect ($server,$nom, $passe, $base);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Echec de connexion  à MySQL: " . mysqli_connect_error();
  }
  else
// On renvoie la variable de connexion
return $cnx;
}

function mysql_query($query,$connexion='' )
{
	if($connexion=='')
	{
		global $connexion;
	}
$result= $connexion->query($query);	
return $result;
}

function mysql_fetch_array($query)
{
$result= mysqli_fetch_array($query);	
return $result;
}

function mysql_fetch_assoc($query)
{
$result= mysqli_fetch_assoc($query);	
return $result;
}

function mysql_fetch_object($query)
{
$result= mysqli_fetch_object($query);	
return $result;
}

function mysql_num_rows($result)
{
$nbrdelignes= $result->num_rows;
return $nbrdelignes;
}

function mysql_affected_rows($connexion='')
{
	if($connexion=='')
	{
		global $connexion;
	}
$nbrdelignes= mysqli_affected_rows($connexion);
return $nbrdelignes;
}


function mysql_close($connexion='')
{
if($connexion=='')
	{
		global $connexion;
	}
mysqli_close($connexion);
}

function mysql_error($connexion='')
{
if($connexion=='')
	{
		global $connexion;
	}
return mysqli_error($connexion);
}

function mysql_real_escape_string($var,$connexion='')
{
if($connexion=='')
	{
		global $connexion;
	}
return $connexion->real_escape_string($var);
}

function debug($var,$nom=' nom pas transmis')
{
	 echo"<br><pre>";
echo "<b>".$nom."</b><br>";	 
	var_dump($var);
	 echo"<br></pre>"; 
}
	 
function echosur($string)
    {
$string=  	htmlspecialchars($string, ENT_QUOTES, 'ISO8859-1',false);       
        return $string;
    } 


function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}
// pour indexer  tableau avec index avec array_map
function tabindextab($indexs,$tableau) {
	if(sizeof($indexs)!=sizeof($tableau))
	{
		return false;
	}
	else
	{
	$result=array();
	$i=0;
   foreach ($indexs as $index)
   {
	   $result[$index]=$tableau[$i];
	   $i++;
   }
   return $result;
	}
}


function stripAccents($string) {
	return strtr($string,
			'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
			'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

function nettoie($chaine) {

	$chaine = strtr($chaine,
			'àáâãäçèéêë€ìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
			'aaaaaceeeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	$chaine = preg_replace('#[^A-Za-z0-9]+#', '-', $chaine);
	$chaine = trim($chaine, '-');
	$chaine = strtolower($chaine);

	return $chaine;
}

function Connexionold ($nom, $passe, $base, $server)
{
// Connexion au serveur
$cnx = mysql_pconnect ($server,$nom, $passe);
if ($cnx == 0) {
echo "Connexion à $server impossible\n";
return 0;
}
// Connexion à la base
if (mysql_select_db ($base, $cnx) == 0) {
echo "Accès à $base impossible\n";
echo mysql_error($cnx);
return 0;
}
// On renvoie la variable de connexion
return $cnx;
}

function ConnexionPDO ($user_sql, $password, $dsn, $host)
{
	try{
		$bdd =new PDO("mysql:host=".$host.";dbname=".$dsn.";", $user_sql, $password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
	catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
	}
// On renvoie la variable de connexion
return $bdd;	
}



function nettoiechamps($champs,$table)
//remplace les espaces,tiretset slash par des espaces
//prefixe par le nom de la table et passe en minuscule
{
$champs=str_replace("-","_",$champs);
$champs=str_replace(".","_",$champs);
$champs=str_replace("/","_",$champs);
$champs=str_replace(" ","_",$champs);
$champs=str_replace("'","_",$champs);
$champs="my".$table.strtolower($champs);
return $champs;

}

function nettoiefloat($nombre)
//remplace les virgules par des points
//supprimme tous les autres caractères que point et chiffre
{
$nombre=str_replace(",",".",$nombre);
$nombre = preg_replace('#[^0-9.]+#', '', $nombre);
// si vide retourne 0
if ($nombre=='')$nombre=0;
return $nombre;

}

//creation d'un tableau des champs d'une table
function champsfromtable ($table,$connexion='',$prefixe=0)
//$prefixe détermine si on renvoie le nom complet table.champ
{
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
		$req = $connexion->query("SHOW FULL COLUMNS FROM $table");
		if (!$req) {
		   echo 'Impossible d\'exécuter la requête  ';
		   exit;
		}
		if ($req->rowCount() > 0) {
			while ($row  = $req->fetch(PDO::FETCH_ASSOC)) {	
if ($prefixe)
			  $champs[]= $table.".".$row["Field"];
		  else
			  $champs[]= $row["Field"];			  
			  //$type[]= $row["Type"];
		   }
		}
	}
else
{
$result = mysql_query("SHOW COLUMNS FROM $table");
if (!$result) {
	   echo 'Impossible d\'exécuter la requête : ' . mysql_error();
	   exit;
	}
if (mysql_num_rows($result) > 0) {
	   while ($row = mysql_fetch_assoc($result)) {

		  $champs[]= $row["Field"];
		  //$type[]= $row["Type"];
	   }
	}	
}
return $champs;
}

//creation d'un tableau des champs et type d'une table
function champstypefromtable ($table,$connexion='',$prefixe=0)
//$prefixe détermine si on renvoie le nom complet table.champ
{
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
		$req = $connexion->query("SHOW FULL COLUMNS FROM $table");
		if (!$req) {
		   echo 'Impossible d\'exécuter la requête  ';
		   exit;
		}
		if ($req->rowCount() > 0) {
			while ($row  = $req->fetch(PDO::FETCH_ASSOC)) {	
				if ($prefixe)
				$champs[$table.".".$row["Field"]]= $row["Type"];
				else
				$champs[$row["Field"]]= $row["Type"]; 
		   }
		}
	}
	else
	{
		$result = mysql_query("SHOW COLUMNS FROM $table");
		if (!$result) {
		   echo 'Impossible d\'exécuter la requête : ' . mysql_error();
		   exit;
		}
		if (mysql_num_rows($result) > 0) {
		   while ($row = mysql_fetch_assoc($result)) {
				if ($prefixe)
				$champs[$table.".".$row["Field"]]= $row["Type"];
				else
				$champs[$row["Field"]]= $row["Type"]; 
		   }
		}	
	}
return $champs;
}

//creation d'un tableau des champs et commentaires d'une table
function champscommentfromtable ($table,$connexion='',$prefixe=0)
{
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
		$req = $connexion->query("SHOW FULL COLUMNS FROM $table");
		if (!$req) {
		   echo 'Impossible d\'exécuter la requête  ';
		   exit;
		}
		if ($req->rowCount() > 0) {
			while ($row  = $req->fetch(PDO::FETCH_ASSOC)) {	
				if ($prefixe)
				$champs[$table.".".$row["Field"]]= $row["Comment"];	 
				else
				$champs[$row["Field"]]= $row["Comment"];	  			  
		   }
		}
	}
	else
	{
		$result = mysql_query("SHOW FULL COLUMNS FROM $table");
		if (!$result) {
		   echo 'Impossible d\'exécuter la requête : ' . mysql_error();
		   exit;
		}
		if (mysql_num_rows($result) > 0) {
		   while ($row = mysql_fetch_assoc($result)) {
				if ($prefixe)
				$champs[$table.".".$row["Field"]]= $row["Comment"];	 
				else
				$champs[$row["Field"]]= $row["Comment"];				  
		   }
		}	
	}
return $champs;
}

//creation d'un tableau des commentaires d'une table avec séparation par un caractère défini
function champscommentfromtableplus ($table,$connexion='',$prefixe=0,$separateur='',$index=0)
{
	// correction 2019 initialisation des paramètres avant la derniere position
	if ($prefixe=='')$prefixe=0;
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
		$req = $connexion->query("SHOW FULL COLUMNS FROM $table");
		if (!$req) {
		   echo 'Impossible d\'exécuter la requête  ';
		   exit;
		}
		if ($req->rowCount() > 0) {
			while ($row  = $req->fetch(PDO::FETCH_ASSOC)) {	
			if($separateur !='' )
			{
				$morceau=explode($separateur,$row["Comment"]);
				if ( array_key_exists ($index , $morceau ))
				$row["Comment"]=$morceau[$index];
				else
				$row["Comment"]='';
			}
				if ($prefixe)
				$champs[$table.".".$row["Field"]]= $row["Comment"];	 
				else
				$champs[$row["Field"]]= $row["Comment"];	  			  
		   }
		}
	}
	else
	{
		$result = mysql_query("SHOW FULL COLUMNS FROM $table");
		if (!$result) {
		   echo 'Impossible d\'exécuter la requête : ' . mysql_error();
		   exit;
		}
		if (mysql_num_rows($result) > 0) {
		   while ($row = mysql_fetch_assoc($result)) {
			if($separateur !='')
			{
				$morceau=explode($separateur,$row["Comment"]);
				if ( array_key_exists ($index , $morceau ))
				$row["Comment"]=$morceau[$index];
				else
				$row["Comment"]='';
			}			   
				if ($prefixe)
				$champs[$table.".".$row["Field"]]= $row["Comment"];	 
				else
				$champs[$row["Field"]]= $row["Comment"];				  
		   }
		}	
	}
return $champs;
}

//creation d'un tableau des tailles  des champs d'une table si pas type varchar long =0
function champstaillefromtable ($table,$connexion='')
{
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
		$req = $connexion->query("SHOW FULL COLUMNS FROM $table");
		if (!$req) {
		   echo 'Impossible d\'exécuter la requête  ';
		   exit;
		}
		if ($req->rowCount() > 0) {
			while ($row  = $req->fetch(PDO::FETCH_ASSOC)) {	
		if (substr($row["Type"],0,7)=='varchar'){
		 $champs[]= substr($row["Type"],8,-1);
		} 
		elseif (substr($row["Type"],0,6)=='bigint'){
			  $champs[]= '19';
			 }
			 elseif (substr($row["Type"],0,8)=='datetime'){
			  $champs[]= '23';
			 }
			 elseif (substr($row["Type"],0,8)=='text'){
			 // normalement 65535 mais on limitera à 30000
			  $champs[]= '30000';
			 }
			 else{
			 // defaut pour les autres types(au cas où  normalement je ne les utilise pas)
			  $champs[]= '20';	 
			 }
			  
		   }
		}
	}
	else
	{
		$result = mysql_query("SHOW COLUMNS FROM $table");
		if (!$result) {
		   echo 'Impossible d\'exécuter la requête : ' . mysql_error();
		   exit;
		}
		if (mysql_num_rows($result) > 0) {
		   while ($row = mysql_fetch_assoc($result)) {
		if (substr($row["Type"],0,7)=='varchar'){
		 $champs[]= substr($row["Type"],8,-1);
		} 
		elseif (substr($row["Type"],0,6)=='bigint'){
			  $champs[]= '19';
			 }
			 elseif (substr($row["Type"],0,8)=='datetime'){
			  $champs[]= '23';
			 }
			 elseif (substr($row["Type"],0,8)=='text'){
			 // normalement 65535 mais on limitera à 30000
			  $champs[]= '30000';
			 }
			 else{
			 // defaut pour les autres types(au cas où  normalement je ne les utilise pas)
			  $champs[]= '20';	 
			 }		  
		   }
		}
	}	
return $champs;
}

//creation d'un tableau des tailles  des champs d'une table si pas type varchar long =0
function champsindextaillefromtable($table,$connexion='',$prefixe=0)
{
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
		$req = $connexion->query("SHOW FULL COLUMNS FROM $table");
		if (!$req) {
		   echo 'Impossible d\'exécuter la requête  ';
		   exit;
		}
		if ($req->rowCount() > 0) {
			while ($row  = $req->fetch(PDO::FETCH_ASSOC)) {	
		if (substr($row["Type"],0,7)=='varchar'){
				if ($prefixe)
				$champs[$table.".".$row["Field"]]= substr($row["Type"],8,-1);  			
				else
				$champs[$row["Field"]]= substr($row["Type"],8,-1);  

		} 
		elseif (substr($row["Type"],0,6)=='bigint'){
				if ($prefixe)
				$champs[$table.".".$row["Field"]]= '19';	
				else
				$champs[$row["Field"]]= '19';

			 }
			 elseif (substr($row["Type"],0,8)=='datetime'){		
			  if ($prefixe)
				$champs[$table.".".$row["Field"]]= '23';	
				else
				$champs[$row["Field"]]= '23';
			 }
			 elseif (substr($row["Type"],0,8)=='text'){
			 // normalement 65535 mais on limitera à 30000
			  if ($prefixe)
				$champs[$table.".".$row["Field"]]= '30000';	
				else
			  $champs[$row["Field"]]= '30000';		 

			 }
			 else{
			 // defaut pour les autres types(au cas où  normalement je ne les utilise pas)
			  if ($prefixe)
				$champs[$table.".".$row["Field"]]= '20';	
				else
			  $champs[$row["Field"]]= '20';	 
			 }
			  
		   }
		}
	}
	else
	{
		$result = mysql_query("SHOW COLUMNS FROM $table");
		if (!$result) {
		   echo 'Impossible d\'exécuter la requête : ' . mysql_error();
		   exit;
		}
		if (mysql_num_rows($result) > 0) {
		   while ($row = mysql_fetch_assoc($result)) {
		if (substr($row["Type"],0,7)=='varchar'){
				if ($prefixe)
				$champs[$table.".".$row["Field"]]= substr($row["Type"],8,-1);  			
				else
				$champs[$row["Field"]]= substr($row["Type"],8,-1); 
		} 
		elseif (substr($row["Type"],0,6)=='bigint'){
				if ($prefixe)
				$champs[$table.".".$row["Field"]]= '19';	
				else
				$champs[$row["Field"]]= '19';
			 }
			 elseif (substr($row["Type"],0,8)=='datetime'){
			  if ($prefixe)
				$champs[$table.".".$row["Field"]]= '23';	
				else
				$champs[$row["Field"]]= '23';
			 }
			 elseif (substr($row["Type"],0,8)=='text'){
			 // normalement 65535 mais on limitera à 30000
			  if ($prefixe)
				$champs[$table.".".$row["Field"]]= '30000';	
				else
			  $champs[$row["Field"]]= '30000';	
			 }
			 else{
			 // defaut pour les autres types(au cas où  normalement je ne les utilise pas)
			  if ($prefixe)
				$champs[$table.".".$row["Field"]]= '20';	
				else
			  $champs[$row["Field"]]= '20';	  
			 }		  
		   }
		}
	}	
return $champs;
}


function OpenConnect (&$C) {
    $result = true;
    $C = odbc_connect('base_eleves','','');
    return ($result); //renvoi du code d'erreur, plus tard peut-être.
} //OpenConnect

function affichechamp ($titre,$champ,$valeur,$taille=30,$ro='',$maj='',$coteacote='',$colospan='',$nc='',$js='',$id='')
{
		// correction 2019 initialisation des paramètres avant la derniere position
	if ($taille=='')$taille=30;
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
 // $nc permet  d'afficher ce qu'on veut si $valeur est vide
 $result='';
	if ($valeur=='' and $nc!='' ){
	$valeur=$nc;
	}	
	if($colospan!=''  )
    {$colospan="colspan=".$colospan;}
    if($ro  )
    {$ro="readonly";}
    if($maj  )
    {$maj="onChange='javascript:this.value=this.value.toUpperCase();'";}	
	if($coteacote  )
    {$result= "<td>$titre</td><td ".$colospan." ><input type='text' $ro $maj $js size='$taille' name='$champ' id='$id' value=\"".echosur($valeur)."\"></td> \n  ";}
	else	
    {$result= "<td ".$colospan." >$titre<input type='text' $ro $maj $js size='$taille' name='$champ' id='$id' value=\"".echosur($valeur)."\"></td>\n   ";}

	return ($result);
}

function affichechampsipasvide ($titre,$champ,$valeur,$taille=30,$ro='',$maj='',$coteacote='',$colospan='',$js='',$id='')
{
		// correction 2019 initialisation des paramètres avant la derniere position
	if ($taille=='')$taille=30;
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
	$result='';
	if ($valeur!=''){
		if($colospan!=''  )
	    {$colospan="colspan=".$colospan;}
	    if($ro  )
	    {$ro="readonly";}
	    if($maj  )
	    {$maj="onChange='javascript:this.value=this.value.toUpperCase();'";}	
		if($coteacote  )
	    {$result= "<td>$titre</td><td ".$colospan." ><input type='text' $ro $maj size='$taille' name='$champ' id='$id' $js value=\"".echosur($valeur)."\"></td> \n  ";}
		else	
	    {$result= "<td ".$colospan." >$titre<input type='text' $ro $maj size='$taille' name='$champ' id='$id' $js value=\"".echosur($valeur)."\"></td>\n   ";}
	}
    return ($result);
}
function afficheonly ($titre,$valeur,$tagtitre='font',$tagvaleur='font',$colospan='',$nohtml=1)
 {
		// correction 2019 initialisation des paramètres avant la derniere position
	if ($tagtitre=='')$tagtitre='font';
	if ($tagvaleur=='')$tagvaleur='font';
//juste pour afficher quelque chose en dehors d'un form comme ds un champ : comme ça pas de probleme au niveau variable

	if($colospan!=''  )
    {$colospan="colspan=".$colospan;}
	if ($nohtml)
			$result= "<td ".$colospan." >"."<".$tagtitre.">".$titre."</".$tagtitre.">"."<br>"."<".$tagvaleur.">".echosur($valeur)."</".$tagvaleur.">"."</td>   ";
	else
			$result= "<td ".$colospan." >"."<".$tagtitre.">".$titre."</".$tagtitre.">"."<br>"."<".$tagvaleur.">".$valeur."</".$tagvaleur.">"."</td>   ";
	
 return ($result);
}
function affichealerte ($texte,$nohtml=0)
//juste pour afficher quelque chose en dehors d'un form comme ds un champ : comme ça pas de probleme au niveau variable
 {
	 if ($nohtml)
    $result= "<center><font color='red' size='4' ><b>".echosur($texte)."</b></font></center>";
	else
    $result= "<center><font color='red' size='4' ><b>".$texte."</b></font></center>";	
   return ($result);
}


function affichemenu ($titre,$champ,$liste,$selection='',$js='',$id='')
{
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
	 	 	$selected=0;
      $result= "<td>$titre<select name='$champ' id='$id' $js>";
       for($i=0;$i<sizeof($liste);$i++) {
    //les  2 lignes ci dessous sont une autre solution pour un recuperer les codes correspondant aux noms
      //echo "  <option  value=\"".current($etudiants_code)."\">";
    $result.="<option	value=\"".echosur(current($liste))."\" ";
      if  ($selection== current($liste) ){
         $result.= " SELECTED ";$selected=1;}
         $result.= ">";
    $result.= current($liste);
     next($liste);
    $result.="</option> " ;
    }
			// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if($selection!='' and !$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}
    $result.="</select></td>";
    return ($result);
}

function affichemenunc ($titre,$champ,$liste,$selection='',$js='',$id='',$valeursivide="NC")
{
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
	 	$selected=0;
      $result= "<td>$titre<select name='$champ' id='$id' $js>";
       for($i=0;$i<sizeof($liste);$i++) {
		   // pour éviter d'avoir 2 lignes de vide (une vide une nc ) si il y a un vide dans liste
		   if (current($liste) !='')
		   {
    //les  2 lignes ci dessous sont une autre solution pour un recuperer les codes correspondant aux noms
      //echo "  <option  value=\"".current($etudiants_code)."\">";
    $result.="<option	value=\"".echosur(current($liste))."\" ";
      if  ($selection== current($liste)   ){
         $result.= " SELECTED ";$selected=1;}
         $result.= ">";
    $result.= current($liste);
    $result.="</option> " ;
		   }
		next($liste);
    }
			$result.= "<option value=\"\" ";
	if ($selection==''){$result.=" SELECTED ";$selected=1;}
	$result.=" >$valeursivide</option>";
		// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if(!$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}
    $result.="</select></td>";
    return ($result);
}

function affichemenunconlystring ($titre,$champ,$liste,$selection='',$js='',$id='',$valeursivide="NC")
{
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
    $selected=0;
      $result= "<td>$titre<select name='$champ' id='$id' $js>";
       for($i=0;$i<sizeof($liste);$i++) {
    //les  2 lignes ci dessous sont une autre solution pour un recuperer les codes correspondant aux noms
      //echo "  <option  value=\"".current($etudiants_code)."\">";
    $result.="<option value=\"".echosur(current($liste))."\" ";
      if  ($selection== current($liste) ){
         $result.= " SELECTED ";$selected=1;}
         $result.= ">";
    $result.= current($liste);
     next($liste);
    $result.="</option> " ;
    }
      $result.= "<option value=\"\" ";
  if ($selection==''){$result.=" SELECTED ";
  $selection=$valeursivide;$selected=1;}
  $result.=" >$valeursivide</option>";
    // si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
  if(!$selected)
  {$result.="<option value='".$selection."' SELECTED> erreur ! </option>";
	$selection=" erreur !";
	}
    $result="</select></td>";
    return ($selection);
}

function affichemenucouleur ($titre,$champ,$liste,$selection='',$listecouleurs,$disabled='',$js='',$id='')
{
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
	 	$selected=0;
 //on retrouve la couleur de la valeur courante
        for($i=0;$i<sizeof($liste);$i++) {
		      if  ($selection== current($liste) ){
			  $couleurcourante=current($listecouleurs);
			  }
	next($liste);
	 next($listecouleurs);  
		}
 reset ($liste);
 reset($listecouleurs);
      $result= "<td>$titre<select name='$champ' id='$id'  style=\"background-color:".$couleurcourante."\"  onchange=\"this.style.backgroundColor=this.options[this.selectedIndex].style.backgroundColor;\" ".$js." ".$disabled .">";
       for($i=0;$i<sizeof($liste);$i++) {
    //les  2 lignes ci dessous sont une autre solution pour un recuperer les codes correspondant aux noms
      //echo "  <option  value=\"".current($etudiants_code)."\">";
    $result.="<option	value=\"".echosur(current($liste))."\" ";
      if  ($selection== current($liste) ){
         $result.= " SELECTED ";$selected=1;}
         $result.="style=\"background-color:".current($listecouleurs)."\"";
		 $result.= ">";
    $result.= current($liste);
     next($liste);
	 next($listecouleurs);
    $result.="</option> " ;
    }
	// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if($selection!='' and !$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}	
  $result.="</select></td> " ;	
    $result.="</select></td>";
    return ($result);
}
function affichemenuplus ($titre,$champ,$liste,$selection='',$js='',$id='')
{
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
 //permet de generer un select à partir d'un tableau à 2 colonnes libelle -valeur a retourner
	$selected=0;
      $result= "<td>$titre<select name='$champ' id='$id' $js>";
       for($i=0;$i<sizeof($liste[0]);$i++) {
    $result.=  "<option  value=\"".echosur($liste[0][$i])."\" " ;
      if  ($selection==$liste[0][$i] ){
         $result.= " SELECTED ";$selected=1;}
         $result.= ">";
    $result.= $liste[1][$i];
    $result.="</option> " ;
    }
	// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if($selection!='' and !$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}
    $result.="</select></td>";
    return ($result);
}

function affichemenuplus2tab ($titre,$champ,$listelib,$listeret,$selection='',$js='',$id='')
{
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
 //permet de generer un select à partir de 2 tableau à 1 colonne libelle -valeur a retourner
	$selected=0;
      $result= "<td>$titre<select name='$champ' id='$id' $js>";
       for($i=0;$i<sizeof($listelib);$i++) {
    $result.=  "<option  value=\"".echosur($listeret[$i])."\" " ;
      if  ($selection==$listeret[$i] ){
         $result.= " SELECTED ";$selected=1;}
         $result.= ">";
    $result.= $listelib[$i];
    $result.="</option> " ;
    }
	// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if($selection!='' and !$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}
    $result.="</select></td>";
    return ($result);
}

function affichemenuplus2tabnc ($titre,$champ,$listelib,$listeret,$selection='',$js='',$id='',$valeursivide="NC")
{
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
 //permet de generer un select à partir de 2 tableau à 1 colonne libelle -valeur a retourner
	$selected=0;
      $result= "<td>$titre<select name='$champ' id='$id' $js>";
       for($i=0;$i<sizeof($listelib);$i++) {
    $result.=  "<option  value=\"".echosur($listeret[$i])."\" " ;
      if  ($selection==$listeret[$i] ){
         $result.= " SELECTED ";$selected=1;}
         $result.= ">";
    $result.= $listelib[$i];
    $result.="</option> " ;		   
    }
	
	
	$result.= "<option value=\"\" ";
	if ($selection==''){$result.=" SELECTED ";$selected=1;}
	$result.=" >$valeursivide</option>";
	// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if(!$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}
    $result.="</select></td>";
    return ($result);
}

function affichemenusql($titre,$champ,$champssqlretourne,$query,$champssqlaffiche,$selection='',$sqlconnect="",$js='',$id='')
{
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
$connexion =$sqlconnect;
	$selected=0;
$result= "<td>$titre<select name='$champ' id='$id' $js>";

	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
	$resultat = $connexion->query($query);		
		while ($resultsql = $resultat->fetch(PDO::FETCH_OBJ)) {
		  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
		  if  ($selection== $resultsql->$champssqlretourne ){
			 $result.= " SELECTED ";$selected=1;}
			 $result.= ">";
		$result.= $resultsql->$champssqlaffiche;
		$result.="</option> " ;
		}
	}
else
	{	
		$resultat = mysql_query($query,$connexion );
		while ($resultsql=mysql_fetch_object($resultat)) {	
		  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
		  if  ($selection== $resultsql->$champssqlretourne ){
			 $result.= " SELECTED ";$selected=1;}
			 $result.= ">";
		$result.= $resultsql->$champssqlaffiche;
		$result.="</option> " ;
		}
	}	
	// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if($selection!='' and !$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}	
  $result.="</select></td> " ;
  return ($result);
}
function affichemenusqlplus($titre,$champ,$champssqlretourne,$query,$champssqlaffiche,$selection='',$sqlconnect="",$champs2sqlaffiche="",$js='',$id='')
{
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
//idem à affichemenusql mais recupere  la connexiion et possibilite d'afficher 2 champs cote à cote avec un espace comme séparateur
$connexion =$sqlconnect;
	$selected=0;
$result= "<td>$titre<select name='$champ' id='$id' $js>";

	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
	$resultat = $connexion->query($query);		
	while ($resultsql = $resultat->fetch(PDO::FETCH_OBJ)) {	
		  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
		  if  ($selection== $resultsql->$champssqlretourne ){
			 $result.= " SELECTED ";$selected=1;}
			 $result.= ">";
		$result.= $resultsql->$champssqlaffiche;
		if ($champs2sqlaffiche!=""){
		$result.=" ". $resultsql->$champs2sqlaffiche;
		}
		$result.="</option> " ;
		}
	}
else
	{	
		$resultat = mysql_query($query,$connexion );
		while ($resultsql=mysql_fetch_object($resultat)) {
			  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
			  if  ($selection== $resultsql->$champssqlretourne ){
				 $result.= " SELECTED ";$selected=1;}
				 $result.= ">";
			$result.= $resultsql->$champssqlaffiche;
			if ($champs2sqlaffiche!=""){
			$result.=" ". $resultsql->$champs2sqlaffiche;
			}
			$result.="</option> " ;
			}
	}
		// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if($selection!='' and !$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}	
  $result.="</select></td>\n " ;
  return ($result);
}

function affichemenusqlplusnc($titre,$champ,$champssqlretourne,$query,$champssqlaffiche,$selection='',$sqlconnect="",$champs2sqlaffiche="",$valeursivide="NC",$js='',$id='')
{
		// correction 2019 initialisation des paramètres avant la derniere position
	if ($valeursivide=='')$valeursivide='NC';

	
	// version 2019 marc meilleure gestion des valeurs vides
//idem à affichemenusql :  recupere  la connexion et possibilite d'afficher 2 champs cote à cote avec un espace comme séparateur + nc si valeur defaut vide
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
$connexion =$sqlconnect;
	$selected=0;
$result= "<td>$titre<select name='$champ' $js id='$id'>";
	$result.= "<option value=\"\" ";
	if ($selection==''){$result.=" SELECTED ";$selected=1;}
	$result.=" >".echosur($valeursivide)."</option>";
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
	$resultat = $connexion->query($query);		
	while ($resultsql = $resultat->fetch(PDO::FETCH_OBJ)) {	
		  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
		  if  ($selection== $resultsql->$champssqlretourne and $selection!='' ){
			 $result.= " SELECTED ";$selected=1;}
			 $result.= ">";
		$result.= $resultsql->$champssqlaffiche;
		if ($champs2sqlaffiche!=""){
		$result.=" ". $resultsql->$champs2sqlaffiche;
		}
		$result.="</option> " ;
		}
	}
else
	{	
		$resultat = mysql_query($query,$connexion );
		while ($resultsql=mysql_fetch_object($resultat)) {	
			  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
			  if  ($selection== $resultsql->$champssqlretourne and $selection!='' ){
				 $result.= " SELECTED ";$selected=1;}
				 $result.= ">";
			$result.= $resultsql->$champssqlaffiche;
			if ($champs2sqlaffiche!=""){
			$result.=" ". $resultsql->$champs2sqlaffiche;
			}
			$result.="</option> " ;
		}
	}	

	// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if(!$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}		
  $result.="</select></td>\n " ;
  return ($result);
}

//2019
function affichemenusqlplustous($titre,$champ,$champssqlretourne,$query,$champssqlaffiche,$selection='',$sqlconnect="",$champs2sqlaffiche="",$valeursup="tous",$js='',$id='',$noerr='')
{
		// correction 2019 initialisation des paramètres avant la derniere position
	if ($valeursup=='')$valeursup='tous';
	
	// version 2019 marc
	//permet de générer un select avec une ligne supplémentaire à choisir avec le param $valeursup (ici j'affiche tous,value tous ) en plus des valeurs retournées par la requête sql ( ici un select distinct )
//idem à affichemenusql :  recupere  la connexiion et possibilite d'afficher 2 champs cote à cote avec un espace comme séparateur + une valeur spéciale (tous)

// version 2020
// param supplementaire noerr pour ne pas afficher le texte erreur
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
$connexion =$sqlconnect;
	$selected=0;
$result= "<td>$titre<select name='$champ' $js id='$id'>";
	$result.= "<option value=\"".$valeursup."\" ";
	if ($selection==$valeursup){$result.=" SELECTED ";
	$selected=1;
	}
	$result.=" >".echosur($valeursup)."</option>";
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
	$resultat = $connexion->query($query);		
	while ($resultsql = $resultat->fetch(PDO::FETCH_OBJ)) {	
		  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
		if (stripos($selection,"&#039;")!== false)
		{		 
		 if  (($resultsql->$champssqlretourne == str_replace("&#039;","'",$selection) or $resultsql->$champssqlretourne == $selection ) and $selection!='' )
			{
			 $result.= " SELECTED ";$selected=1;
			 }
		}
		else
		{
			 if  ($resultsql->$champssqlretourne == $selection and $selection!='' )
			 {
			 $result.= " SELECTED ";$selected=1;
			 }
		}
			 $result.= ">";
		$result.= $resultsql->$champssqlaffiche;
		if ($champs2sqlaffiche!=""){
		$result.=" ". $resultsql->$champs2sqlaffiche;
		}
		$result.="</option> " ;
		}
	}
else
	{	
		$resultat = mysql_query($query,$connexion );
		while ($resultsql=mysql_fetch_object($resultat)) {	
			  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
		if (stripos($selection,"&#039;")!== false)
		{		 
		 if  (($resultsql->$champssqlretourne == str_replace("&#039;","'",$selection) or $resultsql->$champssqlretourne == $selection ) and $selection!='' )
			{
			 $result.= " SELECTED ";$selected=1;
			 }
		}
		else
		{
			 if  ($resultsql->$champssqlretourne == $selection and $selection!='' )
			 {
			 $result.= " SELECTED ";$selected=1;
			 }
		}
				 $result.= ">";
			$result.= $resultsql->$champssqlaffiche;
			if ($champs2sqlaffiche!=""){
			$result.=" ". $resultsql->$champs2sqlaffiche;
			}
			$result.="</option> " ;
		}
	}	

	// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur ou la sélection et on renvoie la sélection transmise
	if( !$selected)
	{
		if ($noerr !='')
		$result.="<option value='".$selection."' SELECTED> ".$selection." </option>";
		else
		$result.="<option value='".$selection."' SELECTED> ereur: ".$selection." inexistant </option>";

	}		
  $result.="</select></td>\n " ;
  return ($result);
}


function affichemenusqlplusplus($titre,$champ,$champssqlretourne,$query,$champssqlaffiche,$query2,$sqlconnect="",$js='',$id='')
{
//idem à affichemenusql plus mais permet d'afficher avec une 2eme requete un autre champs que celui envoyé
// attention ne fonctionne qu'avec une connexion classique (mysqli )
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
$connexion =$sqlconnect;
	$selected=0;
//on fait une premiere requete pour recuperer la valeur affichable
//echo $query2;
$resultat = mysql_query($query2,$connexion );

$selectionaffiche='';
if (mysql_num_rows($resultat)==1){
$resultsql=mysql_fetch_object($resultat);
$selectionaffiche=$resultsql->$champssqlaffiche;}

// et une deuxieme pour creer le select
$resultat = mysql_query($query,$connexion );
$result= "<td>$titre<select name='$champ' $js id='$id'>";
 while ($resultsql=mysql_fetch_object($resultat)) {
      $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
	  if  ($selectionaffiche== $resultsql->$champssqlaffiche ){
         $result.= " SELECTED ";$selected=1;}
         $result.= ">";
    $result.= $resultsql->$champssqlaffiche;
    $result.="</option> " ;
    }
/* 		// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if($selection!='' and !$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}	*/
  $result.="</select></td>\n " ; 
	
  return ($result);
}

  // laissé à des fins de compatibilité utiliser maintenant la fonction générique plus argument submit=1
function affichemenusqlplussubmit($titre,$champ,$champssqlretourne,$query,$champssqlaffiche,$selection='',$sqlconnect="")
{
//idem à affichemenusqlplus mais autovalidation
$connexion =$sqlconnect;
	$selected=0;
$result= "<td>$titre<br><select name='$champ' onchange='submit()'>";
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
		$resultat = $connexion->query($query);		
		while ($resultsql = $resultat->fetch(PDO::FETCH_OBJ)) {	
		  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
		  if  ($selection== $resultsql->$champssqlretourne ){
			 $result.= " SELECTED ";$selected=1;}
			 $result.= ">";
		$result.= $resultsql->$champssqlaffiche;
		$result.="</option> " ;
		}
	}
else
	{	
		$resultat = mysql_query($query,$connexion );
		while ($resultsql=mysql_fetch_object($resultat)) {
		  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
		  if  ($selection== $resultsql->$champssqlretourne ){
			 $result.= " SELECTED ";$selected=1;}
			 $result.= ">";
		$result.= $resultsql->$champssqlaffiche;
		$result.="</option> " ;
		}
	}	
		// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if($selection!='' and !$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}	
  $result.="</select></td> \n" ;
  return ($result);
}
  // laissé à des fins de compatibilité utiliser maintenant la fonction générique plus argument submit=1
function affichemenusqlplusncsubmit($titre,$champ,$champssqlretourne,$query,$champssqlaffiche,$selection='',$sqlconnect="",$champs2sqlaffiche="")
{
//idem à affichemenusqlplus mais autovalidation
$connexion =$sqlconnect;
	$selected=0;
$result= "<td>$titre<br><select name='$champ' onchange='submit()'>";
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
	$resultat = $connexion->query($query);		
	while ($resultsql = $resultat->fetch(PDO::FETCH_OBJ)) {	
		  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
		  if  ($selection== $resultsql->$champssqlretourne and $selection!='' ){
			 $result.= " SELECTED ";$selected=1;}
			 $result.= ">";
		$result.= $resultsql->$champssqlaffiche;
		if ($champs2sqlaffiche!=""){
		$result.=" ". $resultsql->$champs2sqlaffiche;
		}
		$result.="</option> " ;
		}
	}
else
	{	
		$resultat = mysql_query($query,$connexion );
		while ($resultsql=mysql_fetch_object($resultat)) {
			  $result.=  "  <option  value=\"".echosur($resultsql->$champssqlretourne)."\"";
			  if  ($selection== $resultsql->$champssqlretourne and $selection!='' ){
				 $result.= " SELECTED ";$selected=1;}
				 $result.= ">";
			$result.= $resultsql->$champssqlaffiche;
			if ($champs2sqlaffiche!=""){
			$result.=" ". $resultsql->$champs2sqlaffiche;
			}
			$result.="</option> " ;
			}
	}	
	$result.= "<option value=\"\" ";
	if ($selection==''){$result.=" SELECTED ";$selected=1;}
	$result.=" >NC</option>";
		// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if( !$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}	
  $result.="</select></td>\n " ;
  return ($result);
}

function afficheonlychampsql($titre,$champ,$query,$champssqlaffiche,$sqlconnect="",$taille=20,$coteacote='',$js='',$id='')
{
		// correction 2019 initialisation des paramètres avant la derniere position
	if ($taille=='')$taille=20;	
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
//echo $query;
$connexion =$sqlconnect;
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
	{
	$resultat = $connexion->query($query);	
	  if ($resultat->rowCount()==1){
		  $resultsql = $resultat->fetch(PDO::FETCH_OBJ);
		 $temp=$resultsql->$champssqlaffiche;
		}
	 else{
			$temp="NC";
		}
	}
else
	{
	$resultat = mysql_query($query,$connexion );		
	  if (mysql_num_rows($resultat)==1){
		  $resultsql=mysql_fetch_object($resultat) ; 
		 $temp=$resultsql->$champssqlaffiche;
		}
	 else
		 {
		 $temp="NC";
		}		
	}
    $ro="readonly";

	if($coteacote  )
    {  $result= "<td>$titre</td><td><input type='text' $ro  size='$taille' name='$champ' id='$id' $js value=\"".echosur($temp)."\"></td> \n  ";}
	else	
    {  $result= "<td>$titre<input type='text' $ro  size='$taille' name='$champ' id='$id' $js value=\"".echosur($temp)."\"></td> \n  ";}

  return ($result);
}

function afficheonlysqlplus($titre,$champ,$champssqlretourne,$query,$champssqlaffiche,$selection='',$sqlconnect="",$champs2sqlaffiche="",$js='',$id='',$taille=20,$coteacote='')
{
			// correction 2019 initialisation des paramètres avant la derniere position
	if ($taille=='')$taille=20;
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
//idem à affichemenusqlplus mais crée un champs texte au lieu d'un select
$connexion =$sqlconnect;
  $selected=0;
  $temp='';
  $temp2='';
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
  {
  $resultat = $connexion->query($query);    
  while ($resultsql = $resultat->fetch(PDO::FETCH_OBJ)) { 
      if  ($selection== $resultsql->$champssqlretourne ){
    $temp= $resultsql->$champssqlaffiche;
    $temp2= $resultsql->$champssqlretourne;		
    $selected=1;
    if ($champs2sqlaffiche!=""){
    $temp.=" ". $resultsql->$champs2sqlaffiche;
    }
    }
    }
  }
else
  { 
    $resultat = mysql_query($query,$connexion );
    while ($resultsql=mysql_fetch_object($resultat)) {
      if  ($selection== $resultsql->$champssqlretourne ){
    $temp= $resultsql->$champssqlaffiche;
    $temp2= $resultsql->$champssqlretourne;		
    $selected=1;
    if ($champs2sqlaffiche!=""){
    $temp.=" ". $resultsql->$champs2sqlaffiche;
    }
    }
      }
  }
    // si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
   if( !$selected  and  $selection !='')
{$temp ="  erreur ! ";$temp2 =$selection;} 
  if($coteacote  )
    {  $result= "<td>$titre</td><td><input type='text' readonly  size='$taille' name='$champ' id='$id' $js value=\"".echosur($temp)."\"></td> \n  ";}
  else  
    {  $result= "<td>$titre<input type='text' readonly   size='$taille' name='aff$champ' id='aff$id' $js value=\"".echosur($temp)."\"></td> \n  ";}
// il faut renvoyer la valeur prévue comme si c'était un affichemenu on ajoute un champs hidden avec le même nom
		$result.= "<input type='hidden' name='$champ' id='$id'  value=\"".echosur($temp2)."\">\n  ";
 
 return ($result);
}

//Renvoi seulement une STRING
function afficheonlysqlplusonlystring($titre,$champ,$champssqlretourne,$query,$champssqlaffiche,$selection='',$sqlconnect="",$champs2sqlaffiche="",$js='',$id='',$taille=20,$coteacote='')
{
		// correction 2019 initialisation des paramètres avant la derniere position
	if ($taille=='')$taille=20;
	//A REVOIR
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
//idem à affichemenusqlplus mais crée un champs texte au lieu d'un select
$connexion =$sqlconnect;
  $selected=0;
  $temp='';
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
  {
  $resultat = $connexion->query($query);
  while ($resultsql = $resultat->fetch(PDO::FETCH_OBJ)) {
      if  ($selection== $resultsql->$champssqlretourne ){
    $temp= $resultsql->$champssqlaffiche;
    $selected=1;
    if ($champs2sqlaffiche!=""){
    $temp.=" ". $resultsql->$champs2sqlaffiche;
    }
    }
    }
  }
else
  {
    $resultat = mysql_query($query,$connexion );
    while ($resultsql=mysql_fetch_object($resultat)) {
      if  ($selection== $resultsql->$champssqlretourne ){
    $temp= $resultsql->$champssqlaffiche;
    $selected=1;
    if ($champs2sqlaffiche!=""){
    $temp.=" ". $resultsql->$champs2sqlaffiche;
    }
    }
      }
  }
    // si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
   if( !$selected  and  $selection !='')
{$temp ="  erreur ! ";}

  return (echosur($temp));
}

function afficheonlysqlplusnc($titre,$champ,$champssqlretourne,$query,$champssqlaffiche,$selection='',$sqlconnect="",$champs2sqlaffiche="",$valeursivide="NC",$js='',$id='',$taille=20,$coteacote='')
{
		// correction 2019 initialisation des paramètres avant la derniere position
	if ($valeursivide=='')$valeursivide='NC';	
	if ($taille=='')$taille=20;		
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
//idem à affichemenusqlplus mais crée un champs texte au lieu d'un select
$connexion =$sqlconnect;
  $selected=0;
  if ($selection==''){
	  $selected=1;
	  $temp =$valeursivide;
	  $temp2='';
	  }	  
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
  {
  $resultat = $connexion->query($query);    
  while ($resultsql = $resultat->fetch(PDO::FETCH_OBJ)) { 
      if  ($selection== $resultsql->$champssqlretourne ){
    $temp= $resultsql->$champssqlaffiche;
    $temp2= $resultsql->$champssqlretourne;	
    $selected=1;
    if ($champs2sqlaffiche!=""){
    $temp.=" ". $resultsql->$champs2sqlaffiche;
    }
    }
    }
  }
else
  { 
    $resultat = mysql_query($query,$connexion );
    while ($resultsql=mysql_fetch_object($resultat)) {
      if  ($selection== $resultsql->$champssqlretourne ){
    $temp= $resultsql->$champssqlaffiche;
    $temp2= $resultsql->$champssqlretourne;		
    $selected=1;
    if ($champs2sqlaffiche!=""){
    $temp.=" ". $resultsql->$champs2sqlaffiche;
    }
    }
      }
  }
    // si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
   if( !$selected  and  $selection !='')
{$temp ="  erreur ! ";$temp2 =$selection;} 
  if($coteacote  )
    {  $result= "<td>$titre</td><td><input type='text' readonly  size='$taille' name='$champ' id='$id' $js value=\"".echosur($temp)."\"></td> \n  ";}
  else  
    {  $result= "<td>$titre<input type='text' readonly   size='$taille' name='aff$champ' id='aff$id' $js value=\"".echosur($temp)."\"></td> \n  ";
	}
// il faut renvoyer la valeur prévue comme si c'était un affichemenu on ajoute un champs hidden avec le même nom
		$result.= "<input type='hidden' name='$champ' id='$id'  value=\"".echosur($temp2)."\">\n  ";
  return ($result);
}

//Renvoi seulement une STRING
function afficheonlysqlplusnconlystring($titre,$champ,$champssqlretourne,$query,$champssqlaffiche,$selection='',$sqlconnect="",$champs2sqlaffiche="",$valeursivide="NC",$js='',$id='',$taille=20,$coteacote='')
{ 
		// correction 2019 initialisation des paramètres avant la derniere position
	if ($valeursivide=='')$valeursivide='NC';
	if ($taille=='')$taille=20;	
//A REVOIR
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
//idem à affichemenusqlplus mais crée un champs texte au lieu d'un select
$connexion =$sqlconnect;
  $selected=0;
  if ($selection==''){
	  $selected=1;
	  $temp =$valeursivide;}
	// si on a a pas passé la variable de connexion , on récupère la connexion créée précédemment 
	//on présume qu'elle s'appelle $connexion
	if ($connexion=='')
	{
	global $connexion;
	}
//on teste si la connexion est PDO ou mysqli
if(!is_a($connexion,'mysqli'))
  {
  $resultat = $connexion->query($query);
  while ($resultsql = $resultat->fetch(PDO::FETCH_OBJ)) {
      if  ($selection== $resultsql->$champssqlretourne ){
    $temp= $resultsql->$champssqlaffiche;
    $selected=1;
    if ($champs2sqlaffiche!=""){
    $temp.=" ". $resultsql->$champs2sqlaffiche;
    }
    }
    }
  }
else
  {
    $resultat = mysql_query($query,$connexion );
    while ($resultsql=mysql_fetch_object($resultat)) {
      if  ($selection== $resultsql->$champssqlretourne ){
    $temp= $resultsql->$champssqlaffiche;
    $selected=1;
    if ($champs2sqlaffiche!=""){
    $temp.=" ". $resultsql->$champs2sqlaffiche;
    }
    }
      }
  }
    // si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
   if( !$selected  and  $selection !='')
{$temp ="  erreur ! ";}
 return (echosur($temp));
}


function afficheradio ($titre,$champ,$liste,$selection,$defaut,$ro='',$js='',$id='')
{
if($id=='')$id=$champ;
if($ro)$ro="readonly";
if($titre!='')$titre.="<br>";		
         if ($selection=='')$selection=$defaut;
          $result= "<td>$titre";
         for($i=0;$i<sizeof($liste);$i++) {
         $result.="<INPUT TYPE=radio  NAME=$champ $js id='$id' ".$ro." VALUE=\"".echosur(current($liste))."\"";
         if  ($selection== current($liste) ){
         $result.= " CHECKED ";}
          $result.= "> ";
           $result.= current($liste);
           $result.= "<br> ";
           next($liste);
          }
          return ($result);
  }
  
function afficheradiosubmit ($titre,$champ,$liste,$selection,$defaut,$js='',$id='')
{
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";		
         if ($selection=='')$selection=$defaut;
          $result= "<td>$titre";
         for($i=0;$i<sizeof($liste);$i++) {
         $result.="<INPUT TYPE=radio  NAME=$champ $js id='$id' VALUE=\"".echosur(current($liste))."\" onchange='submit()'";
         if  ($selection== current($liste) ){
         $result.= " CHECKED ";}
          $result.= "> ";
           $result.= current($liste);
           $result.= "<br> ";
           next($liste);
          }
          return ($result);
  }  

  function affichemenuncsubmit ($titre,$champ,$liste,$selection='',$valeursivide="NC",$js='',$id='')
 {
		// correction 2019 initialisation des paramètres avant la derniere position
	if ($valeursivide=='')$valeursivide='NC';
	 
if($id=='')$id=$champ;
if($titre!='')$titre.="<br>";
	 	$selected=0;
	$result= "<td>$titre<select name='$champ' id='$id' onchange='submit();' $js>";
       for($i=0;$i<sizeof($liste);$i++) {
    //les  2 lignes ci dessous sont une autre solution pour un recuperer les codes correspondant aux noms
      //echo "  <option  value=\"".current($etudiants_code)."\">";
    $result.="<option	value=\"".echosur(current($liste))."\" ";
      if  ($selection== current($liste) ){
         $result.= " SELECTED ";$selected=1;}
         $result.= ">";
    $result.= current($liste);
     next($liste);
    $result.="</option> " ;
    }
			$result.= "<option value=\"\" ";
	if ($selection==''){$result.=" SELECTED ";}
	$result.=" >$valeursivide</option>";
		// si il y avait une selection et qu'on ne l'a pas trouvée on affiche erreur et on renvoie la sélection transmise
	if($selection!='' and !$selected)
	{$result.="<option value='".$selection."' SELECTED> erreur ! </option>";}
    $result.="</select></td>";
    return ($result);
}
//conversion des dates depuis sqlserver ET mysql
  // retourene jj/mm/aaaa
   function mysql_DateTime($d) { 
   if ($d !=''){
	   // il faut vérifier si la date est sur 4 caractères , si elle est sur 2 on rajoute '20' devant
	if ( stripos($d, '-')== 2) $d='20'.$d;			   	   
  $date = substr($d,8,2)."/";        // jour
  $date = $date.substr($d,5,2)."/";  // mois
  $date = $date.substr($d,0,4); // année 
  //$date = $date.substr($d,11,5);     // heures et minutes
  if ($date=="01/01/1900"){
     $date='NC';}
   }  else {$date='';}
  return $date;
  }
  // retourene jj/mm/aa
  function mysql_DateTimeaa($d) { 
   if ($d !=''){
	   // il faut vérifier si la date est sur 4 caractères , si elle est sur 2 on rajoute '20' devant
	if ( stripos($d, '-')== 2) $d='20'.$d;	
  $date = substr($d,8,2)."/";        // jour
  $date = $date.substr($d,5,2)."/";  // mois
  $date = $date.substr($d,2,2); // année 
  //$date = $date.substr($d,11,5);     // heures et minutes
  if ($date=="01/01/00"){
     $date='NC';}
   }  else {$date='';}
  return $date;
  }

   function mysql_Time($d) {
   if ($d !=''){
	   // il faut vérifier si la date est sur 4 caractères , si elle est sur 2 on rajoute '20' devant
	if ( stripos($d, '-')== 2) $d='20'.$d;	
  $date = substr($d,8,2)."/";        // jour
  $date .= substr($d,5,2)."/";  // mois
  $date .= substr($d,0,4). " "; // année
  $date .= substr($d,11,5);     // heures et minutes
  if ($date=="01/01/1900 00:00"){
     $date='NC';}
     } else {$date='';}
  return $date;
  }
  
   function mysql_Time_sec($d) {
   if ($d !=''){
	   	   // il faut vérifier si la date est sur 4 caractères , si elle est sur 2 on rajoute '20' devant
	if ( stripos($d, '-')== 2) $d='20'.$d;	
  $date = substr($d,8,2)."/";        // jour
  $date .= substr($d,5,2)."/";  // mois
  $date .= substr($d,0,4). " "; // année
  $date .= substr($d,11,8);     // heures et minutes et secondes
  if ($date=="01/01/1900 00:00"){
     $date='NC';}
     } else {$date='';}
  return $date;
  }
  
  // pour les type heure de mysql (hh:mm:ss) -> on affiche hh:mm
    function mysql_Type_Time($time) {
   if ($time !=''){
  $time = substr($time,0,5);        
     } else {}
  return $time;
  } 
 
  //conversion des heures vers mysql type time
   function versmysql_Type_Time($d) {
if  ($d =='' )$d='NC';
   if ($d !='NC')
		   {
		   			   // on vérifie le format  hh:mm
			if ( stripos($d, ':')== 1 or stripos($d, 'h')== 1  or stripos($d, 'H')== 1) $d='0'.$d;		
		   if(  preg_match('#[0-2][0-9][:Hh][0-5][0-9]#', $d) and  substr($d,0,2)<24 and  substr($d,3,2)<60)
				   {	
				$d=str_replace("h",":",	$d);		
				$d=str_replace("H",":",	$d);	   
				  $date = $d;        
				  }
				  else
				  {//le format est incorrect on renvoie une valeur  qui sera refusée par mysql
				  $date='erreur de format heure';
				  }
		   }  else 
		   {
		   $date='';
		   }
  return $date;
  } 
  
  //conversion des dates vers mysql type date
   function versmysql_Date($d) {
if  ($d =='' )$d='NC';
   if ($d !='NC')
		   {
		   			   // on vérifie le format  jj/mm/aaaa ou jj/mm/aaaa 
	//	   if ((  preg_match( '`^\d{1,2}/\d{1,2}/\d{4}$`' , $d ) or preg_match( '`^\d{1,2}/\d{1,2}/\d{2}$`' , $d )) and  substr($d,0,2)<32 and  substr($d,3,2)<13 )
		   if ((  preg_match( '`^\d{2}/\d{2}/\d{4}$`' , $d ) or preg_match( '`^\d{1,2}/\d{1,2}/\d{2}$`' , $d )) and  substr($d,0,2)<32 and  substr($d,3,2)<13 )			   
		   //if(1)
				   {
				  $date = substr($d,6,4)."-";        // annee
				  $date = $date.substr($d,3,2)."-";  // mois
				  $date = $date.substr($d,0,2); // jour
				  //$date = $date.substr($d,11,5);     // heures et minutes
				  }
				  else
				  {//le format est incorrect on renvoie une valeur  qui sera refusée par mysql
				  $date='erreur de format de date';
				  }
		   }  else 
		   {
		   $date='1900-01-01';
		   }
  return $date;
  }

  //quand on ne veut pas l'année
  function versmysql_Date_jm($d) {
if  (strlen($d )<2 )$d='NC';
   if ($d !='NC'){
   $d= substr($d,0,5)."-1901";
  $date = substr($d,6,4)."-";        // annee
  $date = $date.substr($d,3,2)."-";  // mois
  $date = $date.substr($d,0,2). " "; // jour
  //$date = $date.substr($d,11,5);     // heures et minutes
  
   }  else {
   $date='1900-01-01';}
  return $date;
  }
      //conversion des dates vers mysql type datetime
   function versmysql_Datetime($d) 
   {
if  (strlen($d )<2 )$d='NC';
//teste peut êtreinutile ?
   if ($d !='NC' )
		{  
			   // on vérifie le format  jj/mm/aaaa ou jj/mm/aa
	//	   if ((  preg_match( '`^\d{1,2}/\d{1,2}/\d{4}$`' , $d ) or preg_match( '`^\d{1,2}/\d{1,2}/\d{2}$`' , $d )) and  substr($d,0,2)<32 and  substr($d,3,2)<13 )
		   if ((  preg_match( '`^\d{2}/\d{2}/\d{4}$`' , $d ) or preg_match( '`^\d{2}/\d{2}/\d{2}$`' , $d )) and  substr($d,0,2)<32 and  substr($d,3,2)<13 )	
		   //if(1)
				   {
				  $date = substr($d,6,4)."-";        // annee
				  $date = $date.substr($d,3,2)."-";  // mois
				  $date = $date.substr($d,0,2). " "; // jour
				  //$date = $date.substr($d,11,5);     // heures et minutes
				  $date = $date.'00:00:00';
				  }
				  else
				  {//le format est incorrect on renvoie une valeur  qui sera refusée par mysql
				  $date='erreur de format de date';
				  }
	   }  
	   else 
	   {
	   $date='1900-01-01 00:00:00';
	   }
	  return $date;
	}
	

      //conversion des dates vers mysql type datetime

function versmysql_Datetime_fix($d) 

{

    if  (strlen($d ) <2 )$d='NC';

    //teste peut êtreinutile ?

    if ($d !='NC')

    {  

        // on vérifie le format  jj/mm/aaaa ou jj/mm/aa

        if ( preg_match( '`^\d{2}/\d{2}/\d{4}$`' , $d ) or preg_match( '`^\d{2}/\d{2}/\d{2}$`' , $d ))

        {

            $date = substr($d,6,4)."-";        // annee

            $date = $date.substr($d,3,2)."-";  // mois

            $date = $date.substr($d,0,2). " "; // jour

            //$date = $date.substr($d,11,5);     // heures et minutes

            $date = $date.'00:00:00';

        }

        else if ( preg_match( '`^\d{1}/\d{2}/\d{4}$`' , $d ) or preg_match( '`^\d{1}/\d{1}/\d{2}$`' , $d ))

        {

            $date = substr($d,5,4)."-";        // annee

            $date = $date.substr($d,2,2)."-";  // mois

            $date = "0" . $date.substr($d,0,1). " "; // jour

            //$date = $date.substr($d,11,5);     // heures et minutes

            $date = $date.'00:00:00';

        }

        else if ( preg_match( '`^\d{2}/\d{1}/\d{4}$`' , $d ) or preg_match( '`^\d{2}/\d{2}/\d{1}$`' , $d ))

        {

            $date = substr($d,5,4)."-";        // annee

            $date = "0" . $date.substr($d,3,1)."-";  // mois

            $date = $date.substr($d,0,2). " "; // jour

            //$date = $date.substr($d,11,5);     // heures et minutes

            $date = $date.'00:00:00';

        }

        else if ( preg_match( '`^\d{1}/\d{1}/\d{4}$`' , $d ) or preg_match( '`^\d{1}/\d{1}/\d{1}$`' , $d ))

        {

            $date = substr($d,4,4)."-";        // annee

            $date = "0" . $date.substr($d,2,1)."-";  // mois

            $date = "0" . $date.substr($d,0,1). " "; // jour

            //$date = $date.substr($d,11,5);     // heures et minutes

            $date = $date.'00:00:00';

        }

        else

        {//le format est incorrect on renvoie une valeur  qui sera refusée par mysql

            $date='erreur de format de date';

        }

    }

    else 

    {

      $date='1900-01-01 00:00:00';

    }

    return $date;

}
	
		
  //conversion des dates sans annee depuis  mysql
   function mysql_DateTime_jm($d) { 
   if ($d !=''){
  $date = substr($d,8,2)."/";        // jour
  $date = $date.substr($d,5,2);  // mois
  //$date = $date.substr($d,0,4). " "; // année 
  //$date = $date.substr($d,11,5);     // heures et minutes
  if ($d=='1900-01-01'){
     $date='NC';}
   }  else {$date='';}
  return $date;
  }  
    
  function versmysql_Datetimeexacte($d) {

if  (strlen($d )<2 )$d='NC';
  
   if ($d !='NC'){
  $date = substr($d,6,4)."-";        // annee
  $date = $date.substr($d,3,2)."-";  // mois
  $date = $date.substr($d,0,2). " "; // jour
  $date = $date.substr($d,11,5);     // heures et minutes
   }  else {
   $date='1900-01-01 00:00:00';}
  return $date;
  }
  
function envoimailtest($destinataire, $objet, $messagem,$sigiadminmail='gi-dev@grenoble-inp.fr',$discret='') {
	// correction 2019 initialisation des paramètres avant la derniere position

	if ($sigiadminmail=='')$sigiadminmail='gi-dev@grenoble-inp.fr';
	// on enleve les accents ds l'objet
	$objet = stripAccents($objet);
	// on convertit les entités HTML stockées en leurs caractères correspondant.
	$messagem=html_entity_decode($messagem,ENT_QUOTES,'ISO-8859-1');	
	// on vérifie le destinataire
	if ($destinataire != '') {
		// On envoi l'’email à $sigiadminmail
		//if ( mail($destinataire, $objet, $messagem) ) echo "Envoi du mail pour ".$destinataire." réussi.<br>";
		$headers = 'From: begi-test<test@grenoble-inp.fr>' . "\n";
		//$headers .='Reply-To: adresse_de_reponse@fai.fr'."\n";
		$headers .= 'Content-Type: text/plain; charset=iso-8859-1' . "\n";
		$headers .=  "Message-ID: ".time().rand()."@grenoble-inp.fr". "\n";		
		$headers .= 'Content-Transfer-Encoding: 8bit';
		if (mail($sigiadminmail, $objet,"destinataires:" . $destinataire . " \n " . $messagem,$headers))
		{	
			if ($discret =='')
			echo "Envoi du mail pour " . $destinataire. " réussi [DEBUG en fait c'est l'adresse $sigiadminmail qui est utilisée] .<br>";
		}
		else
		{
			if ($discret =='')
			echo "Echec de l’'envoi du mail.<br>";
			
		}
	} else
	{
		echo "Echec de l'’envoi du mail adresse destinataire vide.<br>";
	}
}

function envoimail($destinataire, $objet, $messagem, $discret='') {
	// on enleve les accents ds l'objet
	$objet = stripAccents($objet);
	// on convertit les entités HTML stockées en leurs caractères correspondant.
	$messagem=html_entity_decode($messagem,ENT_QUOTES,'ISO-8859-1');	
	// on vérifie le destinataire
	if ($destinataire != '') {
		// On envoi l’email au bon destinataire
		$headers = 'From: gi<noreply@grenoble-inp.fr>' . "\n";
		//$headers .='Reply-To: adresse_de_reponse@fai.fr'."\n";
		$headers .= 'Content-Type: text/plain; charset="iso-8859-1"' . "\n";
		$headers .=  "Message-ID: ".time().rand()."@grenoble-inp.fr". "\n";		
		$headers .= 'Content-Transfer-Encoding: 8bit';
		if (mail($destinataire, $objet, $messagem, $headers))
		{
			if ($discret =='')
			echo "Envoi du mail pour " . $destinataire . " réussi.<br>";
		}
		//if ( mail('gestages.test@grenoble-inp.fr', $objet,"destinataires:".$destinataire." \n ". $messagem) ) echo "Envoi du mail pour ".$destinataire." réussi [DEBUG en fait c'est l'adresse gestages.test qui est utilisée] .<br>";
		else
			echo "Echec de l’'envoi du mail.<br>";
	} else
		echo "Echec de l'’envoi du mail adresse destinataire vide.<br>";
}

function envoipasmail($destinataire, $objet, $messagem, $discret='') {
	// on enleve les accents ds l'objet
	$objet = stripAccents($objet);
	// on vérifie le destinataire
	if ($destinataire != '') {
		// On envoi l’email au bon destinataire
		$headers = 'From: gi<noreply@grenoble-inp.fr>' . "\n";
		//$headers .='Reply-To: adresse_de_reponse@fai.fr'."\n";
		$headers .= 'Content-Type: text/plain; charset="iso-8859-1"' . "\n";
		$headers .=  "Message-ID: ".time().rand()."@grenoble-inp.fr". "\n";		
		$headers .= 'Content-Transfer-Encoding: 8bit';

			echo "TEST on n'Envoi pas de  mail pour " . $destinataire . " .<br>";
		
	} else
		echo "Echec de l'’envoi du mail adresse destinataire vide.<br>";
}

  function diffdate($date1,$date2=''){
  if ($date1=='' ){
  return '0';}
  else{
  // -- DATE 1 --
list($jour,$mois,$annee) = explode("/",$date1);
// on transforme la date en timestamp
$timestamp1 = mktime(0,0,0,$mois,$jour,rtrim($annee));
  // -- DATE 2--
  //si date2 n'est pas presente on calcule la difference avec aujourdhui
if ($date2==''){
$timestamp2 = time();  }else{
  
list($jour,$mois,$annee) = explode("/",$date2);
// on transforme la date en timestamp
$timestamp2 = mktime(0,0,0,$mois,$jour,rtrim($annee));
}
// -- DATE ACTUELLE --
// directement en timestamp.

// -- CALCUL --
// on calcule le nombre de secondes d'écart entre les deux dates
$ecart_secondes =$timestamp2- $timestamp1;
// puis on tranforme en jours (arrondi inférieur)
//modif cause erreur lundi ade ?
$ecart_jours = floor($ecart_secondes / (60*60*24))+1;
$ecart_semaines= floor($ecart_jours / 7);
// enfin on renvoie  le résultat

return $ecart_semaines ; 
  
  }  
  }
  
   function diffdatejours($date1,$date2=''){
  if ($date1=='' or $date1=='NC' ){
  return '0';}
  else{
  // -- DATE 1 --
list($jour,$mois,$annee) = explode("/",$date1);
// on transforme la date en timestamp
$timestamp1 = mktime(0,0,0,$mois,$jour,rtrim($annee));
  // -- DATE 2--
  //si date2 n'est pas presente on calcule la difference avec aujourdhui
if ($date2==''){
$timestamp2 = time();  }else{
  
list($jour,$mois,$annee) = explode("/",$date2);
// on transforme la date en timestamp
$timestamp2 = mktime(0,0,0,$mois,$jour,rtrim($annee));
}
// -- DATE ACTUELLE --
// directement en timestamp.

// -- CALCUL --
// on calcule le nombre de secondes d'écart entre les deux dates
$ecart_secondes =$timestamp2- $timestamp1;
// puis on tranforme en jours (arrondi inférieur)
$ecart_jours = floor($ecart_secondes / (60*60*24));
$ecart_semaines= floor($ecart_jours / 7);
// enfin on renvoie  le résultat

return $ecart_jours ; 
  
  }  
  }
  
 function diffdatesecondes($date1,$date2=''){
  if ($date1=='' or $date1=='NC' ){
  return '0';}
  else{
  // -- DATE 1 --
list($jour,$mois,$annee,$heure,$minute) = explode("/",$date1);
// on transforme la date en timestamp
$timestamp1 = mktime($heure,$minute,0,$mois,$jour,rtrim($annee));
  // -- DATE 2--
  //si date2 n'est pas presente on calcule la difference avec aujourdhui
if ($date2==''){
$timestamp2 = time();  }else{
  
list($jour,$mois,$annee,$heure,$minute) = explode("/",$date2);
// on transforme la date en timestamp
$timestamp2 = mktime($heure,$minute,0,$mois,$jour,rtrim($annee));
}
// -- DATE ACTUELLE --
// directement en timestamp.

// -- CALCUL --
// on calcule le nombre de secondes d'écart entre les deux dates
$ecart_secondes =$timestamp2- $timestamp1;
// enfin on renvoie  le résultat
return $ecart_secondes ; 
  }  
  }  
  
function tronquerPhrase($texte,$nbCar=false){
  if($nbCar){
    //$nbCar-=3; // A cause des 3 points
  if (strlen($texte)>$nbCar){
      $texte = substr($texte,0,$nbCar);
      //$pos = strrpos($texte, " ");
      //$texte = substr($texte, 0, $pos);
      //$texte.="...";
    }
  }
  return $texte;
}

function afficheresultatsql($idsql,$connexion){
 if ($idsql){
      $message = "<center>Votre modification a été effectuée !</center> ";}
   else {
    $message = "<center><font color='red'>Il y a eu un problème dans la transaction avec mysql </b> <br>";
    $message.= "<i>l'erreur mysql est :</i> ".mysql_error($connexion);
  $message.=  "<br><b>Rien n'a été modifié : Recommencez </b></font></center>";
    }
  return $message;
}





//pour les entetes de tableau cliquables
function afficheentete($libelle='-',$varnom,$orderby,$invorderby,$filtre,$URL){
			// correction 2019 initialisation des paramètres avant la derniere position
	if ($libelle=='')$libelle='-';
if   ($orderby==$varnom && $invorderby== 1)
{$message="<th><a href=".$URL."?env_orderby=".urlencode($varnom)."&".$filtre.">".$libelle." </a>&#9660</th> ";}
elseif   ($orderby==$varnom && $invorderby<> 1)
{$message="<th><a href=".$URL."?env_orderby=".urlencode($varnom)."&env_inverse=1&".$filtre.">".$libelle." </a>&#9650;</th> ";}

else
{$message= "<th><a href=".$URL."?env_orderby=".urlencode($varnom)."&".$filtre.">".$libelle."</a></th> ";}
return $message;
}

//pour les entetes de tableau cliquables à 2 parametres
function afficheenteteplus($libelle='-',$varnom,$orderby,$invorderby,$filtre,$URL){
			// correction 2019 initialisation des paramètres avant la derniere position
	if ($libelle=='')$libelle='-';	
if (strripos($orderby,',') or $orderby=='' ) 
{
	if (in_array($varnom,explode(',',$orderby)))
	{
			$message="<th><a href=".$URL."?env_orderby=".urlencode($varnom)."&".$filtre.">".$libelle."</a>*</th>";			
	}
	else
	{
			$message="<th><a href=".$URL."?env_orderby=".urlencode($varnom)."&".$filtre.">".$libelle."</a></th>";	
	}
}
elseif(($orderby==$varnom  && $invorderby <> 1 ) )
{
	$message="<th><a href=".$URL."?env_orderby=".urlencode($varnom)."&env_inverse=1&".$filtre.">".$libelle."</a>&#9650;</th> ";	
}
elseif(($orderby==$varnom  && $invorderby = 1 ) )
{
	$message="<th><a href=".$URL."?env_orderby=".urlencode($varnom)."&".$filtre.">".$libelle."</a>&#9660;</th> ";	
}
else
{
	$message="<th><a href=".$URL."?env_orderby=".$orderby.",".urlencode($varnom)."&".$filtre.">".$libelle."</a></th> ";
}
    return $message;
}


     // pour vérifier si le serveur ldap/AD est up
     function serviceping($host, $port=389, $timeout=1)
     {
		 
             $op = @fsockopen($host, $port, $errno, $errstr, $timeout);
             if (!$op) return 0; //serveur est down
         else {
         fclose($op); //explicitly close open socket connection
         return 1; //serveur est up & répond , on peut se connecter avec  ldap_connect
         }
     } 
	
	function ldap_connect_failover($_domain='') {
	// la liste des serveurs à tester
			 $dclist = array('193.55.48.123', '193.55.48.118');

			 foreach ($dclist as $dc) {
				 if (serviceping($dc) == true) {
					 break;
				 } else {
					 $dc = 0;
				 }
			 }
	//soit on a trouvé un serveur qui répond  et on retourne la connexion , soit on renvoie false
			if (!$dc) {
				//echo("pas de serveur ldap disponible, réessayez plus tard svp!");
				return false;
			}
			return ldap_connect($dc);
		} 
	
function ldap_gethost_failover($dclist) {
   foreach ($dclist as $dc) {
     if (serviceping($dc) == true) {
     $dcok=$dc;
	 break;
     } else {
       $dcok = 0;
     } 
   }
return $dcok;
 }	
 
function ask_ldapldap($login, $attr) { // Egalement copiée dans le CRON pour envois des mails de vérification
		// la liste des serveurs à tester
		$dclist = array('193.55.48.123', '147.171.0.1', '193.55.48.118');
			//	$dclist = array(  '193.55.48.118');
		/* # c'est un compte spécial qui ne sert qu'à ça et qui n'a pas de droits spéciaux
		$rootdn = "CN=ensgib,OU=People And Groups Managers,DC=gi-admin,DC=inpg,DC=fr";
		$rootpw = "jdcmpr.33";
		// OU racine où chercher
		$dn = "OU=People,DC=gi-admin,DC=inpg,DC=fr"; */
		$filtre = "(&(cn=$login))";
		//$ds = ldap_connect($server);
		$dcok=ldap_gethost_failover($dclist);

		// si
		if ($dcok!=0)
		{
			//echo '-------------serveur: '.$dcok;
			$ds = ldap_connect($dcok);
		//$ds = ldap_connect_failover($dclist);
		if ($dcok=='147.171.0.1')
		{
			//bleu
		$rootdn = "CN=_ensgiweb,OU=GI-ADMIN,OU=People,DC=grenoble-inp,DC=lan";
		$rootpw ="9N9vIGkz2RooTbh5ex4hyumnw8gEAKqR";
		// OU racine où chercher		
		$dn = "OU=GI-ADMIN,OU=People,DC=grenoble-inp,DC=lan";		
			
		}
		else
		{
			// giadmin3 ou giadmin8
			# c'est un compte spécial qui ne sert qu'à ça et qui n'a pas de droits spéciaux
		$rootdn = "CN=ensgib,OU=People And Groups Managers,DC=gi-admin,DC=inpg,DC=fr";
		$rootpw = "jdcmpr.33";
		// OU racine où chercher
		$dn = "OU=People,DC=gi-admin,DC=inpg,DC=fr";
		}
		//sinon on continue
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		$testconnect = ldap_bind($ds, $rootdn, $rootpw);
//
		if ($testconnect) {
				$sr = ldap_search($ds, $dn, $filtre);
				$nombre = ldap_count_entries($ds, $sr);
				if ($nombre == 1) {
					$info = ldap_get_entries($ds, $sr);
					// boucle en cas d'attrib multi evalues
					for ($j = 0; $j < sizeof($info[0][$attr])-1; $j++) {
						$message[$j] = $info[0][$attr][$j];
					}
				} // fin du if $nombre
				else {
					$message[0] = 'INEXISTANT DANS ANNUAIRE';
				}
			} 
			else {
				$message[0] = 'erreur connection ldap';
					}
									
		}
		else
		{
			$message[0] = 'pas de serveur ldap disponible, essayez plus tard svp!';
		}
		return $message;	

	}
	
	
function ask_ldap($login, $attr) { // fonction d'adaptation ldap ->mysql
		// la liste des serveurs à tester
	// on se connecte

$message   = array();
$i=0;

try{
		$connexion = Parameters::getEMGiUsers() ;
		}
catch (Exception $e){
die('Erreur : ' . $e->getMessage());
	}
//	NADIR 01 10 2024 
		if ($connexion) {
			$req = $connexion->query("SELECT  *  FROM people where user_login ='".$login."' LIMIT 1");
			$nombre=0;
			while ($u = $req->fetch(PDO::FETCH_OBJ)) {

					switch ($attr)
						{
							case  'givenname':
							$message[0]=$u->user_prenom;
							break;
							case  'displayname':
							$message[0]=$u->user_prenom . ' '.$u->user_nom;
							break;							
							case  'sn':
							$message[0]=$u->user_nom;
							break;

							case  'mail':
							$message[0]=$u->user_email;
							break;
							case  'cn':
							$message[0]=$u->user_login;							
							break;							
							case  'memberof':	
							{							
								$req2 = $connexion->query("select group_libelle from lignes_groupes left join groups on group_id=groupe_id left join people on people_id=user_login where user_login ='".$login."'");							
								while ($z = $req2->fetch(PDO::FETCH_OBJ)) {
							// on renvoie exactement le nom du groupe ldap par souci de compatibilité
									if ($z->group_libelle=='personnel'){
									$temp=	'CN=inpg-GI-personnels-GI-GSCOP,OU=Groups,DC=gi-admin,DC=inpg,DC=fr';
									}
									elseif ($z->group_libelle=='etudiant'){
									$temp=	'CN=inpg-GI-etudiants-ETU,OU=Groups,DC=gi-admin,DC=inpg,DC=fr';
									}
									else{
									$temp=	$z->group_libelle;	
									}
								$message[]=$temp;	
								}
							}
							break;							
							default	:			
							$message[0]='param incorrect';				
						}	
				$nombre++;					
			}

				if ($nombre == 0) { // nadir $nombre != 1
					$message[0]='INEXISTANT DANS ANNUAIRE';			
			} 
								
					return $message;
					
				
			}
			
			else {
				$message[0] = 'erreur connection ';
				return $message;
					}									
	}	
	
	
function ask_ldapplus($chainefiltre,$attr,$attrbfiltre){
// comme askldap mais on peut passer en parametre pour la recherche n'importe quel attribut
	//$server = "193.55.48.123";
	$port = "389"  ;
	$racine = "OU=People,DC=gi-admin,DC=inpg,DC=fr";
	# c'est un compte spécial qui ne sert qu'à ça et qui n'a pas de droits spéciaux
	$rootdn="CN=ensgib,OU=People And Groups Managers,DC=gi-admin,DC=inpg,DC=fr";
	$rootpw="jdcmpr.33";
	$ds = ldap_connect_failover();
     if (!$ds) exit("pas de serveur ldap disponible, essayez plus tard svp!");
         //sinon on continue 
	$testconnect = ldap_bind($ds,$rootdn,$rootpw);
	if ($testconnect)
		{
		$dn =   "OU=People,DC=gi-admin,DC=inpg,DC=fr";
		$filtre = "(&(".$attrbfiltre."=".$chainefiltre."))";
		$sr =ldap_search($ds,$dn,$filtre);
		$nombre = ldap_count_entries($ds,$sr);
		if ($nombre==1){
		$info = ldap_get_entries($ds,$sr);
// boucle en cas d'attrib multi evalues
for ( $j=0; $j<sizeof( $info[0][$attr])-1 ; $j++ ){
		$message[$j]=$info[0][$attr][$j];

	}
	}// fin du if $nombre
	else{
	$message[0]='INEXISTANT DANS ANNUAIRE';
		}
		}
	else{
		$message[0]='erreur connection ldap';
		}

    return $message;
}

function ask_ldapgroupe($groupe,$attr1='',$attr2='',$attr3=''){
// pour récupérer dans un tableau le contenu d'un groupe ldap// on peut spécifier 3 attributs en plus de l'uid (par defaut )
// c'est un tableau à 2 dimensions indicé par l'uid
	//$server = "193.55.48.123";
	$port = "389"  ;
	$racine = "OU=People,DC=gi-admin,DC=inpg,DC=fr";
	# c'est un compte spécial qui ne sert qu'à ça et qui n'a pas de droits spéciaux
	$rootdn="CN=ensgib,OU=People And Groups Managers,DC=gi-admin,DC=inpg,DC=fr";
	$rootpw="jdcmpr.33";
	$ds = ldap_connect_failover();
     if (!$ds) exit("pas de serveur ldap disponible, essayez plus tard svp!");
         //sinon on continue 
	$testconnect = ldap_bind($ds,$rootdn,$rootpw);
	if ($testconnect) 
		{
		$dn =   "OU=Groups,DC=gi-admin,DC=inpg,DC=fr";
		$filtre = "(&(name=".$groupe."))";
		$sr =ldap_search($ds,$dn,$filtre);
		$nombre = ldap_count_entries($ds,$sr);
		if ($nombre==1){
		$info = ldap_get_entries($ds,$sr);
// boucle en cas d'attrib multi evalues
	for ( $j=0; $j<sizeof( $info[0]['member'])-1 ; $j++ ){
		// il faut isoler uid
		$temp=$info[0]['member'][$j];
		$partie=explode(',',$temp);
		$uid=str_replace('CN=','',$partie[0]);
		$temp1=ask_ldap($uid,$attr1);
		$temp2=ask_ldap($uid,$attr2);
		$temp3=ask_ldap($uid,$attr3);		
		if ($attr1!='')$result1=$temp1[0] ;else $result1='';
		if ($attr2!='')$result2=$temp2[0];else $result2='';
		if ($attr3!='')$result3=$temp3[0];else $result3='';
			$message[$uid]=array($attr1=>$result1,$attr2=>$result2,$attr3=>$result3);
		}
	}// fin du if $nombre
	else{
	$message[0]='INEXISTANT DANS ANNUAIRE';
		}
		}
	else{
		$message[0]='erreur connection ldap';
		}
    return $message;
}


function nettoiecsv($champs)
//remplace les espaces,tiretset slash par des espaces
//prefixe par le nom de la table et passe en minuscule
{
$champs=str_replace("\r\n"," ",$champs);
$champs=str_replace("\"","'",$champs);
$champs=str_replace(";",",",$champs);
$champs= "\"".$champs."\"".";";
return $champs;
}

function nettoiecsvplus($champs)
// comme nettoiecsv mais special pour traiter les tags html
//remplace les rc  par des espaces
//remplace les " par des '
//remplace les ; par des ,

{
// on convertit les entités HTML stockées en leurs caractères correspondant.

$champs=html_entity_decode($champs,ENT_QUOTES,'ISO-8859-1');

/* $champs=str_replace("&nbsp;"," ",$champs);
$champs=str_replace("&eacute;","é",$champs);
$champs=str_replace("&ocirc;","ô",$champs);
$champs=str_replace("&ucirc;","û",$champs);
$champs=str_replace("&oelig;","oe",$champs);
$champs=str_replace("&egrave;","è",$champs); */
// on supprimme les tags <>
$champs=strip_tags($champs);
// pour des sauts de lignes dans les cellules du tableau excel
$champs=str_replace("\r\n",chr(10),$champs);
//$champs=str_replace("<li>",chr(10),$champs);
//et  on prepare les données pour le format csv
$champs=str_replace("\"","'",$champs);
$champs=str_replace(";",",",$champs);
$champs= "\"".$champs."\"".";";
return $champs;
}

// procedure générique qui execute une requete mysql
// on peut passer en 3eme argument ins/del/upd pour afficher un message de confirmation
function executesql($query,$connexion,$typemessage='',$sigiadminmail='gi-dev@grenoble-inp.fr')
{
$result = mysql_query($query,$connexion);
if (!$result) 
	{
		$messagem="\n Impossible d'exécuter la requête \n ".$query."\n erreur : \n " . mysql_error()."\n" ;
		$messagem.="\n Utilisateur : \n ".$_SERVER['PHP_AUTH_USER']."\n depuis : \n " . $_SERVER['REMOTE_ADDR']." navigateur :".$_SERVER['HTTP_USER_AGENT']."\n" ;
		echo '<br><center><h3><font color=\'red\'>Impossible d\'exécuter la requête : erreur mysql, aucune modification effectuée </font></h3> ( un mail d\'alerte est envoyé au développeur )</center><br>';
	   envoimail($sigiadminmail, 'erreur sql dans '.$_SERVER['PHP_SELF'], $messagem);
	   
	}
	else
	{
		switch ($typemessage)
		{
		case "ins":
		echo "<center>Ajout effectué !</center> ";
		break;
		case "del":
		echo "<center>Suppression effectuée !</center> ";
		break;
		case "upd":
		echo "<center>Modification effectuée !</center> ";
		break;			
		}
	
		return $result;
	}
}


function getInfosLigneTable ($table,$connexion,$valeur,$cle)
{

$champstable= champsfromtable ($table,$connexion);	
//on teste si la connexion est PDO ou classique
$champs=array();
if(is_object($connexion))
	{
		$req = $connexion->query("SELECT *  FROM $table  WHERE `".$cle."` ='".$valeur."'");
		if (!$req) {
		   echo 'Impossible d\'exécuter la requête  ';
		   exit;
		}
		if ($req->rowCount()== 1) {
			while ($row  = $req->fetch(PDO::FETCH_ASSOC)) {	
			foreach($champstable as $unchamp)
			{
			  $champs[$unchamp]= $row[$unchamp];			  
			}
			  //$type[]= $row["Type"];
		   }
		}
		else // si pas de correspondance on retourne un tableau de champs vides
		{
			foreach($champstable as $unchamp)
			{
			$champs[$unchamp]='';
			}
		}
	}

return $champs;
}

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
//pour les entetes de tableau cliquables
// correction 2020 on peut choisir ses variables $_GET
function afficheentete2020($libelle='-',$varnom,$orderby,$invorderby,$filtre,$URL){		
			// correction 2019 initialisation des paramètres avant la derniere position
	if ($libelle=='')$libelle='-';	
if   ((isset($_GET[$orderby]) && $_GET[$orderby]==$varnom ) && ( isset($_GET[$invorderby]) && $_GET[$invorderby]== 1))
{$message="<th><a href=".$URL."?".$orderby."=".urlencode($varnom)."&".$filtre.">".$libelle." </a>&#9660</th> ";}
elseif   ((isset($_GET[$orderby]) && $_GET[$orderby]==$varnom ) && ( isset($_GET[$invorderby]) && $_GET[$invorderby]!= 1))
{$message="<th><a href=".$URL."?".$orderby."=".urlencode($varnom)."&".$invorderby."=1&".$filtre.">".$libelle." </a>&#9650;</th> ";}
else
{$message= "<th><a href=".$URL."?".$orderby."=".urlencode($varnom)."&".$filtre.">".$libelle."</a></th> ";}
return $message;
}

function ask_loginFromEmail($email) { //
$i=0;
try{
		$connexion2 =Parameters::getEMGiUsers() ;
		}
catch (Exception $e){
die('Erreur : ' . $e->getMessage());
	}
//
		if ($connexion2) {
			$req = $connexion2->query("SELECT  *  FROM people where user_email ='".trim($email)."'");	
			$nombre=0;
			$temp='INEXISTANT DANS ANNUAIRE';
			while ($u = $req->fetch(PDO::FETCH_OBJ)) {					
					$temp=$u->user_login;	
				$nombre++;					
			}											
					return $temp;									
			}			
			else {
				$message = 'erreur connection ';
				return $message;
					}									
	}		

function image_unicampus($code_etu)
{
	$unicampus=array();
	$ch = curl_init("https://ganesh.grenoble-inp.fr/unicampus/API/code/".$code_etu);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
	curl_setopt($ch, CURLOPT_TIMEOUT,3); //timeout in seconds


$user='standarl';
$password='Cg3eB7Zw';
curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $password);
 /*On indique à curl de nous retourner le contenu de la requête plutôt que de l'afficher*/
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
/*On indique à curl de ne pas retourner les headers http de la réponse dans la chaine de retour*/
//curl_setopt($ch, CURLOPT_HEADER, false);
$return = curl_exec($ch);
if(curl_error($ch)) {
     //echo "IMAGE NOT FOUND";
}
else
{
	//echo "<br>connexion OK<br> ";
}
curl_close($ch);
$datadec=json_decode($return,TRUE);
$unicampus['status']=$datadec['status'];
$unicampus['message']=$datadec['message'];
if ($datadec['status'] !="404" )
{
$unicampus['dataimg']=$datadec['data']['src'];
}
	return $unicampus;
}

function askgroup_giusers($groupe) { 
		// pour récupérer laliste des uids des membres d'un groupe dont le nom est passé en paramètre 
	// on se connecte
$message=array('statut'=>array(),'uid'=>array());
$i=0;
try{
		$connexion =Parameters::getEMGiUsers() ;
		}
catch (Exception $e){
die('Erreur : ' . $e->getMessage());
	}
	
		if ($connexion) {
			$req = $connexion->query("SELECT  *  FROM lignes_groupes left join groups on lignes_groupes.groupe_id=group_id 
			where group_libelle ='".$groupe."'");		
			$nombre=0;
			while ($u = $req->fetch(PDO::FETCH_OBJ)) {
			$message['uid'][]=$u->people_id;
				$nombre++;					
			}
				if ($nombre == 0) {
					$message['statut'][0]='groupe vide ou inexistant';			
				} 
				else{
					$message['statut'][0]='OK';		
				}								
			}
			
			else {
				$message['statut'][0] = 'erreur connection ';
				return $message;
					}
	return $message;					
}


function isingroup_giusers($uid,$groupe) {
$message=array('statut'=>array(),'reponse'=>0);
$i=0;
try{
		$connexion =Parameters::getEMGiUsers() ;
		}
catch (Exception $e){
die('Erreur : ' . $e->getMessage());
	}
	
		if ($connexion) {
			$req = $connexion->query("SELECT  *  FROM lignes_groupes left join groups on lignes_groupes.groupe_id=group_id 
			where group_libelle ='".$groupe."' and lignes_groupes.people_id = '".$uid."'");		
			$nombre=0;
			while ($u = $req->fetch(PDO::FETCH_OBJ)) {			
				$nombre++;					
			}
				if ($nombre ==1 ) {
					$message['reponse']=1;	
					$message['statut'][0] = "trouvé une fois";					
				} 
				elseif ($nombre >1 ) {
					$message['reponse']=1;	
					$message['statut'][0] = "trouvé plus d\'une fois";					
				}
				else{
					$message['reponse']=0;	
					$message['statut'][0] = "pas trouvé" ;	
				}
											
			}
			
			else {
				$message['statut'][0] = 'erreur connection ';
				return $message;
					}
	return $message;					
}


function RemoveAccents2($string) {
    // From http://theserverpages.com/php/manual/en/function.str-replace.php
    //$string =  preg_replace("/[éè]/i", "E", $string);
	//$string =  preg_replace("/[ù]/i", "U", $string);
	//$string =  preg_replace("/[à]/i", "A", $string);
	return $string ; 
}



?>