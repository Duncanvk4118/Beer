<?php

function setCookies($value) {
    $cookie_name = "cookie_id";
    $cookie_value = $value ?? null;

    if (is_array($cookie_value)) {
        $cookie_value = json_encode($cookie_value);
    }

    if (!isset($_COOKIE[$cookie_name])) {
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
    }
}
