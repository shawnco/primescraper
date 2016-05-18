<?php

/**
 * This page holds the form for the series selector
 */

$data = array(
    'class' => 'form-horizontal'
);
echo form_open('', $data);

?>

<div class='form-group'>
<?php
$data = array(
    'class' => 'col-sm-2 control-label'
);
echo form_label('Series URL: ', 'url_holder', $data);
?>
    <div class='col-sm-3'>
<?php
$data = array(
    'id' => 'url_holder',
    'name' => 'url_holder',
    'class' => 'form-control border',
    'value' => $series
);
echo form_input($data);
?>
    </div>
    <div class='col-sm-2'>
<?php

$data['id'] = $data['name'] = 'search_series';
$data['class'] .= ' btn btn-primary';
$data['content'] = 'Search series';
echo form_button($data);

?>
    </div>
</div>

<div id='results'></div>

<?php 
echo form_close();

?>
