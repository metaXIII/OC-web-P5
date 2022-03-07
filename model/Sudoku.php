<?php

    namespace metaxiii\sudokuSolver;


    class Sudoku {
        private array $grid;
        private $time = array();
        private $db;
        private array $gridToSave;

        public function __construct(array $grid) {
            $this->db = Database::getPdo();
            $this->grid = $grid;
            $this->gridToSave = $grid;
            $this->time['start'] = microtime(true);
        }

        public function __destruct() {
            $this->time['end'] = microtime(true);
            $time = $this->time['end'] - $this->time['start'];
            showScore(number_format($time, 4) . " sec");
            setFlashsudokuTime("Temps d\'exécution : " . number_format($time, 4) . " sec");
            if ($this->solve($this->grid, sizeof($this->grid)) && isset($_SESSION['Auth']) && isAdmin($_SESSION['Auth'])) {
                $toData = serialize($this->grid);
                $query = $this->db->prepare("SELECT * from sudokusolver.grid WHERE grid_content = :toData");
                $query->bindValue(':toData', $toData, \PDO::PARAM_STR);
                $query->execute();
                if ($query->rowCount()) {
                    return;
                } else {
                    $query = $this->db->prepare("INSERT INTO sudokusolver.grid (grid_content) VALUES (:array)");
                    $query->bindValue(':array', serialize($this->gridToSave), \PDO::PARAM_STR);
                    $query->execute();
                }
            }
        }

        public function solve(array $grid, int $length): bool {
            $isEmpty = true;
            $this->printDebug();
            for ($i = 0; $i < $length; $i++) {
                for ($j = 0; $j < $length; $j++) {
                    if ($grid[$i][$j] == 0) {
                        $row = $i;
                        $col = $j;
                        $isEmpty = false;
                        break;
                    }
                }
                if (!$isEmpty) {
                    break;
                }
            }
            if ($isEmpty) {
                return true;
            }
            for ($num = 1; $num <= $length; $num++) {
                if ($this->isSafe($grid, $row, $col, $num)) {
                    $grid[$row][$col] = $num;
                    $this->grid[$row][$col] = $num;
                    if (self::solve($grid, $length)) {
                        return true;
                    } else {
                        $grid[$row][$col] = 0;
                        $this->grid[$row][$col] = 0;
                    }
                }
            }
            return false;
        }

        private function isSafe(array $grid, int $row, int $col, int $num): bool {
            for ($i = 0; $i < sizeof($grid); $i++) {
                if ($grid[$row][$i] == $num) {
                    return false;
                }
            }
            for ($i = 0; $i < sizeof($grid); $i++) {
                if ($grid[$i][$col] == $num) {
                    return false;
                }
            }
            $sqrt = sqrt(sizeof($grid));
            $boxRowStart = $row - $row % $sqrt;
            $boxColStart = $col - $col % $sqrt;
            for ($i = $boxRowStart; $i < $boxRowStart + $sqrt; $i++) {
                for ($j = $boxColStart; $j < $boxColStart + $sqrt; $j++) {
                    if ($grid[$i][$j] == $num) {
                        return false;
                    }
                }
            }
            return true;
        }

        public function print() {
            $length = sizeof($this->grid);
            for ($i = 0; $i < $length; $i++) {
                for ($j = 0; $j < $length; $j++) {
                    setFlashSudoku($this->grid[$i][$j], $i, $j);
                }
            }
        }

        public function printDebug() {
//            $length = sizeof($this->grid);
//            for ($i = 0; $i < $length; $i++) {
//                for ($j = 0; $j < $length; $j++) {
//                    echo $this->grid[$i][$j] . " ";
//                }
//                echo "<br>";
//                if (($i + 1) % (int)sqrt($length) == 0) {
//                    echo "";
//                }
//            }
//            echo "<br>";
        }
    }
