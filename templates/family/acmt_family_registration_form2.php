<!-- <h2>Registration Form</h2> -->
<div class="container mt-0 pt-0">
        
        <div class="container">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li class="completed"><a href="javascript:void(0);">Group</a></li>
                <li class="active"><a href="javascript:void(0);">Participants</a></li>
                <li><a href="javascript:void(0);">Payment</a></li>
                <li><a href="javascript:void(0);">Generate EBIB</a></li>
            </ul>
        </div>
        <form method="post" action="" name="group_registration" onsubmit="return checkformFamily(this);">
                    <div class="col-md-12">
                        <h2>Family Registration</h2>
                        <p>Fill the names of all four family members</p>
                        <p><span id="form_error" class="text-danger"></span></p>  
                        <p>&nbsp;</p>      
                        <?php if(isset($_GET['email_error'])) {
                                echo '<p class="alert alert-danger"> Email already exist, login if it is your email</p>';
                            } 
                            if(isset($_GET['pass_error'])) {
                                echo '<p class="alert alert-danger"> Empty or password too short. Password should not be less than 5.</p>';
                            }
                            ?>
        
                       <div class="row">
                        <div class="container">
                        <p><strong>Member 1</strong></p>
                        </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>First Name </label><span id="familyone_error" class="text-danger">*</span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="familyone" name="data[0][last_name]" class="form-control" placeholder="First Name" onfocusout="valFamilyOne()">
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>Other Name</label><span id="last_name_error" class="text-danger"></span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="first_name" name="data[0][first_name]" class="form-control" placeholder="Other Name" onfocusout="validate_lastname()">
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>Prefered Name </label><span id="last_name_error" class="text-danger"></span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="display_name" name="data[0][display_name]" class="form-control" placeholder="Prefered Name" onfocusout="validate_lastname()">
                                    </div>
                                </div>
                           </div>
                       </div>
                       <div class="row">
                        <div class="container">
                        <p><strong>Member 2</strong></p>
                        </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>First Name </label><span id="familytwo_error" class="text-danger">*</span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="familytwo" name="data[1][last_name]" class="form-control" placeholder="First Name" onfocusout="valFamilyTwo()">
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>Other Name</label><span id="last_name_error" class="text-danger"></span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="first_name" name="data[1][first_name]" class="form-control" placeholder="Other Name" onfocusout="validate_lastname()">
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>Prefered Name </label><span id="last_name_error" class="text-danger"></span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="display_name" name="data[1][display_name]" class="form-control" placeholder="Prefered Name" onfocusout="validate_lastname()">
                                    </div>
                                </div>
                           </div>
                       </div>
                       <div class="row">
                        <div class="container">
                        <p><strong>Member 3</strong></p>
                        </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>First Name </label><span id="familythree_error" class="text-danger">*</span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="familythree" name="data[2][last_name]" class="form-control" placeholder="First Name" onfocusout="valFamilyThree()">
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>Other Name</label><span id="last_name_error" class="text-danger"></span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="first_name" name="data[2][first_name]" class="form-control" placeholder="Other Name" onfocusout="validate_lastname()">
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>Prefered Name </label><span id="last_name_error" class="text-danger"></span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="display_name" name="data[2][display_name]" class="form-control" placeholder="Prefered Name" onfocusout="validate_lastname()">
                                    </div>
                                </div>
                           </div>
                       </div>
                       <div class="row">
                        <div class="container">
                        <p><strong>Member 4</strong></p>
                        </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>First Name </label><span id="familyfour_error" class="text-danger">*</span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="familyfour" name="data[3][last_name]" class="form-control" placeholder="First Name" onfocusout="valFamilyFour()">
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>Other Name</label><span id="last_name_error" class="text-danger"></span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="first_name" name="data[3][first_name]" class="form-control" placeholder="Other Name" onfocusout="validate_lastname()">
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label>Prefered Name </label><span id="last_name_error" class="text-danger"></span>
                                    <div class="input-group">
                                    <div class="input-group-addon" style="padding-right:25px;">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </div>
                                        <input type="text" id="display_name" name="data[3][display_name]" class="form-control" placeholder="Prefered Name" onfocusout="validate_lastname()">
                                    </div>
                                </div>
                           </div>
                       </div>
                       <hr>
                       <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group" >
                                    <label>Phone Number 1</label><br />
                                    <input type="tel" id="phone" class="form-control" name="phone" value="+234" placeholder="+234">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Phone Number 2</label><br />
                                    <input id="contact" type="tel" class="form-control" name="phone2" value="+234"
                                        placeholder="+234">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Phone Number 3</label><br />
                                    <input type="tel" id="phone2" class="form-control" name="phone3" value="+234" placeholder="+234">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-sm-12 col-md-4 offset-md-2">
                                <div class="form-group">
                                    <label for="">Select Race</label>
                                    <div class="input-group">
                                        <div class="input-group-addon" style="padding-right:25px;">
                                            <span class="glyphicon glyphicon-road"></span>
                                        </div>
                                        <select name="group_race" id="select" class="custom-select custom-select-lg">
                                            <option value="10">10km</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-sm-12 col-md-6 offset-md-3">
                                <div class="form-group">
                                    <label for="">Amount</label>
                                    <div class="input-group">
                                        <div class="input-group-addon" style="padding-right:25px;">
                                            <span class="glyphicon glyphicon-credit-card"></span>
                                        </div>
                                        <input name="amount" value="15000" disabled="" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 offset-md-3">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" id="agree" />
                                        <label class="form-check-label" name="agree" for="exampleCheck1"> I agree to the marathon rules and regulations <a href="<?php echo site_url('/policy')?>" target="_blanck"><i class="glyphicon glyphicon-info-sign"></i></a></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <input name="acmt_family_group_register2" id="submit" value="Save and proceed" class="btn btn-primary btn-large btn-block" type="submit" >
                            </div>
                        </div>

            </form>
        
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div class="container mt-5">
             <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/03/sponsors.jpg" alt="">
        </div>
