<?php

/**
 * This page holds the form for the series selector
 */

echo form_open();

echo form_label('Series URL: ', 'url_holder');
$data = array(
    'id' => 'url_holder',
    'name' => 'url_holder',
    'class' => 'form-control border',
    'value' => $series
);
echo form_input($data);

$data['id'] = $data['name'] = 'search_series';
$data['content'] = 'Search series';
echo form_button($data);

?>

<div id='results'></div>

<?php 
echo form_close();

?>
