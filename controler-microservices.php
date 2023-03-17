<?php

include  'functions.php';

echo '$_REQUEST';
var_dump($_REQUEST);
echo '$_FILES';
var_dump($_FILES);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$action = $_POST['action'];
	$id = $_POST['id'];
	if ($action != 'DELETE') {
		$titre = safeguard($_POST['titre']);
		$contenu = safeguard($_POST['contenu']);
		$prix = (float)safeguard($_POST['prix']);
		$image = safeguard(moveImage($_FILES['image']));
		$userID = (int) safeguard($_POST['userID']);
	}

	// session_unset();
	switch ($action):
		case 'CREATE':
			create('microservices', $titre, $contenu, $prix, $image, $userID);
			echo $_SESSION['message'] = '<p class="text-success my-2">Element créé</p>';
			// header('Location:'.WEB_ROOT.'admin/');
			break;
		case 'UPDATE':
			update('microservices', $id, $titre, $contenu, $prix, $image, $userID);
			echo $_SESSION['message'] = '<p class="text-success my-2">Element mis à jour</p>';
			// header('Location:'.WEB_ROOT.'admin/');
			break;
		case 'DELETE':
			delete('microservices', $id);
			echo $_SESSION['message'] = '<p class="text-success my-2">Element supprimé</p>';
			// header('Location:'.WEB_ROOT.'admin/');
			break;

		default:
			echo '<p>⚠ un problême est survenu</p>';
			break;
	endswitch;
}
?>

<a href="/crud/dashboard.php">Admin</a>