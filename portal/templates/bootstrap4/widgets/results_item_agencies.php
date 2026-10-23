<?php
$col_sm = '4';
if(isset($columns) && $columns == 3)
{
    $col_sm = '4';
}

if(isset($columns) && $columns == 4)
{
    $col_sm = '3';
}
if(isset($columns) && $columns == 2)
{
    $col_sm = '6';
}

if(isset($columns) && $columns == 12)
{
    $col_sm = '12';
}
$class='';
if(isset($custom_class) && !empty($custom_class))
{
    $class = $custom_class;
} else {
    $class = 'col-lg-'.$col_sm;
}
?>

<div class="<?php echo $class;?>">
    <a href="<?php  _che($item['agent_url']);?>" class="agencies-card">
        <div class="card mx-auto">
            <div class="card-image">
                <img src="<?php echo _simg($item['image_url'], '90x90'); ?>" alt="<?php  _che($item['name_surname']);?>" class="card-img-top">
            </div>
            <div class="card-body">
                <div class="card-text"><?php  _che($item['name_surname']);?></div>
                <div class="address"><?php  _che($item['address']);?></div>
            </div>
        </div>
    </a>
</div>