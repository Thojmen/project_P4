<?php
require 'admin_auth.php';
require '../db.php';

$result = $conn->query("
    SELECT *
    FROM recipes
    ORDER BY id DESC
");
?>

<h1>Recepten beheren</h1>

<a href="add_recipe.php">Nieuw recept</a>

<table>

<tr>
    <th>ID</th>
    <th>Titel</th>
    <th>Personen</th>
    <th>Prijs</th>
    <th>Acties</th>
</tr>

<?php while($recipe = $result->fetch_assoc()): ?>

<tr>

<td><?= $recipe['id'] ?></td>
<td><?= $recipe['title'] ?></td>
<td><?= $recipe['servings'] ?></td>
<td>€<?= $recipe['estimated_cost'] ?></td>

<td>
    <a href="edit_recipe.php?id=<?= $recipe['id'] ?>">
        Bewerken
    </a>

    <a href="delete_recipe.php?id=<?= $recipe['id'] ?>">
        Verwijderen
    </a>
</td>

</tr>

<?php endwhile; ?>

</table>

<a href="../home.php">Terug naar de website</a>