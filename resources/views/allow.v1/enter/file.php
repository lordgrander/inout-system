<?php 
$file_url = $_GET['file_url'];
header('Content-Type: ' . mime_content_type($file_url));
readfile($file_url);
?>
