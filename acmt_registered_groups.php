<?php

function acmt_registered_groups_shortcode()
{
    $user = wp_get_current_user();
    $allowed_roles = array('editor', 'administrator');
    if( !array_intersect($allowed_roles, $user->roles ) ) {
       wp_redirect(site_url('/'));
    }
    ?>
    <h1>Group & Family</h1>
    <table id="GroupTable" class="table table-bordered table-striped table-hover text-small">
     <thead>
         <tr>
         <th>SN</th><th>Display Name</th> <th>Email</th> <th>Race</th><th>Type</th> <th>E-Bib</th>
     </tr>
     </thead>
     <tbody>
         
     
<?php 
    // $email = $user->user_email;

    $email = "pneumatouch@gmail.com";
    $type = "family";
    // Server from localhost
    $url = "http://5.101.138.142:8980/api/get/barcode/group/".$email."/".$type;

    // Live Server url
    // $url = "http://192.168.1.142:8980/api/get/barcode/group/".$email."/".$type;

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

        // print_r($email);

        if(isset($resp['datachild']) && count($resp['datachild']) > 0)
        { ?>
            
        <?php
            $resp = $resp['datachild'];
            $a = 1;
            foreach($resp as $i=>$result)
            {
                echo '<tr>';
                echo "<td>".$a."</td>"."<td><strong>".$result['name']."</strong></td><td>".$result['email']."</td><td>".$result['race']."</td><td>".$type."</td><td>".$result['ebib']."</td><br>";
                echo '</td></tr>';
                $a++;
            }
        }else{
            // echo $resp['message'];
            // echo "<tr><td colspan='5'>".$resp['message']."</td></tr>";
        } ?>
            </tbody>
         </table>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
        <?php
    }
     
    curl_close($curl);
// }

?>
<?php
}
add_shortcode('acmt_registered_groups_shortcode', 'acmt_registered_groups_shortcode');
?>