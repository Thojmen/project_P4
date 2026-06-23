<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepten</title>
    <link rel="stylesheet" href="../css/recepten_v1.css">
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

    <aside class="filters">

        <h2>Filter op</h2>

        <h3>Type maaltijd</h3>

        <label><input type="radio" name="meal"> avondeten</label>
        <label><input type="radio" name="meal"> lunch</label>
        <label><input type="radio" name="meal"> ontbijt</label>

        <h3>Aantal personen</h3>

        <div class="range-box">
            <span>1</span>
            <input type="range" min="1" max="10">
            <span>10</span>
        </div>

        <h3>Prijs (€)</h3>

        <div class="range-box">
            <span>10</span>
            <input type="range" min="10" max="100">
            <span>100</span>
        </div>

        <h3>Allergieën</h3>

        <label><input type="checkbox"> tarwe</label>
        <label><input type="checkbox"> schaaldieren</label>
        <label><input type="checkbox"> eieren</label>
        <label><input type="checkbox"> vis</label>
        <label><input type="checkbox"> noten</label>
        <label><input type="checkbox"> soja</label>
        <label><input type="checkbox"> pinda's</label>
        <label><input type="checkbox"> melk</label>
        <label><input type="checkbox"> selderij</label>
        <label><input type="checkbox"> mosterd</label>
        <label><input type="checkbox"> sesamzaad</label>
        <label><input type="checkbox"> sulfieten</label>
        <label><input type="checkbox"> lupine</label>
        <label><input type="checkbox"> weekdieren</label>

    </aside>

    <main class="recipes">

        <div class="recipe-card">
            <img src="../img/recepten_1.png" alt="">
            <h2>gerecht 1</h2>
            <p>Korte beschrijving van het recept.</p>
        </div>

        <div class="recipe-card">
            <img src="../img/recepten_2.png" alt="">
            <h2>gerecht 2</h2>
            <p>Korte beschrijving van het recept.</p>
        </div>

        <div class="recipe-card">
            <img src="../img/recepten_3.png" alt="">
            <h2>gerecht 3</h2>
            <p>Korte beschrijving van het recept.</p>
        </div>

        <div class="recipe-card">
            <img src="../img/recepten_4.png" alt="">
            <h2>gerecht 4</h2>
            <p>Korte beschrijving van het recept.</p>
        </div>

        <div class="recipe-card">
            <img src="../img/recepten_5.png" alt="">
            <h2>gerecht 5</h2>
            <p>Korte beschrijving van het recept.</p>
        </div>

        <div class="recipe-card">
            <img src="../img/recepten_6.png" alt="">
            <h2>gerecht 6</h2>
            <p>Korte beschrijving van het recept.</p>
        </div>

    </main>

</div>
</body>
</html>