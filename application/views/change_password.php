<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Change Password</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" />
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  
  <?php $this->load->view('sidebar'); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Change Password</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Change Password</li>
      </ol>
    </section>
    <section class="content">
      <div class="combined-search-row">
        <div class="row">
          <div class="col-sm-4 col-sm-offset-4">
            <div class="change-password">
                <form action="" method="post" id="login_form">
                <div class="form-group">
                    <?php if(!empty($error_message)){?><span class="error_message"><?php echo $error_message;?></span><?php }?>
                    <input type="password" name="old_password" class="form-control" placeholder="Old Password">
                </div>
                <div class="form-group">
                    <input type="password" name="new_password" class="form-control" placeholder="New Password" id="pass">
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                </div>
                <div class="form-group submit">
                    <button type="submit" class="btn" id="login_but">Change Password</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <footer class="main-footer">
    <p>Copyright &copy; FANUC INDIA Private Limited <?php echo date('Y');?>. All rights reserved.</p>
  </footer>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.2.3.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom-script.js"></script>


<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
        <script>
            (function ($) {
                $("#login_but").click(function () {



                    $("#login_form").validate({
                        rules: {
                            old_password: {
                                required: true
                            },
                            new_password: {
                                required: true
                            },
                            confirm_password: {
                                required: true,
                                equalTo: "#pass"
                            }


                        },
                        messages: {
                            old_password: {
                                required: "Old password is required"
                            },
                            new_password: {
                                required: "New Password is required"
                            },
                            confirm_password: {
                                required: "Confirm Password is required",
                                equalTo:"Password Not Matching"
                            }

                        }
                        
                    });

                    if ($("#login_form").valid())
                    {
                        $("#login_form").submit();
                    }
                });
            })(jQuery.noConflict());
        </script>

        <style>
            label.error{color: #FF4633; font-size: 11px;}
            .error_message{color: #FF4633; font-size: 11px;}
        </style>
</body>
</html>
