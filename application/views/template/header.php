<?php

/**
 * Basic header for PrimeScraper
 */
?>

<!DOCTYPE html> 
<html>
<head>
    <title><?php echo $title; ?></title>
    <?php
        foreach($css as $c){
            echo "<link rel='stylesheet' type='text/css' href='" . $c . "' />";
        }
    ?>
</head>
<body>
    <div id='header'>
        <h1><?php echo $title; ?></h1>
        <ul id='nav'>
            <li><a href='watch'>Watch</a></li>
            <li><a href='series'>Series</a></li>
            <li><a href='sources'>Sources</a></li>
        </ul>
    </div>
    <div class='container'>
        <div id='message'></div>