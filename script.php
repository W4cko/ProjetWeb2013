<?php


define('DB_PROJET_HOST', '');
define('DB_PROJET_USER', '');
define('DB_PROJET_PASS', '');
define('DB_PROJET_DATABASE', '');

/* PGSQL */
try {
    $db_pg = new PDO('pgsql:host='.DB_PROJET_HOST.';dbname='.DB_PROJET_DATABASE, DB_PROJET_USER, DB_PROJET_PASS, array(
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ));
} catch(PDOException $e) {
    echo $e->getMessage();
    exit();
}

/* mysql */
try {
    $db_my = new PDO('mysql:host='.DB_PROJET_HOST.';dbname='.DB_PROJET_DATABASE, DB_PROJET_USER, DB_PROJET_PASS, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
    ));
} catch(PDOException $e) {
    echo $e->getMessage();
    exit();
}



// $reponse = $db_pg->query('SELECT * FROM communes');

    $reponse = $db_pg->query('SELECT * FROM departements');

/* TABLE COMMUNES
$req = $db_my->prepare('INSERT INTO communes(region,dept,comm,nom,nom_ascii_maj,tncc,compl,population,latitude,longitude) 
        VALUES(:region,:dept,:comm,:nom,:nom_ascii_maj,:tncc,:compl,:population,:latitude,:longitude)');
*/

/* Table Regions
$req = $db_my->prepare('INSERT INTO regions(code,nom,cl_dept,cl_rang,cl_comm) 
        VALUES(:code,:nom,:cl_dept,:cl_rang,:cl_comm)');
*/ 

$req = $db_my->prepare('INSERT INTO departements(code,nom,cl_dept,cl_comm,region,tncc) 
        VALUES(:code,:nom,:cl_dept,:cl_comm,:region,:tncc)');

while ($donnees = $reponse->fetch())
{
     echo $donnees['nom']."<br/>";
     
      /*$req->execute(array('region'=>$donnees['region'],
        'dept'=>$donnees['dept'],
        'comm'=>$donnees['comm'],
        'nom'=>$donnees['nom'],
        'nom_ascii_maj'=>$donnees['nom_ascii_maj'],
        'tncc'=>$donnees['tncc'],
        'compl'=>$donnees['compl'],
        'population'=>$donnees['population'],
        'latitude'=>$donnees['latitude'],
        'longitude'=>$donnees['longitude']));*/

   /* $req->execute(array(
        'code'=>$donnees['code'],
        'nom'=>$donnees['nom'],
        'cl_dept'=>$donnees['cl_dept'],
        'cl_rang'=>$donnees['cl_rang'],
        'cl_comm'=>$donnees['cl_comm']
    ));
    */
    
    $req->execute(array(
        'code'=>$donnees['code'],
        'nom'=>$donnees['nom'],
        'cl_dept'=>$donnees['cl_dept'],
        'cl_comm'=>$donnees['cl_comm'],
        'region'=>$donnees['region'],
        'tncc'=>$donnees['tncc']
    ));
}

$reponse->closeCursor();

echo 'salut';

?>