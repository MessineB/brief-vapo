<?php 

$pdo = new PDO('mysql:host=localhost; dbname=brief-vapo','root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
$content = '';
$error = '';
$pdostatement = $pdo->query("SELECT id, nom, typeobj, info, prix_achat, prix_vente,quantite ,reference FROM produit ORDER BY typeobj DESC ");

function debug($arg){
    echo "<div style='background:#fda500; z-index:1000; padding:15px;>";
    
    $trace = debug_backtrace();
    
    echo "<p>Debug demandé dans le fichier : ". $trace[0]['file']. "à la ligne". $trace[0]['line'] ."</p>";

    echo "<pre>";
        print_r($arg);
    echo "</pre>";

    echo "</div>";
}
function execute_requete($req){
    global $pdo;

    $pdostatement = $pdo->query($req);

    return $pdostatement;
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique vapoteuse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php 


// commande supprimé 

if(isset($_GET['action'])&& $_GET['action'] == 'suppression'){ 

    execute_requete(" DELETE FROM produit WHERE id = '$_GET[id]' ");
}

//Commande modifier 


///////////////////////////////////////////////DEBUT TABLEAU


echo "<table class ='table table-bordered' cellpadding= '8'>";
echo "<tr>";
    $nombre_colonne = $pdostatement->columnCount();
    for($i = 0; $i < $nombre_colonne; $i++){
        $info_colonne = $pdostatement->getColumnMeta($i);

            echo  "<th> $info_colonne[name]</th>";
    }
    echo  "<th> Suppression </th>";
    echo "<th> Modification </th>";
echo  "</tr>";
while($ligne = $pdostatement->fetch(PDO:: FETCH_ASSOC)){
            
    echo  "<tr>";
        foreach($ligne as $indice => $valeur){
            
            echo "<td> $valeur </td>";
            
        }
    
        echo  '<td class="text-center">
                    <a href="?action=suppression&id='. $ligne['id'] .'" onclick="return( confirm( \' Voulez vous supprimer ce user : ' . $ligne['nom'] . ' \' ) )" >
                        <i class="far fa-trash-alt"></i> 
                    </a>
                </td>';

        echo  '<td class="text-center">
                <a href="?action=modification&id='. $ligne['id'].' ">
                    <i class="far fa-edit"></i> 
                </a>
            </td>';
        

    echo  "</tr>";
}

echo  "</table>";


//ICI UN BOUTON "AJOUTER" QUI PERMETTRA DE DEBUTER L'AJOUT 

echo  ' <div class="text-center">
                            <a href="?action=ajout ">
                            <i class="fas fa-plus"> Ajouter un produit</i> 
                            </a>
                       </div> ';


///////////////////////////////////////////////FIN TABLEAU


// Commande modifier 

if(isset($_GET['action']) && $_GET['action'] == 'modification'): 
    $recup =  execute_requete ("SELECT nom,info,typeobj,prix_achat,prix_vente,quantite,reference FROM produit WHERE id = $_GET[id]");
    $amodifier = $recup->fetch(PDO:: FETCH_ASSOC); 
    $nom = $amodifier["nom"];
    $info = $amodifier["info"];
    $prix_achat = $amodifier["prix_achat"];
    $prix_vente = $amodifier["prix_vente"];
    $quantite = $amodifier["quantite"];
    $typeobj = $amodifier["typeobj"];
    $reference = $amodifier["reference"];

    if ( $_POST){
        execute_requete ("UPDATE produit SET
         nom = '$_POST[nom]',
         info = '$_POST[descri]',
         typeobj = '$_POST[produit]',
        prix_achat = '$_POST[prixa]',
        prix_vente = '$_POST[prixv]',
        quantite = '$_POST[quantite]',
        reference = '$_POST[ref]' 
        WHERE id='$_GET[id]' ");
        header('location:main.php');
    }
    echo  ' <div class="text-center">
    <a href="?action= "><i class="fas fa-ban"> Annuler</i>
   
    </a>
    </div> ';
?>
    

    <form method="post">
    <div class='d-flex justify-content-center'>
        <div class='d-flex flex-column bd-highlight mb-3'>

        <label class="text-center" > Type de produit </label>
            <select name="produit" >
            <option value="Vapoteuse"  > Vapoteuse </option>
            <option value="E-liquide"  > E-liquide </option>
            </select>

            <label class="text-center">Nom du produit </label>
            <input type="text" name="nom" value="<?= $nom ?>"><br>

            <label class="text-center">Description</label>
            <input type="text" name="descri" value="<?= $info ?>"><br>

            <label class="text-center">Prix d'achat</label>
            <input type="number" name="prixa" value="<?= $prix_achat ?>"><br>

            <label class="text-center">Prix de vente</label>
            <input type="number" name="prixv" value="<?= $prix_vente ?>"><br>

            <label class="text-center">Quantité</label>
            <input type="number" name="quantite" value="<?= $quantite ?>"><br>

            <label class="text-center"> Reference  </label>
            <input type="text" name="ref" value="<?= $quantite ?>"><br>

           
            <label class="text-center" > Bouton de validation </label>
            <input type="submit" class="btn btn-secondary" value="VALIDER" >
</form>   


<?php
endif;
?>



<?php
// Debut de l'ajout des données dans la PDO, via la methode post
if(isset($_GET['action']) && $_GET['action'] == 'ajout'):

   
    echo  ' <div class="text-center">
    <a href="?action= "><i class="fas fa-ban"> Annuler</i>
   
    </a>
    </div> ';


if ($_POST) {

    if (!is_numeric($_POST['quantite']) || !is_numeric($_POST['prixa']) || !is_numeric($_POST['prixv'])   ) {
        $error .= '
        <div class="d-flex justify-content-center">
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div>
                        Vous devez saisir un nombre !
                    </div>
            </div>
        </div>
        ';
    }
    
    if (strlen($_POST['nom']) <= 3 || strlen($_POST['nom']) > 15) {
        $error .= '<div class="alert alert-danger"> Erreur taille nom (doit etre compris entre 3 et 15 caractères)</div>';
    }


    $r = execute_requete(" SELECT nom FROM produit WHERE nom = '$_POST[nom]' ");

    if ($r->rowCount() >= 1) {

        $error .= "<div class='alert alert-danger'> Nom indisponible </div>";
    }

    $f = execute_requete(" SELECT reference FROM produit WHERE reference = '$_POST[ref]' ");

    if ($f->rowCount() >= 1) {

        $error .= "<div class='alert alert-danger'> Reference indisponible </div>";
    }
    if ($_POST["nom"]) {
        $nom = $_POST["nom"];
    } else {
        $nom = "";
    }
    
    if (empty($error)) {
        execute_requete("INSERT INTO produit (nom,info,typeobj,prix_achat,prix_vente,quantite,reference ) 
        VALUES ( 
            '$nom',
            '$_POST[descri]',
            '$_POST[produit]',
            '$_POST[prixa]',
            '$_POST[prixv]',
            '$_POST[quantite]',
            '$_POST[ref]' )
        ");
        $content .= '
        <div class="d-flex justify-content-center">
            <div class="alert alert-success d-flex align-items-center" role="alert">
                    <div>
                        <p>Produit ajouté</p>
                    </div>
            </div>
        </div>
        ';

        }
    
echo $content; //Affichage de content 
header('location:main.php');
}

echo $error; //affich un message d'erreur si necessaire

?>


<form method="post">
    <div class='d-flex justify-content-center'>
        <div class='d-flex flex-column bd-highlight mb-3'>

        <label class="text-center" > Type de produit </label>
            <select name="produit" >
            <option value="Vapoteuse"  > Vapoteuse </option>
            <option value="E-liquide"  > E-liquide </option>
            </select>

            <label class="text-center">Nom du produit </label>
            <input type="text" name="nom"><br>

            <label class="text-center">Description</label>
            <input type="text" name="descri"><br>

            <label class="text-center">Prix d'achat</label>
            <input type="number" name="prixa"><br>

            <label class="text-center">Prix de vente</label>
            <input type="number" name="prixv"><br>

            <label class="text-center">Quantité</label>
            <input type="number" name="quantite"><br>

            <label class="text-center"> Reference  </label>
            <input type="text" name="ref"><br>

           
            <label class="text-center" > Bouton de validation </label>
            <input type="submit" class="btn btn-secondary" value="VALIDER" >
</form>   
</body>
</html>

<?php

endif;
?>