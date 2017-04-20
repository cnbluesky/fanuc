<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Edit State</title>
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
      
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="<?php echo base_url().'state'?>">State List</a></li>
        <li class="active">Edit State</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
          <div class="col-sm-4 col-sm-offset-4">
            <div class="change-password">
                <form action="" method="post" id="login_form">
                <div class="form-group">
                    <?php if(!empty($error_message)){?><span class="error_message"><?php echo $error_message;?></span><?php }?>
                    <select name="country_id" class="form-control">
                        <option value="">Select Country</option>
                        <?php foreach ($country as $val){?>
                        <option value="<?php echo $val['country_id'];?>" <?php if($state['country_id'] == $val['country_id']){?> selected="selected"<?php }?>><?php echo $val['country_name'];?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="state_name" class="form-control" placeholder="State" value="<?php echo $state['state_name'];?>">
                </div>
                
                <div class="form-group submit">
                    <button type="submit" class="btn" id="login_but">Submit</button>
                </div>
              </form>
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
                            state_name: {
                                required: true
                            },
                            
                            country_id: {
                                required: true
                            },
                            

                        },
                        messages: {
                            state_name: {
                                required: "State name is required"
                            },
                            
                            country_id: {
                                required: "Country is required"
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
