<?php

require 'admin_auth.php';
require '../db.php';

$result = $conn->query("
SELECT *
FROM allergies
ORDER BY name
");
?>

<h1>Allergieën</h1>

<a href="add_allergy.php">
    Nieuwe allergie
</a>

<table border="1">

<tr>
    <th>ID</th>
    <th>Naam</th>
</tr>

<?php while($allergy = $result->fetch_assoc()): ?>

<tr>

<td><?= $allergy['id'] ?></td>

<td><?= htmlspecialchars($allergy['name']) ?></td>

</tr>

<?php endwhile; ?>

</table>