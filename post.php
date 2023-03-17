<?php

include  'functions.php';


// var_dump($id);

$id = isset($_GET["id"]) ? $_GET["id"] : NULL;
if (!empty($id)) {
	$data = getSingle('microservices', $id);
	$action = "UPDATE";
	$libelle = "Mettre a jour";
} else {
	$action = "CREATE";
	$libelle = "Créer";
}

?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Microservices</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<!-- FONTAWSOME -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
	<link rel="shortcut icon" href="https://api.dicebear.com/5.x/identicon/svg?seed=CRUD" type="image/x-icon">
</head>

<body>


	<main class="container">
		<div class="row justify-content-center">
			<article class="col-md-6 p-2">
				<div class=" text-center">
					<?= isset($data['Image']) ? insertImage($data['Image'], 800) : NULL ?>
				</div>
				<?= isset($data['Titre']) ? '<h1>' . $data['Titre'] . '</h1>' : NULL ?>
				<?= isset($data['Contenu']) ? '<p>' . $data['Contenu'] . '</p>' : NULL ?>
				<?= isset($data['Prix']) ? '<p class="fs-1">Prix: ' . $data['Prix'] . '</p>' : NULL ?>
				<div>
					<a class="btn btn-primary" href="index.php">Retour</a>
				</div>
			</article>
		</div>
	</main>

</body>

</html>