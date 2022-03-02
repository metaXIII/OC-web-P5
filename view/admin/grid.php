<?php
    checkPostSudoku();
    require "public/include/head.php";
    $closing_div = "</div>";

    echo "<div class='container text-center'>";

    echo "<form method='post' action='#'>";
    echo "<div class='container m-2'>";
    if ($_GET['url'] === 'admin/new-grid') {
        echo "<h2 class='text-center'>Nouvelle grille</h2>";
        getSudokuGrid(-1);
        echo $closing_div;
        echo "<button class='btn btn-primary mt-2'>Résoudre</button>";
    } else {
        echo "<h2 class='text-center'>Jouer</h2>";
        getSudokuGrid(0);
        echo "<button class='btn btn-primary mt-2'>Résoudre</button>";
        echo $closing_div;
    }
    echo "</form>";
    echo "<p><span id='sudokuTime'></span></p>";
    echo "<span class='text-danger' id='alert_Sudoku'>&nbsp;</span>";
    echo $closing_div;
    require "public/include/footer.php";
