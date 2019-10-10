<?php
$user = wp_get_current_user();
    if(!is_user_logged_in()) {
        wp_redirect(site_url('my-account'));
    } 

    $bio = get_user_meta($user->ID, 'acmt_bio');

  $country = strtolower($bio[0]['country']);

  // if(isset($_GET['location'])){
  //   $country = $_GET['location'];
  // } else {
  //   $country = "";
  // }

?>
<!-- <h2>Registration Form</h2> -->
<div class="container">
    <div class="row white d-flex justify-content-center">
        <div class="col-md-8 col-sm-12">
          <ul class="breadcrumb">
            <!-- <li class="completed"><a href="javascript:void(0);">Sign up</a></li> -->
            <li class="completed"><a href="javascript:void(0);">Basic Info</a></li>
            <li class="active"><a href="javascript:void(0);">Payment</a></li>
            <li><a href="javascript:void(0);">EBIB</a></li>
        </ul>
        </div>
    </div>
    <div class="col-md-8 offset-md-2">
        <!-- <form action="" method="get">
          <div class="row">
            <div class="container">
              <div class="form-group">
              <label>Current location</label> <br/>
              <select class="form-control" name="location" id="myselect" onchange="this.form.submit()">
                  <option value="">--Select current location--</option>
                  <option value="nigeria">Nigeria</option>
                  <option value="abroad">Abroad</option>
              </select>
            </div>
            </div>
          </div>
        </form> -->
        <h2>Individuals (Elites & Individual Fun Runners)</h2>
        <p><strong>Note: 10km race is only for Fun Runners.<br/>
        Any athlete registered under an athletics federation or body either home or abroad is not eligible to run in the 10km race.</strong></p>
        <p>Complete your registration by making payment</p>
        <form method="post" action="">
          <div class="form-group" id="local">
            <?php echo $_GET['location']; ?>
              <label>Amount</label>
              <div class="input-group">
                <div class="input-group-addon" style="padding-right:25px;">
                    <span class="glyphicon glyphicon-credit-card"></span>
                </div>

                <?php if($_GET['location'] == "abroad") { ?>
                 <!--  <input type="text" id="amount_value" disabled value="USD 100 (NGN 36,000.00)" class="form-control" />
                  <input type="hidden" id="amount" name="amount_value" value="3600000">
                  <input type="hidden" id="currency" value="NGN"> -->
                <?php } else { ?>
                  <!-- <input type="text" id="amount_value" disabled value="NGN 5,000" class="form-control" />
                  <input type="hidden" id="amount" name="amount_value" value="500000">
                  <input type="hidden" id="currency" value="NGN">    -->               
                <?php } ?>

                <?php if($country == "nigeria") { ?>
                  <input type="text" id="amount_value" disabled value="NGN 5,000" class="form-control" />
                  <input type="hidden" id="amount" name="amount_value" value="500000">
                  <input type="hidden" id="currency" value="NGN">
                <?php } else { ?>  
                  <input type="text" id="amount_value" disabled value="USD 100" class="form-control" />
                  <input type="hidden" id="amount" name="amount_value" value="10000">
                  <input type="hidden" id="currency" value="USD">                                  
                <?php } ?>

                </div>
          </div>
          <div class="form-group">
              <input type="button" onclick="payWithPaystack()" class="btn btn-primary btn-block" value="Complete Payment" />
          </div>
        </form>
        <p>&nbsp;</p>
      </div>



        </div>
        <div class="container mt-5">
          <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/03/sponsors.jpg" alt="">
        </div>

<?php
$current_user = wp_get_current_user();
$email = $current_user->user_email;
$firstname = $current_user->firstname;
$lastname = $current_user->lastname;
$user_id = $current_user->ID;


function genReference($qtd,$user_id)
{
    //Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
    $Characteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789'.$user_id;
    $QuantidadeCharacteres = strlen($Characteres);
    $QuantidadeCharacteres--;

    $Hash = null;

    for ($x = 1; $x <= $qtd; $x++) {
        $Position = rand(0, $QuantidadeCharacteres);
        $Hash .= substr($Characteres, $Position, 1);
    }

    return $Hash;
}

$reference = genReference(10,$user_id);

$bio = 'acmt_bio';
$tranx_bio = get_user_meta($user_id, $bio);

$phone = $tranx_bio[0]['phone'];
$race = $tranx_bio[0]['race'];

?>

<!-- <script type="text/javascript" src="https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script> -->

<!-- <script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script> -->
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
var email = "<?php echo $email; ?>";
var firstname = "<?php echo $firstname; ?>";
var lastname = "<?php echo $lastname; ?>";
var phone = "<?php echo $phone; ?>";
var race = "<?php echo $race; ?>";
// var email = "o3cloudng@gmail.com";
var reference = "<?php echo $reference; ?>";
// alert(user_email);

</script>
 
<script>
  function payWithPaystack(){

    const amount = document.getElementById('amount').value;
    const currency = document.getElementById('currency').value;
    const amount_value = document.getElementById('amount_value');

    var handler = PaystackPop.setup({
      key: 'pk_live_5a6d45e58e9531219c878f98b0253c9230f569c6',
      email: email,
      amount: amount,
      currency: currency,
      ref: reference,
      // ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      firstname: firstname,
      lastname: lastname,
      // label: "Optional string that replaces customer email"
      metadata: {
         custom_fields: [
            {
                display_name: firstname+ " "+lastname,
                variable_name: email,
                phone: phone,
                race:race,
                currency:currency
            }
         ]
      },
      callback: function(response){
          // alert('success. transaction ref is ' + response.reference);
          window.location = "<?php echo site_url(); ?>/payment-receipt?reference="+reference;
      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();
  }
</script>

