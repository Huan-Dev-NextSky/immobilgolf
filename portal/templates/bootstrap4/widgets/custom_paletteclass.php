<?php
if(!empty($settings_design_parameters))
{
    echo str_replace('full-width ', '', $settings_design_parameters);
}
else
{
    echo '<!-- .full-width .boxed-->';
}
?>