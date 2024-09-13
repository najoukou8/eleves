<?
function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
        }
    });
 
    return $array;
}

function utf8_encode_deep(&$input) {
	if (is_string($input)) {
		$input = utf8_encode($input);
	} else if (is_array($input)) {
		foreach ($input as &$value) {
			utf8_encode_deep($value);
		}
		
		unset($value);
	} else if (is_object($input)) {
		$vars = array_keys(get_object_vars($input));
		
		foreach ($vars as $var) {
			utf8_encode_deep($input->$var);
		}
	}
}

require ("param.php");
require ("function.php");
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
$listechamps=array();
$libchamps=array();
$listechamps1=champsfromtable ('etudiants',$connexion);
$listechamps2=champsfromtable ('etudiants_scol',$connexion);
$listecommentaires=champscommentfromtable ('etudiants',$connexion);
$commentLib1=champscommentfromtableplus ('etudiants',$connexion,0,'$',1);
$commentLib0=champscommentfromtableplus ('etudiants',$connexion,0,'$',0);	
$commentLib2=champscommentfromtableplus ('etudiants',$connexion,0,'$',4);

$commentLib02=champscommentfromtableplus ('etudiants_scol',$connexion,0,'$',0);
//print_r($commentLib1);
//echo "<br>-----------------------<br>";
// pour générer la liste des champs 
// si rien dans commentaire on ne le garde pas 

foreach ($commentLib0  as $key => $value)
{	
	if ($value!='')
		{	// on ne garde qu'une selection de champs pour ce traitement multi annuel	
			if( $_GET['multian']  )		
			{			
				if (in_array($key,$variablesMultiAnnuelles))
				{
					$listechamps[]=$key;
				}
			}
			else
			{			
					$listechamps[]=$key;
			}	
			
		}
}

foreach ($listechamps  as $unchamp)
{	
// si rien dans commentaire on prend le nom du champ comme libellé 
	if ($commentLib0[$unchamp]=='')
	{
	$libchamps[]=$unchamp;	
	$libchampsindex[$unchamp]=$unchamp;	
	}
	else
		// sinon  on prend le commentaire  comme libellé 
	{
	$libchamps[]=$commentLib0[$unchamp];
	$libchampsindex[$unchamp]=$commentLib0[$unchamp];	
	}
}

// $listechamps[]='Année Univ';
	// $libchamps[]='Année Univ';
	// $libchampsindex['Année Univ']='Année Univ';
$listechamps[]='annee';
	$libchamps[]='statut_final';
	$libchampsindex['annee']='statut_final';
$champsql='';
		foreach($listechamps as $unchamp)
		{	
		if(	$unchamp=='Date naiss')
		{
			$age=" YEAR(CURDATE()) - YEAR(MAKEDATE (cast(concat(if ( right(`Date naiss`,2) >= '00' AND  right(`Date naiss`,2) <'40','20','19'), right(`Date naiss`,2) ) as UNSIGNED ),1)) ";
			$champsql.=' '.$age."  as '".str_replace("'","''",stripslashes($libchampsindex[$unchamp]))."'".",";
		}
		elseif(	$unchamp=='Pays/dept naiss')
		{
		$champsql.="`dep_libelle` as '".str_replace("'","''",stripslashes($libchampsindex[$unchamp]))."'".",";
		$foreignk=$unchamp;
		}	
		elseif(	$unchamp=='Nationalité')
		{
		$champsql.="`dep_libelle` as '".str_replace("'","''",stripslashes($libchampsindex[$unchamp]))."'".",";
		$foreignk=$unchamp;
		}
		else
		$champsql.='`'.$unchamp."` as '".str_replace("'","''",stripslashes($libchampsindex[$unchamp]))."'".",";
		}
 $champsql=substr($champsql,0,strlen($champsql)-1) ;
$query="select ". $champsql." from   ligne_groupe 
 left join etudiants on code_etudiant=`Code etu` 
 left join etudiants_scol on etudiants_scol.code=`Code etu` 
 left join departements on dep_code=`".$foreignk."` 
where `code_groupe` in ('".$_GET['groupe']."')";
//echo $query;
$result = executesql($query,$connexion);	
 $jsonoutput=[];	
//$jsonoutput.='["code_etape","annee_univ","profil","insc"],';

	// on remplit un tableau avec les résultats
	while ($r=mysql_fetch_assoc($result))
	{			
		$cles=array_keys($r);
		$s=array_combine(utf8_converter($cles),utf8_converter($r));
		 $jsonoutput[]=$s;
	}


echo (json_encode($jsonoutput, JSON_INVALID_UTF8_IGNORE));

?>