<?php

/*
 * Basic footer for Primescraper
 */
?>
    </div>
    <?php
        foreach($js as $j){
            echo "<script type='text/javascript' src='" . $j . "'></script>";
        }
    ?>
</body>
</html>    