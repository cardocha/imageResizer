<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('ImageResizer.php');

$url = parse_url('/imageResizer/',PHP_URL_PATH);
$abs_path = $_SERVER['DOCUMENT_ROOT'] . $url;
$folders = array($abs_path.'images/');
foreach ($folders as $folder) {
    ImageResizer::batch_resize($folder);
}

