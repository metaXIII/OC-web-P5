<?php

    use metaxiii\sudokuSolver\Database;
    use metaxiii\sudokuSolver\Sudoku;

    function setFlashSudoku($el, $row, $column) {
        echo "
<script>
function f() {
 var change = document.getElementsByClassName('sudoku__row')[" . $row . "].children[" . $column . "]
        change.setAttribute('value', " . $el . ")
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', f)
} else {f()}
</script>";
    }


    function setFlashSudokuTime($message) {
        echo "<script>
    function e()
    {
        document.getElementById('sudokuTime').innerText = '" . $message . "'
    }
    if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', e)
} else {e()}
</script>";
    }

    function checkPostSudoku() {
        if (isset($_POST) && !empty($_POST)) {
            $array = [];
            foreach ($_POST as $key => $value) {
                $array[$key] = (int)$value;
                if ($array[$key] > 10 || $array[$key] < 0) {
                    setFlash("Vous ne pouvez pas insérer de lettre, chiffres inférieurs à 0 ou supérieur à 9 voyons",
                        "danger");
                    header("Location: " . ROOT);
                    die();
                }
            }
            $first = array_slice($array, 0, 9);
            $second = array_slice($array, 9, 9);
            $third = array_slice($array, 18, 9);
            $fourth = array_slice($array, 27, 9);
            $fifth = array_slice($array, 36, 9);
            $sixth = array_slice($array, 45, 9);
            $seventh = array_slice($array, 54, 9);
            $eight = array_slice($array, 63, 9);
            $ninth = array_slice($array, 72, 9);
            $array = [$first, $second, $third, $fourth, $fifth, $sixth, $seventh, $eight, $ninth];
            $game = new Sudoku($array);
            $game->solve($array, sizeof($array));
            $game->print();
        }
    }


    function getSudokuGrid($grid = 0) {
        $db = Database::getPdo();
        if ($grid == 0) {
            $query = $db->query("SELECT COUNT(*) as number FROM grid");
            $number = $query->fetch()['number'];
            $grid = rand(1, $number);
            $query->closeCursor();
        }
        $query = $db->prepare("SELECT grid_content FROM grid WHERE id = :id");
        $query->bindValue(':id', $grid);
        $query->execute();
        $result = $query->fetch();
        $i = 0;
        $compteur = 1;
        echo "<div class='container__array'>";
        showGrid($result, $i, $compteur);
        echo "</div>";
    }

    function showGrid(mixed $result, int $i, int $compteur): void {
        if (!$result) {
            for ($i; $i < 9; $i++) {
                $j = 0;
                echo "<div class='sudoku__row'>";
                for ($j; $j < 9; $j++) {
                    echo "<input class='sudoku__number' type='text' name='$compteur' value=''>";
                    $compteur++;
                }
                echo "</div>";
            }
        } else {
            $result = unserialize($result['grid_content']);
            for ($i; $i < count($result); $i++) {
                $j = 0;
                echo "<div class='sudoku__row'>";
                for ($j; $j < count($result[$i]); $j++) {
                    $number = $result[$i][$j] ? $result[$i][$j] : '';
                    echo "<input class='sudoku__number' type='text' name='$compteur' value='$number'>";
                    $compteur++;
                }
                echo "</div>";
            }
        }
    }
