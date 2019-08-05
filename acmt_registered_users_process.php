<?php

function acmt_registered_users_shortcode()
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


    function countRegUsers($users) {
        return count($users);
    }

    function countCompletedRegUser() {
        $countRegUsers = getRegisteredUsers('users');
        $resp = json_decode($countRegUsers, true);

        if($resp) {
            if(count($resp['data']) > 0){
                return count($resp['data']);            
            } else {
                return "0";
            }
        } else {
             return "0";
        }
    }

    function countSingleUsers() {
        $singleUsers = getRegisteredUsers('single');
        $resp = json_decode($singleUsers, true);

        if($resp){
            if(count($resp['data']) > 0){
                return count($resp['data']);            
            } else {
                return "0";
            }
        } else {
             return "0";
        }
    }

    function countGroupUsers() {
        $groupUsers = getRegisteredUsers('group');
        $resp = json_decode($groupUsers, true);

        if($resp){
            if(count($resp['data']) > 0){
                return count($resp['data']);            
            } else {
                return "0";
            }
        } else {
             return "0";
        }

    }

    function countFamilyUsers() {
        $familyUsers = getRegisteredUsers('family');
        $resp = json_decode($familyUsers, true);

        if($resp){
            if(count($resp['data']) > 0){
                return count($resp['data']);            
            } else {
                return "0";
            }
        } else {
             return "0";
        }
    }

    ?>
    <!-- <h1>Admin Page for all users</h1> -->
    
<div class="container">
    <div class="row">
        <div class="col-xl-6 col-sm-6 mb-3">
          <div class="card dashboard text-white bg-warning o-hidden h-100">
            <div class="card-header">
                <h5 style="color: white !important;">List of Users </h5>
            </div>
            <div class="card-body">
                  <div class="mr-5 text-center">
                    <h1 style="color: white !important;font-size: 50px;"><?php echo countRegUsers($users); ?></h1>
                    <p></p>
                  </div>
            </div>
            <div class="card-footer">
                <a href="<?php echo site_url('all-users'); ?>" class="btn btn-default pull-right">View Details</a>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-sm-6 mb-3">
          <div href="#" class="card dashboard text-white bg-success o-hidden h-100">
            <div class="card-header">
                <h5 style="color: white !important;">Registered and paid Users</h5>
            </div>
            <div class="card-body">
                <div class="mr-5 text-center" >
                    <h5 style="color: white !important;font-size: 50px;"><?php echo countCompletedRegUser(); ?></h5>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?php echo site_url('registered-users'); ?>" class="btn btn-default pull-right">View Details</a>
            </div>          
          </div>
        </div>
        

    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-3">
              <div class="card dashboard text-white bg-info o-hidden h-100">
                <div class="card-header">
                    <h5 style="color: white !important;">No. of Single <br>Users </h5>
                </div>
                <div class="card-body">
                    <div class="mr-5 text-center" >
                        <h5 style="color: white !important;font-size: 50px;"><?php echo countSingleUsers($users); ?></h5>

                        <h3 class="badge badge-inverse text-center">No. of Singles &raquo; <?php echo countSingleUsers($users); ?></h3>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn pull-left">NGN <?php echo number_format(total_amount('single',countSingleUsers($users))); ?></button>
                    <a href="<?php echo site_url('registered-single-users'); ?>" class="btn btn-default pull-right">View Details</a>
                </div>          
              </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-3">
              <div class="card dashboard text-white bg-info o-hidden h-100">
                <div class="card-header">
                    <h5 style="color: white !important;">No. of Group <br>Registrations</h5>
                </div>
                <div class="card-body">
                    <div class="mr-5 text-center" >
                        <h5 style="color: white !important;font-size: 50px;"><?php echo countGroupUsers(); ?></h5>
                        <h3 class="badge badge-inverse text-center">No. of Groups &raquo; <?php echo countGroupUsers()/5; ?></h3>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn pull-left">NGN <?php echo number_format(total_amount('group',countGroupUsers())); ?></button>
                    <a href="<?php echo site_url('registered-group-users'); ?>" class="btn btn-default pull-right">View Details</a>
                </div>              
              </div>
            </div>

            <div class="col-xl-4 col-sm-6 mb-3">
              <div class="card dashboard text-white bg-info o-hidden h-100">
                <div class="card-header">
                    <h5 style="color: white !important;">No. of Family <br>Registrations</h5>
                </div>
                <div class="card-body">
                    <div class="mr-5 text-center" >
                        <h5 style="color: white !important;font-size: 50px;"><?php echo countFamilyUsers(); ?></h5>
                        <h3 class="badge badge-inverse text-center">No. of Family &raquo; <?php echo countFamilyUsers()/4; ?></h3>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn pull-left">NGN <?php echo number_format(total_amount('family',countFamilyUsers())); ?></button>
                    <a href="<?php echo site_url('registered-family-users'); ?>" class="btn btn-default pull-right">View Details</a>
                </div>              
              </div>
            </div>
        </div>        
    </div>

</div>
<?php
}
add_shortcode('acmt_registered_users_shortcode', 'acmt_registered_users_shortcode');
?>