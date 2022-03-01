<?php

    namespace metaxiii\sudokuSolver;


    class sudoku {
        private $gridToSave = array();
        private $grid_start = array();
        private $column_start = array();
        private $grille = array();
        private $time = array();
        private $canBeSolve = true;
        private $protection = true;
        protected $db;

        public function __construct() {
            $this->db = Database::getPdo();
            $this->time['start'] = microtime(true);
        }

        private function setGrid() {
            $grille = array();
            foreach ($this->grid_start as $key => $row) {
                if ($key <= 2) {
                    $row_number = 1;
                }
                if ($key > 2 && $key <= 5) {
                    $row_number = 2;
                }
                if ($key > 5 && $key <= 8) {
                    $row_number = 3;
                }
                foreach ($row as $column => $value) {
                    if ($column <= 2) {
                        $col_num = 1;
                    }
                    if ($column > 2 && $column <= 5) {
                        $col_num = 2;
                    }
                    if ($column > 5 && $column <= 8) {
                        $col_num = 3;
                    }
                    $grille[$row_number][$col_num][] = $value;
                }
            }
            $this->grille = $grille;
        }

        private function setColumns() {
            $column_start = array();
            $i = 1;
            foreach ($this->grid_start as $key => $row) {
                $j = 1;
                foreach ($row as $kk => $value) {
                    $column_start[$j][$i] = $value;
                    $j++;
                }
                $i++;
            }
            $this->column_start = $column_start;
        }

        private function getPossibilities($rows, $column) {
            $values = array();
            if ($rows <= 2) {
                $row_number = 1;
            }
            if ($rows > 2 && $rows <= 5) {
                $row_number = 2;
            }
            if ($rows > 5 && $rows <= 8) {
                $row_number = 3;
            }
            if ($column <= 2) {
                $col_num = 1;
            }
            if ($column > 2 && $column <= 5) {
                $col_num = 2;
            }
            if ($column > 5 && $column <= 8) {
                $col_num = 3;
            }
            for ($n = 1; $n <= 9; $n++) {
                if (!in_array($n, $this->grid_start[$rows])
                    && !in_array($n, $this->column_start[$column + 1])
                    && !in_array($n, $this->grille[$row_number][$col_num])) {
                    $values[] = $n;
                }
                if (empty($values)) {
                    if (!in_array($n, $this->grid_start[$rows])
                        && !in_array($n, $this->grille[$row_number][$col_num])) {
                        $values[] = $n;
                    }
                }
            }
            return $values;
        }

        public function solve($array) {
            if ($this->protection) {
                $this->gridToSave = $array;
                $this->protection = false;
            }
            while (true) {
                $this->grid_start = $array;
                $this->setColumns();
                $this->setGrid();
                $replace_values = array();
                foreach ($array as $key => $row) {
                    foreach ($row as $column => $value) {
                        if ($value == 0) {
                            $possible_values = $this->getPossibilities($key, $column);
                            $replace_values[] = array(
                                'row' => $key,
                                'column' => $column,
                                'possibleValues' => $possible_values
                            );
                        }
                    }
                }
                if (empty($replace_values)) {
                    return $array;
                }
                usort($replace_values, array($this, 'Alea'));
                if (count($replace_values[0]['possibleValues']) == 1) {
                    $array[$replace_values[0]['row']][$replace_values[0]['column']] = current($replace_values[0]['possibleValues']);
                    continue;
                }
                foreach ($replace_values[0]['possibleValues'] as $value) {
                    $tmp = $array;
                    $tmp[$replace_values[0]['row']][$replace_values[0]['column']] = $value;
                    if ($result = $this->solve($tmp)) {
                        return $this->solve($tmp);
                    }
                }
                return false;
            }
            return false;
        }

        private function Alea($a, $b) {
            $a = count($a['possibleValues']);
            $b = count($b['possibleValues']);
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        }

        public function getResult() {
            foreach ($this->grid_start as $key => $row) {
                foreach ($row as $colonne => $value) {
                    echo $value . ' ';
                }
                echo "<br>";
            }
        }

        public function getResultDebug() {
            foreach ($this->grid_start as $key => $row) {
                foreach ($row as $position => $value) {
                    if ($value == 0) {
                        $this->canBeSolve = false;
                    }
                    setFlashSudoku($value, $key, $position);
                }
            }
        }

        public function __destruct() {
            $this->time['end'] = microtime(true);
            $time = $this->time['end'] - $this->time['start'];
            showScore(number_format($time, 4) . " sec");
            setFlashsudokuTime("Temps d\'exécution : " . number_format($time, 4) . " sec");
            if ($this->canBeSolve && isset($_SESSION['Auth']) && isAdmin($_SESSION['Auth'])) {
                $toData = serialize($this->gridToSave);
                $query = $this->db->prepare("SELECT * from grid WHERE grid_content = :toData");
                $query->bindValue(':toData', $toData, \PDO::PARAM_STR);
                $query->execute();
                if ($query->rowCount()) {
                    return;
                } else {
                    $query = $this->db->prepare("INSERT INTO grid (grid_content) VALUES (:array)");
                    $query->bindValue(':array', $toData, \PDO::PARAM_STR);
                    $query->execute();
                }
            }
        }
    }
