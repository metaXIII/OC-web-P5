<?php
    checkPostSudoku();
    require "public/include/head.php";
?>

<main role="main" class="main">
    <section>
        <div id="carousel">
            <div class="item">
                <div class="item__image">
                    <img src="public/image/1.png" alt="velibAssistance" class="image_slider">
                </div>
                <div class="item__body">
                    <h3 class="item__title">
                        Bienvenue dans cette application "Solve Sudoku"
                    </h3>
                    <p class="item__description">
                        Vous pouvez voir un sudoku aléatoire se résoudre devant vos yeux ébahis !
                    </p>
                </div>
            </div>
            <div class="item">
                <div class="item__image">
                    <img src="public/image/2.png" alt="velibAssistance" class="image_slider">
                </div>
                <div class="item__body">
                    <h3 class="item__title">
                        Connectez vous et résolvez vos sudokus !
                    </h3>
                    <p class="item__description">
                        Vous pouvez transmettre des sudokus directement sur notre serveur pour tenter de trouver une
                        solution à votre sudoku !
                    </p>
                </div>
            </div>
        </div>

        <div class="container m-auto">
            <h2 class="text-center">Sudoku</h2>
            <span class="text-danger" id="alert_Sudoku"></span>
            <div class="col-12 text-center">
                <form action="#" method="post">
                    <?php getSudokuGrid(1) ?>
                    <hr>
                    <button class="btn btn-primary m-auto" type="submit">Résoudre</button>
                </form>
                <span id="sudokuTime"></span>
            </div>
        </div>
    </section>

    <?php
        //    $db = \metaxiii\sudokuSolver\Database::getPdo();
        //    $query = "SELECT grid_content from grid where id = 1";
        //    $result = $db->query($query);
        //    $result = $result->fetch();
        //    $arr = unserialize($result['grid_content']);

        //    var_dump($arr);
    ?>

</main>

<script src="public/js/carousel.js"></script>
<?php require "public/include/footer.php";
    //        $toData = serialize($array);
    //        $db = Database::getPdo();
    //        $query = $db->prepare("INSERT INTO grid (grid_content) VALUES (:array)");
    //        $query->bindValue(':array', $toData, PDO::PARAM_STR);
    //        $query->execute();

?>

