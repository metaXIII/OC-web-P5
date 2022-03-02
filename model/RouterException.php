<?php

    namespace metaxiii\sudokuSolver;


    use Throwable;

    class RouterException extends \Exception {
        private static $error = false;

        public function __construct(string $message = "", int $code = 0, Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
            header('location:' . ROOT . 'error');
            $this->show($message);
            $this->error = true;
        }


        private function show($message) {
            echo "<div class='alert alert-primary m-auto col-8'>";
            echo "<span>$message</span>";
            echo "</div>";
        }


        public static function isError() {
            return self::$error;
        }
    }
