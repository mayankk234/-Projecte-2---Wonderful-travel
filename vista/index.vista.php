<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wonderful-Travel</title>
    <!-- stylesheet -->
    <!-- scripts -->
    <script type="module" src="../js/Funcions.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">

<body>
    <div class="container-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <a class="navbar-brand text-light" href="#">Wonderful-Travel</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link text-light" href="../logica/index.php">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav w-100 justify-content-end ">
                </ul>
            </div>
        </nav>
    </div>


    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-2">
                <h1 class="text-end" id="header1">Wonderful</h1>
            </div>
            <div id="relojAnalogico" class=" col-1 reloj text-center"></div>
            <div class="col-2">
                <h1>Travel</h1>
            </div>
        </div>

        <hr>

        <form class="form-container" action="../logica/index.php" method="post">
            <div class="row">
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label class="control-label " for="date">Date</label>
                        <input class="form-control" id="date" name="date" type="date">
                    </div>
                    <?php if (!empty($errorData)) { ?>
                        <div class="alert alert-danger mt-2" role="alert"><?php echo $errorData; ?></div>
                    <?php } ?>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label" for="persones">Persones </label>
                        <input class="form-control" id="persones" name="persones" type="number" placeholder="nº persones" value=<?php if (!empty($_POST) && empty($success)) echo $_POST['persones']; ?>>
                    </div>
                    <?php if (!empty($errorPersones)) { ?>
                        <div class="alert alert-danger mt-2" role="alert"><?php echo $errorPersones; ?></div>
                    <?php } ?>
                </div>
            </div>





            <div class="row mb-3">
                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label" for="nom">Nom: </label>
                        <input class="form-control" id="nom" name="nom" type="text" placeholder="Nom" value=<?php if (!empty($_POST)  && empty($success)) echo $nom ?>>
                    </div>
                    <?php if (!empty($errorNom)) { ?>
                        <div class="alert alert-danger mt-2" role="alert"><?php echo $errorNom; ?></div>
                    <?php } ?>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label class="control-label" for="tel">Telefon: </label>
                        <input class="form-control" id="tel" name="tel" type="tel" placeholder="000 000 000" value=<?php if (!empty($_POST)  && empty($success)) echo $tel ?>>
                    </div>
                    <?php if (!empty($errorTel)) { ?>
                        <div class="alert alert-danger mt-2" role="alert"><?php echo $errorTel; ?></div>
                    <?php } ?>
                </div>
            </div>

            <div class="row mb-3">


                <div class="col-6">
                    <label class="control-label" for="continent">Desti</label>
                    <select class="form-select" aria-label="Default select example" id="continent" name="continent">
                        <option disabled selected value hidden></option>
                        <option value="Asia">Asia</option>
                        <option value="Africa">Africa</option>
                        <option value="Europa">Europa</option>
                        <option value="America">America</option>
                    </select>
                    <?php if (!empty($errorPais)) { ?>
                        <div class="alert alert-danger mt-2" role="alert"><?php echo $errorPais; ?></div>
                    <?php } ?>
                </div>

                <div class="col-6">
                    <label class="control-label" for="pais">Pais</label>
                    <select class="form-select" aria-label="Default select example" id="pais" name="pais"></select>
                    </select>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-3 d-flex flex-column">
                    <div class="form-group col">
                        <label class="control-label" for="preu">Preu: </label>
                        <input class="form-control" id="preu" name="preu" type="text" disabled>
                    </div>
                    <div class="form-check col">
                        <label class="form-check-label" for="decompte">Descompte 20%</label>
                        <input class="form-check-input" type="checkbox" value="" id="descompte" name="descompte">
                    </div>
                    <div class="col mt-auto ">
                        <button type="submit" name="submit" class="btn btn-primary align-bottom  w-50">Comprar tiquets</button>
                    </div>

                </div>

                <div class="col mt-2 ">
                    <div id="imatge" class="text-center w-auto h-auto">
                    </div>
                </div>
            </div>


            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger role=alert"><?php echo $error; ?></div>
            <?php } ?>
            <?php if (!empty($success)) { ?>
                <div class="alert alert-success role=alert"><?php echo $success; ?></div>
            <?php } ?>


        </form>
        <div id="reserves" class="row justify-content-around">

            

        </div>



    </div>


</body>

</html>