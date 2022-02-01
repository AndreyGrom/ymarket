<?php
session_start();
$token = isset($_SESSION['token']) ? $_SESSION['token'] : '';
$get = $_GET;
$post = $_POST;

// Идентификатор приложения
$client_id = '3a348a4cf9704125a834631f7e77be87';

// Пароль приложения
$client_secret = '5d1bcabff5274384aac11d3c0f796303';
?>