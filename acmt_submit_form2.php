<?php

function accessbank_registration2()
{

    if(!is_user_logged_in()) {
        wp_redirect(site_url('choose-your-registration-type/'));
    }
    registrationConfirmation();
    
    include('templates/registrationForm2.php');
}
add_shortcode('access_registration_2', 'accessbank_registration2');



add_action('init', 'acmt_submit_form2');

function acmt_submit_form2()
{
    if (isset($_POST['acmt_register2'])) {
        global $register_user;

        $userdata = array(
            'height' => esc_attr($_POST['height']),
            'weight' => esc_attr($_POST['weight']),
            'phone' => esc_attr($_POST['phone']),
            'gender' => esc_attr($_POST['gender']),
            'country' => esc_attr($_POST['country']),
            'nationality' => esc_attr($_POST['nationality']),
            'contact' => esc_attr($_POST['contact']),
            'dob' => esc_attr($_POST['dob']),
            'address' => esc_attr($_POST['address']),
            'disability' => esc_attr($_POST['disability']),
            'race' => esc_attr($_POST['race'])
        );

        $current_user =  wp_get_current_user();
        // echo "Register".$register_user."<br/> User";
        if(!$current_user) {
            wp_redirect(site_url('race'));
        }

        $user = get_user_by('id', $current_user);

        // print_r($current_user);

        $user = add_user_meta($current_user->ID, "acmt_bio", $userdata);

        if ($user) {

            wp_redirect(site_url('payment'));
            exit;
        } else {
            echo "Error on submission";
        }
    }
}
?>