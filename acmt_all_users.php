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


    $i = 1;

global $wpdb;
 $sql = "SELECT u1.id, u1.display_name, u1.user_registered, u1.user_email AS user_email, m1.meta_value AS acmt_bio FROM wp_users u1
    JOIN wp_usermeta m1 ON (m1.user_id = u1.id AND m1.meta_key = 'acmt_bio')
    WHERE u1.user_login != 'administrator' AND u1.user_login != 'nilayosport' AND u1.user_email != 'info@lagoscitymarathon.com'
    ORDER BY u1.user_registered DESC";

$result = $wpdb->get_results($sql);

$result = json_encode($result);
$result = json_decode($result,true);

    // if($result) {
    //     foreach ($result as $res) {
    //         $name = $res['display_name'];
    //         $email = $res['user_email'];

    //         $record[] = array($name, $email);
    //     }
    // }

     
    ?>

<form class="form-horizontal" action="" enctype="multipart/form-data" method="post">
    <button class="btn btn-primary" type="submit" name="Export">Download CSV</button>
</form>


<table id="example" class="display nowrap">
     <thead>
         <tr>
         <th>SN</th><th>Names</th> <th>Email</th><th>Phone</th><th>Date</th>
     </tr>
     </thead>
    <?php
    if($result){
        foreach ($result as $res) { ?>
            <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $res['display_name']; ?></td>
            <td><?php echo $res['user_email']; ?></td>
            <td><?php if(isset(unserialize($res['acmt_bio'])['phone'])) {
                echo unserialize($res['acmt_bio'])['phone'];
                }  ?></td>
            <!-- <td><?php 
            
            ?></td> -->
            <!-- <td><?php 
            if(isset(unserialize($res['acmt_bio'])['phone'])) {
                echo unserialize($res['acmt_bio'])['nationality']; 
                } 
            ?></td> -->
            <td><?php echo esc_html($res['user_registered'] ); ?></td>  </tr>  
            <?php //$user_arr[] = $res['display_name'].",".$res['user_email'].",".unserialize($res['acmt_bio'])['phone']; ?>
            <?php 
                                
             ?> 
       <?php $i++; }
    }

 ?>
</table>

<hr/>


<script type="text/javascript">
    jQuery.noConflict();

    jQuery(document).ready(function($) {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

//     jQuery(document).ready(function($) {

//     $('#example').DataTable( {
//         dom: 'Bfrtip',
//          buttons: [
//         {
//             extend: 'csv',
//             text: 'Copy all data',
//             exportOptions: {
//                 modifier: {
//                     search: 'none'
//                 }
//             }
//         }
//     ]
//     } );
// } );

</script>
<?php
}
add_shortcode('acmt_all_users_shortcode', 'acmt_all_users_shortcode');
?>