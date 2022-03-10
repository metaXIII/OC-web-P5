<?php
    checkPostSudoku();
    require "public/include/head.php";
?>

    <main role="main" class="main">
        <section>
            <div>
                <div class="item">
                    <div class="item__image">
                        <img src="public/image/1.png" alt="velibAssistance" class="image_slider">
                    </div>
                    <div class="item__body">
                        <h3 class="item__title">
                            Bienvenue dans cette application "Solve Sudoku"
                        </h3>
                    </div>
                </div>
            </div>

            <div class="container m-auto">
                <h2 class="text-center">Sudoku</h2>
                <span class="text-danger" id="alert_Sudoku"></span>
                <div class="col-12 text-center">
                    <form action="#" method="post">
                        <?php getSudokuGrid(0) ?>
                        <hr>
                        <button class="btn btn-primary m-auto" type="submit">Résoudre</button>
                    </form>
                    <span id="sudokuTime"></span>
                </div>
            </div>
        </section>
    </main>

    <script src="public/js/carousel.js"></script>
<?php require "public/include/footer.php";
