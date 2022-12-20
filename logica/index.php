<?php

$pattern = '/^((((19|[2-9]\d)\d{2})\-(0[13578]|1[02])\-(0[1-9]|[12]\d|3[01]))|(((19|[2-9]\d)\d{2})\-(0[13456789]|1[012])\-(0[1-9]|[12]\d|30))|(((19|[2-9]\d)\d{2})\-02\-(0[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\-02\-29))$/';

session_start();


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if(comprobarReserva($id)){
        eliminarReserva($id);
        $success = "S'ha esborrat la reserva correctament";
    }
}

$sql = "SELECT * FROM reserves";

if (isset($_GET['ordenar'])) {
    global $sql;
    $ordenar = $_GET['ordenar'];
    if($ordenar == "data"){
        if(!isset($_SESSION['data'])){
            $_SESSION['data'] = true;
            unset($_SESSION['desti']);
        }else{
            unset($_SESSION['data']);
        }
    }else if($ordenar == "desti"){
        if(!isset($_SESSION['desti'])){
            $_SESSION['desti'] = true;
            $sql = "SELECT * FROM reserves ORDER BY desti ASC";
            unset($_SESSION['data']);
        }else{
            unset($_SESSION['desti']);
        }
    }
}

if(isset($_SESSION['data'])){
    $sql = "SELECT * FROM reserves ORDER BY date ASC";
}

if(isset($_SESSION['desti'])){
    $sql = "SELECT * FROM reserves ORDER BY desti ASC";
}


$preus = agafarPreus();
setcookie("preus", json_encode($preus));
$paisos = agafarPaisos();
setcookie("paisos", json_encode($paisos));

//SI EL USUARI HA PULSAT EL BOTÓ DE AFAEGIR AGAFEM LES DADES:
if (isset($_POST['submit'])) {
    $errorNom = $errorTel = $errorPersones = $error = $success = "";


    $date = $_POST['date'];
    $nom = $_POST['nom'];
    $tel = $_POST['tel'];
    $persones = $_POST['persones'];
    $continent = $_POST['continent'];
    $pais = $_POST['pais'];
    
    if (isset($_POST['descompte'])) {
        $descompte = 1;
    } else {
        $descompte = 0;
    }

    if (!empty($date)) {
        if (!preg_match($pattern, $date)) $errorData = "Format de data incorrecte";
    } else $errorData = "No pots deixar el camp data buit";

    if (!empty($nom)) {
        $nom = tractardades($nom);
    } else $errorNom = "Has d'introduir un nom";

    if (!empty($tel)) {
        if (!preg_match("/^[0-9]{9}$/", $tel)) {
            $errorTel =  "El telefon nomes pot contenir numeros i 9 digits";
        }
    } else $errorTel = "Has d'introduir un teléfon";

    if (!empty($persones)) {
        if (!is_numeric($persones) || $persones < 0) {
            $errorPersones =  "Les persones han de ser un numero positiu";
        }
    } else $errorPersones = "Has d'introduir un nombre de persones";

    if (!comprobarPais($continent, $pais)) {
        $errorPais = "El pais o continent no estàn disponibles per viatjar";
    }

    //si tots els camps estan omplerts i correctes fem la consulta cridan la funcio afagirReserva despres de calcular el preu
    if (empty($errorData) && empty($errorNom) && empty($errorTel) && empty($errorPersones) && empty($errorPais)) {
        if ($descompte) $Preu = $preus[$pais] * 0.8 * $persones;
        else $Preu = $preus[$pais] * $persones;
        afagirReserva($date, $Preu, $nom, $tel, $persones, $pais);
    }
}

$reserves = agafarReserves($sql);
setcookie("reserves",json_encode($reserves));




function conexiobd()
{
    //fem la conexio a la base de dades de wonderful_travel
    try {
        $connexio = new PDO('mysql:host=localhost;dbname=wonderful_travel', 'root', '');
    } catch (PDOException $e) {
        global $error;
        $error = "Error al conectarse a la base de dades!";
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

function afagirReserva($date, $Preu, $nom, $tel, $persones, $pais)
{
    $connexio = conexiobd();
    //fem la consulta amb preparestatement per evitar sql injection
    $statement = $connexio->prepare("INSERT INTO reserves (date, preu, nom, telefon, persones, desti) VALUES ('$date', '$Preu', '$nom', '$tel', '$persones', '$pais')");
    $statement->execute();
    global $success;
    $success = "Reserva afegida correctament";
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

function comprobarReserva($id)
{
    $connexio = conexiobd();
    $statement = $connexio->prepare("SELECT * FROM reserves WHERE id = ?");
    $statement->execute(array($id));

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
        global $error;
        $error = "No s'han trobat els preus a la base de dades";
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
        global $error;
        $error = "No s'han trobat els paisos a la base de dades";
    }
    return $paisos;
}

function agafarReserves($sql)
{
    $connexio = conexiobd();
    //fem la consulta per comprovar que hi ha reserves
    $statementcards = $connexio->prepare($sql);
    $statementcards->execute();
    $reserves = [];

    if ($statementcards->rowCount() > 0) {
        $statementcards->setFetchMode(PDO::FETCH_ASSOC);
        $iterator = new IteratorIterator($statementcards);
        
        foreach ($iterator as $row) {
        $reserves[] = array("id" => $row['id'],"desti" => $row['desti'], "date" => $row['date'], 'nom' => $row['nom'], "telefon" => $row['telefon'], 'persones' => $row['persones'], 'preu' => $row['preu']); 
        }
    } 
    return $reserves;
}


require '../vista/index.vista.php';
