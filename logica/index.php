<?php

$pattern = '/^((((19|[2-9]\d)\d{2})\-(0[13578]|1[02])\-(0[1-9]|[12]\d|3[01]))|(((19|[2-9]\d)\d{2})\-(0[13456789]|1[012])\-(0[1-9]|[12]\d|30))|(((19|[2-9]\d)\d{2})\-02\-(0[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\-02\-29))$/';

$preus = agafarPreus();
setcookie("preus", json_encode($preus));
$paisos = agafarPaisos();
setcookie("paisos", json_encode($paisos));

//SI EL USUARI HA PULSAT EL BOTÓ DE AFAEGIR AGAFEM LES DADES:
if (isset($_POST['submit'])) {
    $errorPreu = "";
    $errorNom = "";
    $errorTel = "";
    $errorPersones = "";
    $error = "";


    $date = $_POST['date'];
    $Preu = $_POST['preu'];
    $Nom = $_POST['nom'];
    $Tel = $_POST['tel'];
    $persones = $_POST['persones'];
    //agafem el checkbox de descompte
    if (isset($_POST['descompte'])) {
        $descompte = 1;
    } else {
        $descompte = 0;
    }

    if (isset($_POST['continent'])) {
        $continent = $_POST['continent'];
    } else {
        $continent = null;
    }
    if (isset($_POST['pais'])) {
        $pais = $_POST['pais'];
    } else {
        $pais = null;
    }

    //comprovem que no hi hagi camps buits
    if (empty($date) || empty($Preu) || empty($Nom) || empty($Tel) || empty($persones) || empty($continent) || empty($pais)) {
        $error =  "No pots deixar camps buits";
    } else {
        //si tots els camps estan omplerts comprovem que el preu sigui un numero, el nom nomes lletres i el tel nomes numeros i 9 digits 
        if (!is_numeric($Preu)) {
            $errorPreu =  "El preu ha de ser un numero";
        }
        if (!preg_match("/^[a-zA-Z ]*$/", $Nom)) {
            $errorNom =  "El nom nomes pot contenir lletres";
        }
        if (!preg_match("/^[0-9]{9}$/", $Tel)) {
            $errorTel =  "El telefon nomes pot contenir numeros i 9 digits";
        }
        if (!is_numeric($persones)) {
            $errorPersones =  "Les persones han de ser un numero";
        }
        if (!comprobarPais($continent, $pais)) {
            $errorPais = "El pais o continent no estàn disponibles per viatjar";
        }


        if (!preg_match($pattern, $date)) {
            $errorData = "Format de data incorrecte";
        }


        //si tots els camps estan omplerts i correctes fem la consulta cridan la funcio afagirReserva
        if (is_numeric($Preu) && preg_match("/^[a-zA-Z ]*$/", $Nom) && preg_match("/^[0-9]{9}$/", $Tel) && is_numeric($persones)) {
            afagirReserva($date, $Preu, $Nom, $Tel, $persones, $pais);
        }
    }
}


$connexio = conexiobd();
//fem la consulta per comprovar que hi ha reserves
$statementcards = $connexio->prepare("SELECT * FROM reserves");
$statementcards->execute();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    eliminarReserva($id);
}



function conexiobd()
{
    //fem la conexio a la base de dades de wonderful_travel
    try {
        $connexio = new PDO('mysql:host=localhost;dbname=wonderful_travel', 'root', '');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        echo "Error al conectarse a la base de dades!";
    }
    return $connexio;
}

function tractardades($dades)
{
    $dades = trim($dades);
    $dades = stripslashes($dades);
    $dades = htmlspecialchars($dades);
    return $dades;
}

function afagirReserva($date, $Preu, $Nom, $Tel, $persones, $pais)
{
    $connexio = conexiobd();
    //fem la consulta amb preparestatement per evitar sql injection
    $statement = $connexio->prepare("INSERT INTO reserves (date, preu, nom, telefon, persones, desti) VALUES ('$date', '$Preu', '$Nom', '$Tel', '$persones', '$pais')");
    $statement->execute();
    echo "Reserva afegida correctament";
}

function eliminarReserva($id)
{
    $connexio = conexiobd();
    //fem la consulta amb preparestatement per evitar sql injection
    $statement = $connexio->prepare("DELETE FROM reserves WHERE id = '$id'");
    $statement->execute();
}

function comprobarPais($continent, $pais)
{
    $connexio = conexiobd();
    $statement = $connexio->prepare("SELECT * FROM paisos WHERE continent = ? AND pais = ?");
    $statement->execute(array($continent, $pais));

    $res = $statement->fetch(PDO::FETCH_ASSOC);

    if ($res) {
        return true;
    } else {
        return false;
    }
}

function agafarPreus()
{
    $connexio = conexiobd();
    $statement = $connexio->prepare("SELECT * FROM preus");
    $statement->execute();
    $preus = [];
    if ($statement->rowCount() > 0) {
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $iterator = new IteratorIterator($statement);
        foreach ($iterator as $row) {
            $preus[$row['pais']] = $row['preu'];
        }
    } else {
        echo "No s'han trobat els preus a la base de dades";
    }
    return $preus;
}


function agafarPaisos()
{
    $connexio = conexiobd();
    $statement = $connexio->prepare("SELECT * FROM paisos");
    $statement->execute();
    $paisos = [];
    if ($statement->rowCount() > 0) {
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $iterator = new IteratorIterator($statement);
        foreach ($iterator as $row) {
            $paisos[$row['continent']][] = $row['pais'];
        }
    } else {
        echo "No s'han trobat els paisos a la base de dades";
    }
    return $paisos;
}

require '../vista/index.vista.php';
