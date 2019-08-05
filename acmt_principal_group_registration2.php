<?php

function acmt_principal_group2()
{
    if(!is_user_logged_in()) {
        wp_redirect(site_url('/choose-your-registration-type/'));
    }
    
    registrationConfirmation();

    include('templates/group_participants/acmt_principal_group_registration_form2.php');
}
add_shortcode('acmt_principal_group_shortcode2', 'acmt_principal_group2');



add_action('init', 'acmt_principal_group_register2');

function acmt_principal_group_register2()
{
    if (isset($_POST['acmt_principal_group_register2'])){


        $current_user =  wp_get_current_user();
        // echo "Register".$register_user."<br/> User";
        if($current_user) {
            // wp_redirect(site_url('/choose-your-registration-type'));
        }
        // print_r($current_user);
        // $user_id = get_user_by('id', $current_user);
        $user_id = $current_user->ID;
        $user_email = $current_user->user_login;

        // echo $user_id;
        // echo $user_email;


        // Get surrent user_id, user_email
        $mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: ({$mysqli->connect_errno}) {$mysqli->connect_error}";
        }

        global $wpdb;
        $values = array();
        $place_holders = array();
        $now = Date('Y:d:m');

        $phone = $_POST['phone'].",".$_POST['phone2'].",".$_POST['phone3'];

        // print_r($phone);
        // exit;
        $group_race = $_POST['group_race'];
        $amount = $_POST['amount'];

        // echo $group_race;
        // echo $phone;


        $table = "wp_accessbank_test";
        // echo "<h1>".count($_POST['data'], 0)."</h1>";
        $query = "INSERT INTO `wp_accessbank_test` (`id`, `user_id`,`family_name`,`Given_name`,`Prefered_name`,`phone`, `reference_id`, `payment_status`,`group_amount`,`group_email`,`group_race`, `date`,`group_family`) VALUES";

        $format =  "('%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'),";
        // print_r($_POST);
        // Go over each array item and append it to the SQL query
        foreach($_POST['data'] as $data) {
            $query .= sprintf(
                $format,
                $mysqli->escape_string(''),
                $mysqli->escape_string($user_id),
                $mysqli->escape_string($data['last_name']),
                $mysqli->escape_string($data['first_name']),
                $mysqli->escape_string($data['display_name']),
                $mysqli->escape_string($phone),
                $mysqli->escape_string(''),
                $mysqli->escape_string('pending'),
                $mysqli->escape_string($amount),
                $mysqli->escape_string($user_email),
                $mysqli->escape_string($group_race),
                $mysqli->escape_string($now),
                $mysqli->escape_string('group')
            );
        }
// echo $query;
        // The last VALUES tuple has a trailing comma which will cause
        // problems, so let us remove it
        $query = rtrim($query, ',');
        // MySQLi::query returns boolean for INSERT
        $result = $mysqli->query($query);

        // echo $result;

        // Find out what happened
        if ($result == false) {
            die("The query did not work: {$mysqli->error}");
        } else {

            wp_redirect(site_url('group-race/ '));
            
            exit;
        }
        
    }
}
?>