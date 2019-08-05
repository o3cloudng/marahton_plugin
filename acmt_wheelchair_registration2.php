<?php

function acmt_wheelchair_registration_shortcode2()
{
    if(!is_user_logged_in()) {
        // wp_redirect(site_url('choose-your-registration-type/'));
    }
    // registrationConfirmation();

    
    include('templates/wheelchair/wheelchair_registration_details.php');
}
add_shortcode('acmt_wheelchair_registration_shortcode2', 'acmt_wheelchair_registration_shortcode2');



add_action('init', 'acmt_wheelchair_registration2');

function acmt_wheelchair_registration2()
{
    if (isset($_POST['acmt_wheelchair_registration2'])) {
        // global $register_user;
        $current_user =  wp_get_current_user();
        // print_r($current_user);
        // exit;

        $userdata = array(
            'height' => esc_attr($_POST['height']),
            'weight' => esc_attr($_POST['weight']),
            'dob' => esc_attr($_POST['dob']),
            'race' => esc_attr($_POST['race_type']),
            'phone' => esc_attr($_POST['phone']),
            'gender' => esc_attr($_POST['gender']),
            'country' => esc_attr($_POST['country']),
            'nationality' => esc_attr($_POST['nationality']),
            'contact' => esc_attr($_POST['contact']),
            'address' => esc_attr($_POST['address']),
            'disability' => "Wheelchair",
            'reference' => "",
            'status' => "Completed"
        );

        // echo "Register".$register_user."<br/> User";
        if(!$current_user) {
            wp_redirect(site_url('my-account'));
        }

        $user = get_user_by('id', $current_user->ID);


        $user = update_user_meta($current_user->ID, "acmt_bio", $userdata);

        if ($user) {

            wp_redirect(site_url('no-payment'));
            exit;
        } else {
            echo "Error on submission -- (User details)";
        }
    }
}
?>