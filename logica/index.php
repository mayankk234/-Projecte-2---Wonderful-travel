<?php


    conexiobd();

    //SI EL USUARI HA PULSAT EL BOTÓ DE AFAEGIR AGAFEM LES DADES:
    if(isset($_POST['submit'])){
        $errorPreu = "";
        $errorNom = "";
        $errorTel = "";
        $errorPersones = "";
        $error = "";


        $Date = $_POST['date'];
        $Preu = $_POST['preu'];
        $Nom = $_POST['nom'];
        $Tel = $_POST['tel'];
        $persones = $_POST['persones'];
        //agafem el checkbox de descompte
        if(isset($_POST['descompte'])){
            $descompte = 1;
        }else{
            $descompte = 0;
        }

        if(isset($_POST['continent'])){
            $continent = $_POST['continent'];
        }else{
            $continent = null;
        }
        if(isset($_POST['pais'])){
            $pais = $_POST['pais'];
        }else{
            $pais = null;
        }

        //comprovem que no hi hagi camps buits
        if(empty($Date) || empty($Preu) || empty($Nom) || empty($Tel) || empty($persones) || empty($continent) || empty($pais)){
            $error =  "No pots deixar camps buits";
        }else{
            //si tots els camps estan omplerts comprovem que el preu sigui un numero, el nom nomes lletres i el tel nomes numeros i 9 digits 
            if(!is_numeric($Preu)){
                $errorPreu =  "El preu ha de ser un numero";
            }
            if(!preg_match("/^[a-zA-Z ]*$/",$Nom)){
                $errorNom =  "El nom nomes pot contenir lletres";
            }
            if(!preg_match("/^[0-9]{9}$/",$Tel)){
                $errorTel =  "El telefon nomes pot contenir numeros i 9 digits";
            }
            if(!is_numeric($persones)){
                $errorPersones =  "Les persones han de ser un numero";
            }

            //si tots els camps estan omplerts i correctes fem la consulta cridan la funcio afagirReserva
            if(is_numeric($Preu) && preg_match("/^[a-zA-Z ]*$/",$Nom) && preg_match("/^[0-9]{9}$/",$Tel) && is_numeric($persones)){
                afagirReserva($Date, $Preu, $Nom, $Tel, $persones, $pais);
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



    function conexiobd(){
        //fem la conexio a la base de dades de wonderful_travel
        try {
            $connexio = new PDO('mysql:host=localhost;dbname=wonderful_travel', 'root', '');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            echo "Error al conectarse a la base de dades!";

        }
        return $connexio;

    }

    function afagirReserva($Date, $Preu, $Nom, $Tel, $persones, $pais){
        $connexio = conexiobd();
        //fem la consulta amb preparestatement per evitar sql injection
        $statement = $connexio->prepare("INSERT INTO reserves (date, preu, nom, telefon, persones, desti) VALUES ('$Date', '$Preu', '$Nom', '$Tel', '$persones', '$pais')");
        $statement->execute();
        echo "Reserva afegida correctament";
    }

    function eliminarReserva($id){
        $connexio = conexiobd();
        //fem la consulta amb preparestatement per evitar sql injection
        $statement = $connexio->prepare("DELETE FROM reserves WHERE id = '$id'");
        $statement->execute();
    }

    require '../vista/index.vista.php';
?>