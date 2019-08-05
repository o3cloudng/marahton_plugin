<?php
 /**
  * Edit my account menu order
  */

  function my_account_menu_order() {
    $menuOrder = array(
        'dashboard'          => __( 'Dashboard', 'woocommerce' ),
        'edit-account'    	=> __( 'Account Details', 'woocommerce' ),
        // 'downloads'          => __( 'Download', 'woocommerce' ),
        // 'orders'             => __( 'Orders', 'woocommerce' ),
        // 'edit-address'       => __( 'Addresses', 'woocommerce' ),
        // 'race_2'       => __( 'Basic Info', 'woocommerce' ),
        'customer-logout'    => __( 'Logout', 'woocommerce' ),
    );
    return $menuOrder;
}
add_filter ( 'woocommerce_account_menu_items', 'my_account_menu_order' );




function accessbank_dashboard() {

    printf(
        __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a> and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' ),
        esc_url( wc_get_endpoint_url( 'orders' ) ),
        esc_url( wc_get_endpoint_url( 'edit-address' ) ),
        esc_url( wc_get_endpoint_url( 'edit-account' ) )
    );
    // echo "Dashboard for asccessbank marathon project";
    ?>
    <h2>Dashboard for Access Bank Lagos City Marathon</h2>
  <?php  
    $current_user = wp_get_current_user();
    $email = $current_user->user_email;

    $ch = curl_init();

    global $wpdb;

    $query = "SELECT * FROM `wp_accessbank_test` WHERE user_id = $user_id";
    $results = $wpdb->get_results($query);


    $results_array = (array) $results[0];

    if(isset($results_array['group_family'])) 
    {
        if($results_array['group_family'] == 'group'){
            $url = 'barcode-api.ga/api/barcode/group';
           $type = 'group';
            } else {
            $url = 'barcode-api.ga/api/barcode/group';
            $type = 'family';
            }
    } 
    else 
    {
        $url = 'barcode-api.ga/api/barcode/single';
    }

    $qry_str = "?email=".$email.'&type='.$type;




    // $url = 'barcode-api.ga/api/barcode/single/{email}';
    // $url = 'barcode-api.ga/api/barcode/group/{email}/{type}';
    
    // Set query data here with the URL
    curl_setopt($ch, CURLOPT_URL, 'barcode-api.ga/api/barcode' . $qry_str); 
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $content = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($content);

    if(!empty($result)) {
      // print $content; ?>
      <style type="text/stylesheet">
          a.btn {
            border: 1px solid #bbb;
            border-radius: 3px;
            background: #e6e6e6;
            color: rgb(255, 255, 255);
            font-size: 1.7rem;
            line-height: 1;
            background: #3b3b3b;
            width: 100%;

            padding: 18px;
            border-radius: 0;
            text-transform: capitalize;
            border: none;
          }
          
      </style>
      <div class="container" style="width:800px;">
           <div class="col-xs-12 col-sm-12 col-md-10 offset-md-1">
               <p>Thank you for completing your registration.</p>
           <?php //echo $_SERVER['REMOTE_ADDR']."".$_SERVER['REQUEST_URI']; ?>
       </div>
       <?php
    } else { ?>
    <form method="post" action="">
    <div class="col-md-10">
        <style>
            a.btn {
                border: 1px solid #bbb;
                border-radius: 3px;
                background: #e6e6e6;
                color: rgb(255, 255, 255);
                font-size: 1.5rem;
                line-height: 1;
                background: #3b3b3b;
                width: 100%;
                padding: 10px;
                border-radius: 0;
                text-transform: capitalize;
                border: none;
            }
            
        </style>
            <!-- <a href="<?php echo site_url(); ?>/e-bib" class="btn btn-primary btn-large btn-block" target="_blank"> Generate your BIB</a> -->
        </div>
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>

<?php
    }

echo "<pre>";
    print_r($url);
echo "</pre>";

}
do_action( 'accessbank_dashboard' );
// remove_action('welcome_panel', 'wp_welcome_panel');

// remove_action( 'admin_notices', 'woothemes_updater_notice' );
?>