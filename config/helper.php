<?php

if (isset($_SERVER['HTTP_HOST'])) {
    $base_url = rtrim((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'], '/') . '/';
} else {
    $base_url = "http://localhost/harda_tehnik/";
}
