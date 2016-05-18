<?php

/**
 * Main page for the sources section
 * 
 * @author Shawn Contant <shawnc366@gmail.com>
 */
?>

<ul id='source_list'>
    <?php
    if(!$sources){
        echo 'There are currently no video sources.';
    }else{
        foreach($sources as $s){
            echo "<li>";
            echo "<span class='list_name'>" . $s['domain'] . "</span>";
            echo "<span class='list_type'>" . $s['type'] . "</span>";
            echo "<span class='list_preference'>" . $s['preference'] . "</span>";
            echo "</li>";
        }
    }
    ?>
</ul>
<?php
$data = array(
    'class' => 'form-horizontal'
);
echo form_open('', $data);
?>
    <div class='form-group'>
        <div class='col-sm-2'>
<?php
$data = array(
    'id' => 'source_name',
    'name' => 'source_name',
    'class' => 'border form-control',
    'placeholder' => 'Source Name'
);
echo form_input($data);
?>
        </div>
        <div class='col-sm-2'>
<?php
$data['id'] = $data['name'] = 'source_type';
$data['placeholder'] = 'Source Type';
echo form_input($data);
?>
        </div>
        <div class='col-sm-2'>
<?php
$data['id'] = $data['name'] = 'add_button';
$data['class'] .= ' btn btn-primary';
$data['content'] = 'Add Source';
echo form_button($data);
?>
        </div>
    </div>
<?php
echo form_close();
?>