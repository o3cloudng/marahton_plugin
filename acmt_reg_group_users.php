<?php

function acmt_reg_group_users_shortcode()
{
    $user = wp_get_current_user();
    $allowed_roles = array('editor', 'administrator');
    if( !array_intersect($allowed_roles, $user->roles ) ) {
       wp_redirect(site_url('/'));
    }
    ?>
    <strong class="display-5">List of All Completed Registrations</strong>
    <table id="myTable" class="table table-bordered table-striped table-hover text-small">
     <thead>
         <tr>
         <th>SN</th><th>Name</th> <th>Type</th> <th>Race</th> <th>Email</th> <th>EBIB</th><th>Date</th>
     </tr>
     </thead> 
    <?php 
    $response = getRegisteredUsers('group');

    $resp = json_decode($response, true);

    // print_r($resp['data']);
    echo "<hr/>";

    if(isset($resp['data']) && count($resp['data']) > 0) {

        $resp = $resp['data'];

        $i=1;
        // echo $i;
        foreach ($resp as $i=>$result) { ?>
            <tr>
            <td><?php echo esc_html($i); ?></td>
            <td><?php echo esc_html( $result['name'] ); ?></td>
            <td><?php echo esc_html( $result['type'] ); ?></td>
            <td><?php echo esc_html( $result['race']."km" ); ?></td>
            <td><?php echo esc_html( $result['email'] ); ?></td>
            <td><?php echo esc_html( $result['ebib'] ); ?></td>
            <td><?php echo esc_html( $result['created_at'] ); ?></td>
           <!--  echo $result['name']."<br/>";
            echo $result['email']."<br/>";
            echo $result['race']."<br/>"; -->
       <?php 
           $i++; 
        }        
    } ?>
</table>
<?php
}
add_shortcode('acmt_reg_group_users_shortcode', 'acmt_reg_group_users_shortcode');
?>