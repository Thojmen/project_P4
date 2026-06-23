<?php

require 'admin_auth.php';
require '../db.php';

$result = $conn->query("
SELECT *
FROM ingredients
ORDER BY name
");

?>

<h1>Ingrediënten</h1>

<a href="add_ingredient.php">
    Nieuw ingrediënt
</a>

<table>

<tr>
    <th>ID</th>
    <th>Naam</th>
    <th>Prijs</th>
</tr>

<?php while($ingredient = $result->fetch_assoc()): ?>

<tr>

<td><?= $ingredient['id'] ?></td>

<td><?= htmlspecialchars($ingredient['name']) ?></td>

<td>€<?= $ingredient['average_price'] ?></td>

</tr>

<?php endwhile; ?>

</table>