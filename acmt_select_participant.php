<?php

function acmt_select_participant_shortcode()
{
    include('templates/acmt_select_participant_page.php');
}
add_shortcode('acmt_select_participant', 'acmt_select_participant_shortcode');
?>