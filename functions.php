<?php

require_once 'Database.php';

// ANCHOR READ Afficher tous les posts
function getAll($table)
{
    try {
        $db = new Database();
        $connexion = $db->getPDO();
        $sql = "SELECT * FROM $table";
        $req = $connexion->query($sql);

        $rows = $req->fetchAll();

        return $rows;
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}

//ANCHOR READ Afficher un post

function getSingle($table, $id)
{
    try {
        $db = new Database();
        $connexion = $db->getPDO();
        $sql = "SELECT * FROM $table WHERE ms_id= :id";
        $req = $connexion->prepare($sql);
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
        $row = $req->fetch();
        return $row;
        // REVIEW fetch()
        // if(!empty($rows)) {
        //     return $rows[0];
        // }
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}

// ANCHOR CREATE Créer
function create($table, $titre, $contenu, $prix, $image, $userID)
{
    try {
        $db = new Database();
        $connexion = $db->getPDO();
        $sql = "INSERT INTO $table (ms_titre, ms_contenu, ms_prix, ms_image, user_id) VALUES (:titre, :contenu, :prix, :image, :userID)";
        $req = $connexion->prepare($sql);
        $req->bindParam(':titre', $titre, PDO::PARAM_STR);
        $req->bindParam(':contenu', $contenu, PDO::PARAM_STR);
        $req->bindParam(':prix', $prix, PDO::PARAM_INT);
        $req->bindParam(':image', $image, PDO::PARAM_STR);
        $req->bindParam(':userID', $userID, PDO::PARAM_INT);
        $req->execute();
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}

// ANCHOR UPDATE Modifier
function update($table, $id, $titre, $contenu, $prix, $image, $userID)
{
    try {
        $db = new Database();
        $connexion = $db->getPDO();
        if (!empty($image)) {
            $sql = "UPDATE $table SET ms_titre = :titre, ms_contenu = :contenu, ms_prix = :prix, ms_image = :image, user_id = :userID WHERE microservice_id = :id ";
            $req = $connexion->prepare($sql);
            $req->bindParam(':titre', $titre, PDO::PARAM_STR);
            $req->bindParam(':contenu', $contenu, PDO::PARAM_STR);
            $req->bindParam(':prix', $prix, PDO::PARAM_INT);
            $req->bindParam(':image', $image, PDO::PARAM_STR);
            $req->bindParam(':userID', $userID, PDO::PARAM_INT);
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
        } else {
            $sql = "UPDATE $table SET ms_titre = :titre, ms_contenu = :contenu, ms_prix = :prix, user_id = :userID WHERE microservice_id = :id ";
            $req = $connexion->prepare($sql);
            $req->bindParam(':titre', $titre, PDO::PARAM_STR);
            $req->bindParam(':contenu', $contenu, PDO::PARAM_STR);
            $req->bindParam(':prix', $prix, PDO::PARAM_INT);
            $req->bindParam(':userID', $userID, PDO::PARAM_INT);
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
        }
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}


// ANCHOR DELETE Supprimer

function delete($table, $id)
{
    try {
        $db = new Database();
        $connexion = $db->getPDO();
        $sql = "DELETE FROM $table WHERE ms_id = :id";
        $req = $connexion->prepare($sql);
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}

// REVIEW Supprimer l'image

// ANCHOR Afficher les posts

function displayPosts($table)
{
    $rows = getAll($table);
    foreach ($rows as $row) :
?>
        <div class="col-md-4 p-2">
            <article class="border border-secondary">
                <div>
                    <img src="" alt="Lorem">
                </div>
                <div class="p-2">
                    <h3><?= $row['ms_titre'] ?></h3>
                    <p><?= substr($row['ms_contenu'],0,120) ?> ...</p>
                    <span class="btn btn-light">À partir de <strong><?= $row['ms_prix'] ?> €</strong></span>
                    <a class="link-secondary" href="post.php?id=<?= $row['ms_id'] ?>">En savoir plus </a>
                </div>
            </article>
        </div>
<?php

    endforeach;
}
// ANCHOR Afficher l'en-tête de la table

function getHeaderTable($table)
{
    try {
        $db = new Database();
        $connexion = $db->getPDO();
        // ANCHOR BBD et TABLE
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA= :table_schema AND TABLE_NAME = :table_name ORDER BY ORDINAL_POSITION";
        $req = $connexion->prepare($sql);
        $req->bindParam(':table_name', $table, PDO::PARAM_STR);
        $req->bindParam(':table_schema', $table, PDO::PARAM_STR);
        $req->execute();
        $rows = $req->fetchAll();
        return $rows;
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}
// ANCHOR DASHBOARD | Afficher un tableau

function displayTable($table)
{
    $headers = getHeaderTable($table);
    $rows = getAll($table);
?>
    <table class="table table-hover">
        <thead>
            <tr>
                <?php
                foreach ($headers as $header) :
                ?>
                    <th scope="col"><?= $header['COLUMN_NAME'] ?></th>
                <?php
                endforeach;
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rows as $row) :
                // var_dump(array_key_first($row) ? 'yes' : $row);
            ?>
                <tr class="position-relative">

                    <td scope="col">
                        <a class="btn btn-link stretched-link text-decoration-none" href="ajouter-un-microservice.php?id=<?= $row['ms_id'] ?>"><i class="bi bi-pencil-square"></i> <?= $row['ms_id'] ?></a>
                    </td>
                    <td scope="col">
                        <?= $row['ms_titre'] ?>
                    </td>
                    <td scope="col">
                        <?= $row['ms_contenu'] ?>
                    </td>
                    <td scope="col">
                        <?= $row['ms_prix'] ?>
                    </td>
                    <td scope="col text-center">
                        <img src="<?= 'uploads/images/' . $row['ms_image'] ?>" alt="<?= substr($row['ms_contenu'],0,80) ?>" width="120">
                    </td>
                    <td scope="col">
                        <?= $row['user_id'] ?>
                    </td>
                </tr>
            <?php
            endforeach;
            ?>
        </tbody>

    </table>
    <?php
}