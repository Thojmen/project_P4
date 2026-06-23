<?php

require 'admin_auth.php';
require '../db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("
SELECT *
FROM recipes
WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$recipe = $stmt->get_result()->fetch_assoc();

if(!$recipe){
    die("Recept niet gevonden");
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Recept verwijderen</title>
</head>
<body>

<h1>Recept verwijderen</h1>

<p>
    Weet je zeker dat je
    <strong><?= htmlspecialchars($recipe['title']) ?></strong>
    wilt verwijderen?
</p>

<?php if(!empty($recipe['image'])): ?>

<img
    src="../<?= $recipe['image'] ?>"
    width="200"
>

<?php endif; ?>

<br><br>

<form action="destroy_recipe.php" method="POST">

    <input
        type="hidden"
        name="id"
        value="<?= $recipe['id'] ?>"
    >

    <button type="submit">
        Ja, verwijderen
    </button>

</form>

<br>

<a href="recipes.php">
    Nee, terug
</a>

</body>
</html>