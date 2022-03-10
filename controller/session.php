<?php

    session_start();

    function setFlash($message, $type = 'success') {
        $_SESSION['Flash']['message'] = $message;
        $_SESSION['Flash']['type'] = $type;
    }

    function showScore($message) {
        setFlash("Bravo votre score est de " . $message, "success");
    }
