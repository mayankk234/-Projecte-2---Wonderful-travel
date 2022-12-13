<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wonderful-Travel</title>
    <!-- stylesheet -->
    <!-- scripts -->
    <script type="module" src="../js/Funcions.js" ></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet"/>
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
            <div class="form-group"> 
                <label class="control-label" for="date">Date</label>
                <input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="date"/>
            </div>

            <div class="row">

                <div class="col">
                    <label class="control-label" for="continent">Desti</label>
                    <select class="form-select" aria-label="Default select example" id="continent" name="continent">
                        <option value="Asia" selected>Asia</option>
                        <option value="Africa">Africa</option>
                        <option value="Europa">Europa</option>
                        <option value="America">America</option>
                    </select>
                </div>

                <div class="col">
                <label class="control-label" for="pais">Pais</label>
                    <select class="form-select" aria-label="Default select example" id="pais" name="pais"></select>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <div class="form-group"> 
                        <label class="control-label" for="preu">Preu: </label>
                        <input class="form-control" id="preu" name="preu" type="number" placeholder="preu €"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group"> 
                        <label class="control-label" for="nom">Nom: </label>
                        <input class="form-control" id="nom" name="nom" type="text" placeholder="name"/>
                    </div>
                </div>
            </div>
                                                <!-- error: -->
            <?php if (!empty($errorNom)) { ?>
                <div class="alert alert-danger" role="alert"><?php echo $errorNom; ?></div>
            <?php } ?>

            <div class="row">
                <div class="col-3">
                    <div class="form-group"> 
                        <label class="control-label" for="tel">Telefon: </label>
                        <input class="form-control" id="tel" name="tel" type="tel" placeholder="000 000 000"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <div class="form-group"> 
                        <label class="control-label" for="persones">Persones </label>
                        <input class="form-control" id="persones" name="persones" type="number" placeholder="nº persones"/>
                    </div>
                </div>
            </div>
            <br>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="descompte" name="descompte">
                <label class="form-check-label" for="decompte">
                    Descompte 20%
                </label>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>        
        <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger role="alert"><?php echo $error; ?></div>
        <?php } ?>
        <div id="reservas" class="row justify-content-around">
        
			 <!--aqui guardem els articles-->
				<?php 
				while($res = $statementcards->fetch(PDO::FETCH_ASSOC)):
                    $desti = "../imatges/";
                    $desti .= $res['desti'];
                    $desti .= ".jpg";
					?>
					<div class="card col-4 mb-3" style="width: 22rem;">
						<div class="card-body">
                            <img src="<?php echo $desti?>" class="card-img-top" alt="...">
							<h4 class="card-title"><?php echo $res['date'];?></h4>
							<!-- agafem nomes un part del text i si volem veure el text sencer fem click a veure mes -->
							<h5 class="card-text"><?php echo $res['desti'];?></h5>
                            <p class="card-text"><?php echo $res['nom'];?></p>
                            <p class="card-text"><?php echo $res['telefon'];?></p>
                            <p class="card-text"><?php echo $res['persones'];?> Persones</p>
                            <p class="card-text"><?php echo $res['preu'];?>€</p>
                            <!-- boto per elimar un article de la base de dades. -->
							<button type="button" id="btn11" class="btn btn-light"><a href="../logica/index.php?delete=<?php echo $res['id']; ?>"><img src="../imatges/trash.png" width="30px"/></a></button>
							<hr>
						</div>
					</div>
					
					<?php
				endwhile;
				?>

			</div>


      
    </div>


</body>

</html>