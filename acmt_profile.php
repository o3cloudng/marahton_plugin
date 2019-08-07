<?php
add_shortcode('acmt_profile_shortcode', 'acmt_profile_shortcode');
function acmt_profile_shortcode()
{
    // $allowed_roles = array('subcriber', 'author');
    // if( !array_intersect($allowed_roles, $user->roles ) ) {
    //    wp_redirect(site_url('/'));
    // }

    function getEbibNumber($email) {
        $url_ebib = 'http://5.101.138.142:8980/api/get/barcode/single/$email';
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url_ebib,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "accept: application/json"
        ],       
    ));

    $response = curl_exec($curl);

    if ($err) {
        // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
    }

    $ebibNumber = json_decode($response);

    // print_r($ebibNumber->message);
    echo $ebibNumber->message;
    }



    $user = wp_get_current_user();
    if(!is_user_logged_in()) {
        wp_redirect(site_url('my-account'));
    } 
    
    ?>
    <div class="container">
        <p><h2 class="display-4 ml-2">Hi <?php echo $user->display_name; ?></h2></p>         
    </div>

    <?php //print_r(checkEbibPayment($user->ID)); ?>
      <?php 

      $race = get_user_meta($user->ID, 'acmt_tx');
      $race = $race[0]['race'];

      $bio = get_user_meta($user->ID, 'acmt_bio');

      // print_r($bio);

      if(!checkSingleUserReg($user->ID) && !checkGroupUserReg($user->ID))
      { ?>
        <div class="container">
          <p class="alert alert-warning">
              <i class="info"></i> It appears your registration is not complete. Please, click the appropriate link to complete your registration.
            </p>
          <div class="col-md-6">
            <p>
             <ul class="breadcrumb">
              <li class="completed"><a href="<?php echo site_url('/race_2'); ?>">Individual</a></li>
              <!-- <li class="completed"><a href="<?php echo site_url('/group-members-names'); ?>">Group</a></li>
              <li class="completed"><a href="<?php echo site_url('/family-members'); ?>">Family</a></li> -->
            </ul> 
          </p>
          </div>
        </div>
      <?php }  

      // print_r(checkPaidUser($user->ID));
      if(!checkPaidUser($user->ID)) { ?>
        
        <div class="container">
          <div class="col-md-8">
            <p class="alert alert-warning"> It appears your registration has not been completed.<br/>
            Kindly complete the process by making payment.</p>
          <a style="font-size: 15px; padding: 10px;" href="<?php echo site_url('/group-members-names'); ?>" class="btn btn-primary btn-block">Make Payment Now</a>
          </div> 
        </div>
      <?php }
      ?>
    
   <!--  <div class="container">
      <div class="col-md-6">
        <div class="btn-group">
          <a class="btn btn-primary" href="<?php echo site_url('/race_2'); ?>">Individual</a>
          <a class="btn btn-primary" href="<?php echo site_url('/group-members-names'); ?>">Group</a>
          <a class="btn btn-primary" href="<?php echo site_url('/family-members'); ?>">Family</a>
        </div>
      </div>
    </div> -->
<p>&nbsp;</p>
   <div class="container">
        <div class="col col-md-4">
            <ul class="list-group">
                <a class="list-group-item active secondary"><h4 style="color:white !important;">Ebib Details</h4></a>
                <a href="javascript:void()" class="list-group-item" onclick="singleEbib()">Show Ebib &raquo;</a>
                <!-- <a href="javascript:void()" class="list-group-item" oonclick="groupEbib()">Show Group Ebib &raquo;</a>
                <a href="javascript:void()" class="list-group-item" oonclick="familyEbib()">Show Family Ebib &raquo;</a> -->
                <a href="javascript:void()" class="list-group-item" onclick="resendEbib()">Resend Ebib &raquo;</a>
                <?php 
                if(!isset($race)) {
                  $race = 10;
                } 
                  // if(isset($race)) { ?>
                <a href="<?php echo site_url(); ?>/e-bib?se=1&race=<?php echo $race; ?>" class="list-group-item"  target="_blank">Generate Ebib &raquo;</a>
               <?php //} ?>
            </ul>
        </div>
        <div class="col-md-8 bordered">
            <ul class="list-group">
                <li class="list-group-item"><strong>Name</strong>: <?php echo $user->display_name; ?></li>
                <!-- <li class="list-group-item"><strong>Display</strong>: <?php echo $user->user_nicename ?></li> -->
                <li class="list-group-item"><strong>Email</strong>: <?php echo $user->user_email; ?></li>
                <li class="list-group-item"><strong>Phone</strong>: <?php echo $bio[0]['phone']; ?></li>
                <li class="list-group-item"><strong>Country</strong>: <?php echo $bio[0]['country']; ?></li>
                <li class="list-group-item"><strong>Height</strong>: <?php echo $bio[0]['height']; ?>cm</li>
                <li class="list-group-item"><strong>Weight</strong>: <?php echo $bio[0]['weight']; ?>kg</li>
                <li class="list-group-item"><strong>Address</strong>: <?php echo $bio[0]['address']; ?></li>
                <li class="list-group-item"><strong>Race</strong>: <?php echo $bio[0]['race']; ?>km</li>

                
            </ul>  
            <p>&nbsp;</p>          
            <p id="resend" class="well" onload="singleEbib()">

              <?php
              // print_r($user->user_email);
              getEbibNumber($user->user_email);
              ?>
            </p>   
            <?php
            // echo getRegisteredUsers('single'/$user_email);
            ?>         
        </div>
   </div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script>
const resend = document.getElementById('resend');
var pemail = "<?php echo $user->user_email; ?>";
// var pemail = "olumide.oderinde@firstastoria.com"; // Test for single 
// var pemail = "o3cloudng@gmail.com"; // Test for group

// console.log(pemail);
const fetchData = async (pemail) => {
  const api_call = await fetch(`http://5.101.138.142:8980/api/barcode/resend?email=${pemail}`, {
    method:`POST`
  });

  const data = await api_call.json();
  return { data }
};

const resendEbib = () => {
  fetchData(pemail).then((res) => {
    resend.innerText = `${res.data.message}`;
  })
};

// Get data for Single
const fetchSingleEbib = async (pemail) => {
  const api_single_call = await fetch(`http://5.101.138.142:8980/api/get/barcode/single/${pemail}`);

  const singledata = await api_single_call.json();
  return { singledata }
};

const singleEbib = () => {
  fetchSingleEbib(pemail).then((resSingle) => {
    resend.innerHTML = "";
        // console.log(resSingle);
        if (resSingle.singledata.status === "failed"){
            resend.innerHTML = `<li class="list-group-item">No record found.</li>`;
         } else {
         resend.innerHTML = `<li class="list-group-item">${resSingle.singledata.data.name} - ${resSingle.singledata.data.ebib}</li>`;
     }
         
  })
};


// Get data for group
const fetchGroupEbib = async (pemail) => {
  const api_group_call = await fetch(`http://5.101.138.142:8980/api/get/barcode/group/${pemail}/group`);

  const groupdata = await api_group_call.json();
  return { groupdata }
};

const groupEbib = () => {
  fetchGroupEbib(pemail, type).then((response) => {
    if (response.groupdata.status === "failed")
    {
        resend.innerHTML = `<li class="list-group-item">No Group data found.</li>`;
    } else {
        var lunch = response.groupdata.datachild;
        resend.innerHTML = "";
        for (var key in lunch) {
            if (lunch.hasOwnProperty(key)) {
                resend.innerHTML += `<li class="list-group-item">${lunch[key].name} - ${lunch[key].ebib}</li>`;
            }
        }
    }
  })
};

// Get data for group
const fetchFamilyEbib = async (e_mail) => {
  const api_family_call = await fetch(`http://5.101.138.142:8980/api/get/barcode/group/${e_mail}/family`);

  const familydata = await api_family_call.json();
  return { familydata }
};

const familyEbib = () => {
  fetchGroupEbib(e_mail).then((resFamily) => {
    if (resFamily.familydata.status === "failed")
    {
        resend.innerHTML = `<li class="list-group-item">No Group data found.</li>`;
    } else {
        var lunch = resFamily.familydata.datachild;
        resend.innerHTML = "";
        for (var key in lunch) {
            if (lunch.hasOwnProperty(key)) {
                resend.innerHTML += `<li class="list-group-item">${lunch[key].name} - ${lunch[key].ebib}</li>`;
            }
        }
    }
  })
};


</script>

<?php
}
?>