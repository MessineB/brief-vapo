<?php 

$pdo = new PDO('mysql:host=localhost; dbname=brief-vapo','root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
$content = '';
$error = '';

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
if ($_POST) {

    if (!is_numeric($_POST['quantite']) || !is_numeric($_POST['prixa']) || !is_numeric($_POST['prixv']) || !is_numeric($_POST['ref'])  ) {

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
    




    



}

echo $error; //affichage des messages d'erreur
?>


<form method="post">
    <div class='d-flex justify-content-center'>
        <div class='d-flex flex-column bd-highlight mb-3'>

            <label class="text-center">Nom du produit </label>
            <input type="text" name="nom"><br>

            <label class="text-center">Description</label>
            <input type="text" name="description"><br>

            <label class="text-center">Prix d'achat</label>
            <input type="number" name="prixa"><br>

            <label class="text-center">Prix de vente</label>
            <input type="number" name="prixv"><br>

            <label class="text-center">Quantité</label>
            <input type="number" name="quantite"><br>

            <label class="text-center"> Reference  </label>
            <input type="text" name="ref"><br>

            <label class="text-center" > Type de produit </label>
            <select name="produit" >
            <option value="Vapoteuse"  > Vapoteuse </option>
            <option value="E-liquide"  > E-liquide </option>
            </select>
            <label class="text-center" > Bouton Submit </label>
            <input type="submit" class="btn btn-secondary" value="SUBMIT" >
</form>   
</body>
</html>