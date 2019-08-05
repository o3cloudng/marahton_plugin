<?php
add_shortcode('acmt_user_profile_shortcode', 'acmt_user_profile_shortcode');
function acmt_user_profile_shortcode()
{
    $user = wp_get_current_user();
    $allowed_roles = array('editor', 'administrator');
    if( !array_intersect($allowed_roles, $user->roles ) ) {
       wp_redirect(site_url('/'));
    }
    ?>
    <!-- <h1>User Profile Page</h1> -->
    <?php
    $user_id = $_GET['user_id'];
    $key = 'acmt_bio';

    // $user = get_user_by('id', 1);

    // echo $user;
    global $wpdb;

    $query = "SELECT * FROM `wp_users` WHERE ID = $user_id";
    $results = $wpdb->get_row($query);

    // print_r($results);

    ?>
    <table class="table table-bordered table-condensed table-hover">
        <tr>
            <th>Name</th>
            <td><?php echo $results->display_name; ?></td>
        </tr>
        <tr>
            <th>Other Name</th>
            <td><?php echo $results->user_nicename ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $results->user_email; ?></td>
        </tr>
    </table>
    <hr/>
    <h3>Ebib Details</h3>
    <?php
    $query = "SELECT * FROM `wp_accessbank_test` WHERE user_id = $user_id";
    $results = $wpdb->get_results($query);
    $results_array = (array) $results[0];

    // $results_array = explode(";", $results_array);
    // echo '<pre>';
    // print_r($results_array);
    // echo '</pre>';

    foreach($results_array as $data){
        echo $data->Family_name;
    }
    ?>


    <pre>
        <?php //get_user_meta($user_id, $key, 1); 
        $all_meta_for_user = get_user_meta( 32, $key );
        // $all_meta_for_user = is_serialized($all_meta_for_user );
        print_r( $all_meta_for_user );
   ?>
    </pre>
    <!-- GET E-BIB -->

    <!-- <button id="getEbib" class="btn btn-warning" onclick="getEbibData()">Get E-BIB</button>
    <p id="showEbib"></p> -->
 <?php 
    $email = $results->user_email;
    $type = $data->family_group;

    $host =  $_SERVER['HTTP_HOST'];
    if ($host == "localhost") {
        // Local
        $url = "http://5.101.138.142:8980/api/barcode/group/".$email."/".$type;
    } else {
        // Live
        $url = "http://192.168.1.142:8980/api/barcode/group/".$email."/".$type;
    }

    // $email = "o3cloudng@gmail.com";
    // $type = "group";

    $curl = curl_init();
    // $data = http_build_query($dataArray);
    // $getUrl = $url."?".$data;

    // print_r($getUrl);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_TIMEOUT, 80);
     
    $response = curl_exec($curl);

    // print_r($curl);
     
    if(curl_error($curl)){
        echo 'Request Error:' . curl_error($curl);
    }
    else
    {
        $resp = json_decode($response, true);

        if(isset($resp['datachild']) && count($resp['datachild']) > 0)
        { ?>
            
            <ul class="list-group col-md-6">
        <?php
            $resp = $resp['datachild'];
            foreach($resp as $i=>$result){
                echo '<li class="list-group-item">';
                echo "<strong>".$result['name']."</strong>  ".$result['ebib']."<br>";
                echo '</li>';
            }
        }else{
            echo $resp['message'];
        } ?>
            </ul>
        <?php
    }
     
    curl_close($curl);
}

?>
<script>
    var data = "<?php echo $response; ?>";
    console.log(data);
</script>