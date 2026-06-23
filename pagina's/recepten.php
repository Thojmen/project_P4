<?php

require 'db.php';

$sql = "SELECT * FROM recipes ORDER BY title";

$result = $conn->query($sql);

$where = [];

if(!empty($_GET['category'])){

    $category =
        $conn->real_escape_string(
            $_GET['category']
        );

    $where[] =
        "category = '$category'";
}

$sql = "SELECT * FROM recipes";

if(count($where) > 0){
    $sql .= " WHERE " . implode(" AND ", $where);
}

$result = $conn->query($sql);

$allergies = $conn->query("
    SELECT *
    FROM allergies
    ORDER BY name
");

$where = [];
$params = [];
$types = "";

if(!empty($_GET['search'])){

    $where[] = "title LIKE ?";

    $params[] =
        "%" . $_GET['search'] . "%";

    $types .= "s";
}

if(!empty($_GET['category'])){

    $where[] = "category = ?";

    $params[] = $_GET['category'];

    $types .= "s";
}

if(!empty($_GET['servings'])){

    $where[] = "servings >= ?";

    $params[] = (int)$_GET['servings'];

    $types .= "i";
}

if(!empty($_GET['price'])){

    $where[] = "estimated_cost <= ?";

    $params[] = (float)$_GET['price'];

    $types .= "d";
}

if(
    !empty($_GET['allergies'])
){

    $allergyIds =
        array_map(
            'intval',
            $_GET['allergies']
        );

    $where[] = "
    recipes.id NOT IN (

        SELECT DISTINCT ri.recipe_id

        FROM recipe_ingredients ri

        JOIN ingredient_allergies ia
        ON ri.ingredient_id = ia.ingredient_id

        WHERE ia.allergy_id IN (
            " .
            implode(',', $allergyIds)
            . "
        )

    )";
}

$sql = "
SELECT *
FROM recipes
";

if(count($where) > 0){

    $sql .=
        " WHERE "
        . implode(" AND ", $where);
}

$stmt =
$conn->prepare($sql);

if(count($params) > 0){

    $stmt->bind_param(
        $types,
        ...$params
    );
}

$stmt->execute();

$result =
$stmt->get_result();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepten</title>
    <link rel="stylesheet" href="../css/recepten.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hubot+Sans:ital,wght@0,200..900;1,200..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div class="logo">
            <img src="../img/logo.png" alt="Green Cook">
        </div>

        <nav>
            <a href="home.php">Home</a>
            <a href="ideeën.php">Ideeën voor vanavond</a>
            <a href="recepten.php">Recepten</a>
            <a href="favorieten.php">Favorieten</a>
        </nav>
    </header>

    <div class="container">

    <div class="container">

        <aside class="filters">

            <form method="GET">

                <h2>Filter op</h2>

                <h3>Zoeken</h3>

                <input
                    type="text"
                    name="search"
                    placeholder="Zoek recept..."
                >

                <h3>Type maaltijd</h3>

                <label>
                    <input type="radio" name="category" value="avondeten">
                    avondeten
                </label>

                <label>
                    <input type="radio" name="category" value="lunch">
                    lunch
                </label>

                <label>
                    <input type="radio" name="category" value="ontbijt">
                    ontbijt
                </label>

                <h3>Aantal personen</h3>

                <input
                    type="range"
                    name="servings"
                    min="1"
                    max="10"
                >

                <h3>Prijs (€)</h3>

                <input
                    type="range"
                    name="price"
                    min="1"
                    max="100"
                >

                <h3>Allergieën</h3>

                <?php while($allergy = $allergies->fetch_assoc()): ?>

                    <label>

                        <input
                            type="checkbox"
                            name="allergies[]"
                            value="<?= $allergy['id'] ?>"
                        >

                        <?= htmlspecialchars($allergy['name']) ?>

                    </label>

                <?php endwhile; ?>

                <button type="submit">
                    Filter toepassen
                </button>

            </form>

        </aside>

        <main class="recipes">

            <?php while($recipe = $result->fetch_assoc()): ?>

                <div class="recipe-card">

                    <img
                        src="<?= htmlspecialchars($recipe['image']) ?>"
                        alt="<?= htmlspecialchars($recipe['title']) ?>"
                    >

                    <h2>
                        <?= htmlspecialchars($recipe['title']) ?>
                    </h2>

                    <p>
                        <?= htmlspecialchars($recipe['description']) ?>
                    </p>

                    <div class="recipe-meta">

                        <span>
                            <?= $recipe['servings'] ?> personen
                        </span>

                        <span>
                            €<?= number_format($recipe['estimated_cost'],2) ?>
                        </span>

                    </div>

                </div>

            <?php endwhile; ?>

        </main>

    </div>
</body>
</html>