<?php
/**
 * Plugin Name: Access Bank Marathon
 * Description: e-Bib generation for Access Bank Lagos City Marathon.
 *
 */

// Claculate Total sales made
function total_amount($type, $reg_count){
    if ($type == "single") {
        $result = $reg_count * 5000;
        return $result;
    }
    if ($type == "group") {
        $result = $reg_count / 5 * 20000;
        return $result;
    }
    if ($type == "family") {
        $result = ($reg_count / 4) * 15000;
        return $result;
    }
}
function ebibUrl(){
    $host =  $_SERVER['HTTP_HOST'];
    if ($host == "localhost") {
        // Local
        $url = "http://5.101.138.142:8980/api/barcode/";
        return $url;
    } else {
        // Live
        $url = "http://192.168.1.142:8980/api/barcode/";
        return $url;
    }
    // Live
    // $url = "http://192.168.1.142:8980/api/barcode/";
    // Test
    // $url = "http://5.101.138.142:8980/api/barcode/";
    // return $url;    
}

// echo ebibUrl();

function getRegisteredUsers($type) {

    $url = ebibUrl()."".$type;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_TIMEOUT, 80);
     
    $response = curl_exec($curl);

    if(curl_error($curl)){
        echo 'Request Error:' . curl_error($curl);
    } else {
        return $response;        
    }
}


//  Check if single user already exists
function checkSingleUserReg($userID) {

  $user_bio = get_user_meta($userID, $user);

  return $user_bio['acmt_bio'];
}
// Check if group user exists
function checkGroupUserReg($userID) {
    global $wpdb;
  $checkGroupUserRegExist = $wpdb->get_results( "SELECT user_id FROM `wp_accessbank_test` WHERE `user_id`={$userID}" );

  return $checkGroupUserRegExist;
}
// Check if group user exists
function familyorgroup($userID) {
    global $wpdb;
  $group = $wpdb->get_results( "SELECT `group_family` FROM `wp_accessbank_test` WHERE `user_id`={$userID}", ARRAY_A );

  return $group;
}

function checkEbibPayment($userID) {
    global $wpdb;
    // $paymentStatus = $wpdb->get_user_meta($userID);
    $paymentStatus = $wpdb->get_results( "SELECT `meta_key` FROM `wp_usermeta` WHERE `user_id`={$userID}  && `meta_key` LIKE 'acmt_tx_%'", ARRAY_A);

  return $paymentStatus;

}

function checkPaidUser($user_id) {
    $bio = "acmt_bio";
    $data = get_user_meta($user_id, $bio);
    return $data;
}

// function checkGroupEbibPayment() {

// }


function registrationConfirmation(){

    $current_user =  wp_get_current_user();

    // Check if user has already registered
     if(!empty(checkSingleUserReg($current_user->ID))){
        wp_redirect(site_url('payment'));
     }

     // echo familyorgroup($current_user->ID);
     if(!empty(familyorgroup($current_user->ID))){
        $group = (array)familyorgroup($current_user->ID); 
        if ($group[0]['group_family'] == 'group') {
            wp_redirect(site_url('group-race'));
        }
        if ($group[0]['group_family'] == 'family'){
            wp_redirect(site_url('family-payment'));
        }
     }
}

/// Test function to submit form

function serializeMetaArray(&$arr)
{
    return serialize($arr);

    // height;100,weight;50,phone;08034206970
}

function deserializeMetaArray(&$str)
{


    if (is_serialized($str)){
        return unserialize($str);
    }

    return [];
}

function registration_form_validation($email,$first_name,$last_name,$password) {
    global $reg_errors;
    $reg_errors = new WP_Error;
    if ( empty( $first_name ) || empty( $password ) || empty( $email ) || empty( $last_name ) ) {
        $reg_errors->add('field', 'Required form field is missing');
    }
    if ( empty( $first_name ) || empty( $password ) || empty( $email ) ) {
        $reg_errors->add('field', 'Required form field is missing');
    }
    if ( !is_email( $email ) ) {
        $reg_errors->add( 'email_invalid', 'Email is not valid' );
    }
    if ( email_exists( $email ) ) {
        $reg_errors->add( 'email', 'Email Already in use' );
    }
    if ( is_wp_error( $reg_errors ) ) {

        foreach ( $reg_errors->get_error_messages() as $error ) {

            echo '<div>';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';

        }

    }
}

// PIncludes
include('acmt_transactions.php');

include('acmt_submit_form1.php');

include('acmt_submit_form2.php');

include('acmt_get_ebib.php');

include('acmt_get_ebib_group.php');

include('acmt_get_ebib_family.php');

include('acmt_group_register.php');

include('acmt_registered_users_process.php');

include('acmt_select_participant.php');

include('acmt_group_register_submit.php');

include('acmt_principal_group_registration1.php');

include('acmt_principal_group_registration2.php');

include('acmt_principal_group_registration3.php');


include('acmt_family_registration1.php');

include('acmt_family_registration2.php');

include('acmt_family_registration3.php');

include('acmt_profile.php');

include('acmt_user_profile_page.php');

include('acmt_thank_you.php');

include('acmt_registered_single.php');

include('acmt_registered_groups.php');

include('acmt_complete_registered_users.php');

include('acmt_all_users.php');

include('acmt_reg_single_users.php');

include('acmt_reg_group_users.php');

include('acmt_reg_family_users.php');

include('acmt_wheelchair_registration.php');

include('acmt_wheelchair_registration2.php');

include('acmt_no_payment_receipt.php');

include('acmt_get_ebib_wheelchair.php');

include('acmt_regenerate_ebib.php');

include('acmt_generate_ebib.php');
// include('woocommerce/my-account.php');
// include('acmt_payment_receipt.php');


function accessbank_menu_option()
{
    // add_menu_page('Title of Function Page', 'Menu name', 'User access role', 'slog', 'callback function', 'image-icon', 200);

    add_menu_page('Header & Footer Script', 'Access Marathon', 'manage_options', 'accessbank-admin-menu', 'accessbank_scripts_page', '', 200);
}

add_action('admin_menu', 'accessbank_menu_option');

function accessbank_scripts_page()
{
    include('templates/accessbank_admin.php');
}

// Adding Bootstrap Validation for form validation


function wpb_adding_scripts() {

        wp_register_script('custom_script', plugins_url('js/custom_script.js', __FILE__), array('jquery'),'1.1', true);

        wp_enqueue_script('custom_script');

        wp_register_style('accessbank_style', plugins_url('css/accessbank_style.css', __FILE__));
        wp_enqueue_style('accessbank_style');

    //     add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' );

    // wp_register_script('bootstrap_select_script', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js');
    // wp_enqueue_script('bootstrap_select_script');

    // wp_register_style('bootstrap_select_style', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css');
    // wp_enqueue_style('bootstrap_select_style');
}
add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' );  // End of Javascript
/*
*   Woocommerce account page menu editing
*/

include('woocommerce/my-account.php');
?>
