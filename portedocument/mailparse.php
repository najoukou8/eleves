<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
<?
require  "PlancakeEmailParser.php";

// ces 2 fichiers doivent être présent dans le même rep
require ("../function.php");
require ("../style.php");
echo "<head>";
echo "<title>decodage mails</title>";
echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />";
echo "</HEAD><BODY>" ;
$mailboxfile="/var/www/html/eleves2/portedocument/depot1";
// on ouvre le fichier
$lines = file($mailboxfile);
// fonctions mailparse
// $res=mailparse_msg_parse_file ( $mailboxfile) ;
//$body_parts = mailparse_msg_get_part_data ($res);
$emailPath = $mailboxfile;
$emailParser = new PlancakeEmailParser(file_get_contents($emailPath));
// You can use some predefined methods to retrieve headers...
$emailTo = $emailParser->getTo();
$emailSubject = $emailParser->getSubject();
$emailCc = $emailParser->getCc();
// ... or you can use the 'general purpose' method getHeader()
$emailDeliveredToHeader = $emailParser->getHeader('From');
$emailBody = $emailParser->getPlainBody();
$headerfrom=$emailParser->getHeader('From');
echo "<pre>";
//echo "emailTo ".$emailTo ."<br>";
echo "<br>emailTO------------------<br>";
var_dump($emailTo);
echo "<br>emailCc------------------<br>";
var_dump($emailCc);
echo "<br>emailDeliveredToHeader------------------<br>";
var_dump($emailDeliveredToHeader);
echo "<br>emailSubject ------------------<br>";
var_dump($emailSubject );
echo "<br>emailBody  ------------------<br>";
var_dump($emailBody );
echo "<br>from------------------<br>";
var_dump($headerfrom );
echo "<br>from2------------------<br>";
$emailtableau=explode(' ',$lines[0]);

var_dump($emailtableau[1] );
echo "</pre>";
//ici on retraite les infos extraites du mail pour pouvoir procéder à l'insertion dans la bdd 
// pour l'auteur on retrouve son login d'après son email
function ask_loginFromEmail($email) { //
	// on se connecte 
$dsn="gi_users";
$user_sql="lecture_users";
$password='Acdllmap';
$host="localhost";
$i=0;
try{
		$connexion2 =new PDO("mysql:host=".$host.";dbname=".$dsn.";", $user_sql, $password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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
	
	$loginfrommail=ask_loginFromEmail(trim($emailtableau[1]));
echo "<br>login------------------<br>";
echo "<br>$loginfrommail<br>";

function extractEmailsFromString($sChaine) {
  if(false !== preg_match_all('`\w(?:[-_.]?\w)*@\w(?:[-_.]?\w)*\.(?:[a-z]{2,4})`', $sChaine, $aEmails)) {
    if(is_array($aEmails[0]) && sizeof($aEmails[0])>0) {
      return array_unique($aEmails[0]);
    }
  }
  return null;
}
$emailetud=extractEmailsFromString($emailSubject);

// normalement il n'y en a qu'une

echo "<br>emailetud------------------<br>";
echo "<br>$emailetud[0]<br>";
$loginetud=ask_loginFromEmail(trim($emailetud[0]));
echo "<br>emaillogin------------------<br>";
echo "<br>$loginetud<br>";

// on a tout pour insérer le document dans portedocument
echo "<br>FIN------------------<br>";

?>
</body>
</html>
