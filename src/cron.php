<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'functions.php';

function getRandomXkcdComicHtml() {
    $latest = json_decode(file_get_contents("https://xkcd.com/info.0.json"), true);
    $latestId = $latest['num'];

    $randomId = rand(1, $latestId);
    $comic = json_decode(file_get_contents("https://xkcd.com/$randomId/info.0.json"), true);

    $title = $comic['title'];
    $img = $comic['img'];
    $alt = $comic['alt'];

    return "
        <h2>{$title}</h2>
        <img src='{$img}' alt='{$alt}' style='max-width:600px;'>
        <p><i>{$alt}</i></p>
        <hr>
        <p>If you want to unsubscribe, <a href='http://localhost/xkcd_project/src/unsubscribe.php'>click here</a>.</p>
    ";
}

$subscribers = file("subscribers.txt", FILE_IGNORE_NEW_LINES);
$comicHtml = getRandomXkcdComicHtml();

foreach ($subscribers as $email) {
    sendEmail($email, "Your Daily XKCD Comic!", $comicHtml);
}
