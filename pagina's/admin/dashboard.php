<?php
require 'admin_auth.php';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="sidebar">

    <h2>Green Cook</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="recipes.php">Recepten</a>
    <a href="../home.php">Website</a>
    <a href="ingredients.php">Ingrediënten</a>
    <a href="allergies.php">Allergieën</a>
    <a href="../logout.php">Uitloggen</a>

</div>

<div class="content">

    <h1>Dashboard</h1>

    <div class="cards">

        <div class="card">
            <h3>Recepten</h3>
            <p>Beheer alle recepten</p>
        </div>

        <div class="card">
            <h3>Gebruikers</h3>
            <p>Bekijk gebruikers</p>
        </div>

    </div>

</div>

</body>
</html>