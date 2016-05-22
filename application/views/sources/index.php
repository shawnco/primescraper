<?php

/**
 * Main page for the sources section
 * 
 * @author Shawn Contant <shawnc366@gmail.com>
 */
?>

<div class='row'>
    <div class='col-sm-2'>Source Domain</div>
    <div class='col-sm-2'>Source Type</div>
    <div class='col-sm-2'>Preference</div>
    <div class='col-sm-2'>Actions</div>
</div>

<ul id='source_list'>
    <?php
    if(!$sources){
        echo 'There are currently no video sources.';
    }else{
        foreach($sources as $s){
            echo "<li><div class='row'>";
            echo "<div class='col-sm-2 list_name'><span class='data'>" . $s['domain'] . "</span><input class='border form-control form_name' value='" . $s['domain']  . "' /></div>";
            echo "<div class='col-sm-2 list_type'><span class='data'>" . $s['type'] . "</span><input class='border form-control form_type' value='" . $s['type'] . "' /></div>";
            echo "<div class='col-sm-2 list_preference'>" . $s['preference'] . "</div>";
            echo "<div class='col-sm-2 list_actions'><i class='fa fa-pencil-square-o' aria-hidden='true'></i><i class='fa fa-trash-o' aria-hidden='true'></i></div>";
            echo "</div></li>";
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