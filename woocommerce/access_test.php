<?php
/**
 * Plugin Name: Access Bank Marathon
 * Description: e-Bib generation for Lagos City Marathon organized by Access Bank plc.
 * 
 */
/// Test function to submit form
function DisplayCustomSettingsForm_shortcode() {
    global $post;

    if( !is_user_logged_in() ){
        echo '<div class="lwCSForm-notloggedin">
                <p> Please login to view the content! </p>
              </div>';
        return;
    }


    ?><br />
        <!-- LwCSForm Plugin-->
        <section id="lwCSForm-wrapper">
            <form name="lwCSForm" id="lwCSForm" method="post" action="" autocomplete="on">
                Name: <input type="text" name="realname" placeholder="Your Name" >
                Sitename: <input type="text" name="username" placeholder="Username" >
                E-mail: <input type="text" name="email" placeholder="E-mail" >
                Avatar: <input type="text" name="avatar" placeholder="Avatar" >
                <input name='WCSPostSubmitButton' type="submit" >
            </form>
        </section>
        <!-- END LwCSForm Plugin-->
    <br /> <?php

}
add_shortcode( 'lwCSForm', 'DisplayCustomSettingsForm_shortcode');

add_action( 'init', 'WCSGetPostData' );
function WCSGetPostData() {
    if ( isset( $_POST['WCSPostSubmitButton'] ) ) {
        // dump out the POST data
        var_dump($_POST);

    }
}


?>