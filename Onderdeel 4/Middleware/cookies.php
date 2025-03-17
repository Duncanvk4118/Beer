<?php

function setCookies($value) {
    $cookie_name = "cookie_id";
    $cookie_value = $value ?? null;

    if (!isset($_COOKIE[$cookie_name])) {
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
    }
}