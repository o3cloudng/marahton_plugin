<?php

function acmt_all_users_shortcode()
{
    $user = wp_get_current_user();
    $allowed_roles = array('editor', 'administrator', 'author');
    if( !array_intersect($allowed_roles, $user->roles ) ) {
       wp_redirect(site_url('/'));
    }
    $args = array(
        'role'    => 'subscriber'
        // 'orderby' => 'user_nicename',
        // 'order'   => 'ASC'
    );
    $users = get_users( $args );


    ?>
    <!-- <table id="example" class="display nowrap">
     <thead>
         <tr>
         <th>SN</th><th>First Name</th> <th>Last Name</th> <th>Email</th><th>Date</th>
     </tr>
     </thead>  -->
    <?php 
    

    $i = 1;
   // foreach ( $users as $user ) { ?>
        <!-- <tr>
            <td><?php echo $i; ?></td>
            <td><a href="<?php echo site_url('/'); ?>user-profile-page?user_id=<?php echo esc_html( $user->ID); ?>"><?php echo esc_html( $user->first_name ); ?></a></td>
            <td><a href="<?php echo site_url('/'); ?>user-profile-page?user_id=<?php echo esc_html( $user->ID); ?>"><?php echo esc_html( $user->last_name ); ?></a></td>
            <td><a href="<?php echo site_url('/'); ?>user-profile-page?user_id=<?php echo esc_html( $user->ID); ?>"><?php echo esc_html( $user->user_email ); ?></a></td>
            <td><a href="<?php echo site_url('/'); ?>user-profile-page?user_id=<?php echo esc_html( $user->ID); ?>"><?php echo esc_html( $user->user_registered ); ?></a></td>
        </tr> -->
   <?php //$i++; }   ?>
<!-- </table> -->


<?php
global $wpdb;
 $sql = "SELECT u1.id, u1.display_name, u1.user_registered, u1.user_email AS user_email, m1.meta_value AS acmt_bio FROM wp_users u1
    JOIN wp_usermeta m1 ON (m1.user_id = u1.id AND m1.meta_key = 'acmt_bio')
    WHERE u1.user_login != 'administrator' AND u1.user_login != 'nilayosport' AND u1.user_email != 'info@lagoscitymarathon.com'
    ORDER BY u1.user_registered DESC";

$result = $wpdb->get_results($sql);

$result = json_encode($result);
$result = json_decode($result,true);
// print_r($result); ?>

<table id="example" class="display nowrap">
     <thead>
         <tr>
         <th>SN</th><th>Names</th> <th>Email</th><th>Date</th>
     </tr>
     </thead>
    <?php
    if($result){
        foreach ($result as $res) { ?>
            <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $res['display_name']; ?></td>
            <td><?php echo $res['user_email']; ?></td>
            <!-- <td><?php 
            if(isset(unserialize($res['acmt_bio'])['phone'])) {
                echo unserialize($res['acmt_bio'])['phone'];
                } 
            ?></td> -->
            <!-- <td><?php 
            if(isset(unserialize($res['acmt_bio'])['phone'])) {
                echo unserialize($res['acmt_bio'])['nationality']; 
                } 
            ?></td> -->
            <td><?php echo esc_html( $res['user_registered'] ); ?></td>  </tr>       
       <?php $i++; }
    }
 ?>
</table>

<?php
// maybe_unserialize( $original )
?>
<hr/>
<?php
// $mydata = 'a:10:{s:6:"height";s:3:"150";s:6:"weight";s:3:"100";s:5:"phone";s:14:"+2348056723456";s:6:"gender";s:1:"M";s:7:"country";s:7:"Nigeria";s:11:"nationality";s:7:"Nigeria";s:7:"contact";s:0:"";s:7:"address";s:12:"Ojota, Lagos";s:3:"dob";s:10:"06/18/2019";s:10:"disability";s:0:"";}';
// // $mydata = unserialize($mydata);

// // $mydata = 'a:5:{s:9:"engine_id";a:1:{i:0;s:9:"300000225";}s:15:"transmission_id";a:1:{i:0;s:6:"257691";}s:5:"plant";a:1:{i:0;s:23:"Oshawa, Ontario, Canada";}s:15:"Manufactured in";a:1:{i:0;s:6:"CANADA";}s:22:"Production Seq. Number";a:1:{i:0;s:6:"151411";}}';
// $mydata = unserialize($mydata);
// echo "<pre>";
// print_r($mydata);
// echo "</pre>";
// echo $mydata['nationality'];
?>


<script type="text/javascript">
    jQuery.noConflict();
    jQuery(document).ready(function($) {

    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
        {
            extend: 'copy',
            text: 'Copy to clipboard'
        },
        'excel',
        'pdf'
    ]
    } );
} );
</script>
<?php
}
add_shortcode('acmt_all_users_shortcode', 'acmt_all_users_shortcode');
?>