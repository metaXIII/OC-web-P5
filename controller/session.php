<?php

    use metaxiii\sudokuSolver\UserDAO;

    session_start();

    if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = md5(time() + rand());
    }

    function flash() {
        if (isset($_SESSION['Flash'])) {
            extract($_SESSION['Flash']);
            unset($_SESSION['Flash']);
            return "<div class='col-10 m-auto alert alert-$type'>$message</div>";
        }
    }

    function setFlash($message, $type = 'success') {
        $_SESSION['Flash']['message'] = $message;
        $_SESSION['Flash']['type'] = $type;
    }

    function userIsConnected() {
        return isset($_SESSION['Auth']) && $_SESSION['Auth'];
    }

    function checkPostUser($data = null) {
        if (isset($_POST) && !empty($_POST)) {
            checkCSRF();
            foreach ($_POST as $key => $value) {
                $_POST[$key] = strip_tags(htmlspecialchars($value));
            }
            $user = new UserDAO();
            if (!empty($data)) {
                $exist = $user->exist($_POST);
                if ($exist) {
                    setFlash("L'username existe déjà", "danger");
                } else {
                    $user->create($_POST);
                }
            } else {
                $user->get($_POST);
            }
        }
    }

    function signIn(array $data = null) {
        checkPostUser($data);
    }

    function isAdmin($data) {
        if ((int)$data == 1) {
            return true;
        }
        return false;
    }

    function showScore($message) {
        setFlash("Bravo votre score est de " . $message, "success");
    }

    function csrfInput() {
        return "<input type='hidden' value='" . $_SESSION['csrf'] . "' name='csrf'>";
    }


    function checkCSRF() {
        if (isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf']) {
            return true;
        }
        header("location: " . ROOT);
        die();
    }
