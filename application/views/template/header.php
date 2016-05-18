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
    <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/js/bootstrap/css/bootstrap.min.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/js/jquery-ui/jquery-ui.min.css' />
</head>
<body>
    <div id='header'>
        <h1>Primescraper</h1>
        <ul id='nav'>
            <li><a href='watch'>Watch</a></li>
            <li><a href='series'>Series</a></li>
            <li><a href='sources'>Sources</a></li>
        </ul>
    </div>
    <div class='container'>
        <div class='content'>
            <div class='row'>
                <div id='message'></div>
                <div id='location'></div>
            </div>