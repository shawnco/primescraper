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
            echo "<li>" . $s['domain'] . "</li>";
        }
    }
    ?>
</ul>
<?php
echo form_open();
$data = array(
    'id' => 'source_name',
    'name' => 'source_name',
    'class' => 'border form-control',
    'placeholder' => 'Source Name'
);
echo form_input($data);
$data['id'] = $data['name'] = 'source_type';
$data['placeholder'] = 'Source Type';
echo form_input($data);
$data['id'] = $data['name'] = 'add_button';
$data['content'] = 'Add Source';
echo form_button($data);
echo form_close();