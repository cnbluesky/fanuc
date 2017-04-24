<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Service Request Details</title>
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
      <h1>Service Request Details</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="<?php echo base_url().'service'?>">Service Request</a></li>
        <li class="active">Service Request Details</li>
      </ol>
    </section>
    <section class="content">
      <div class="combined-search-row">
        <div class="registration-details">
          <table class="table">
            <tbody>
              <tr>
                <th>Service Request No.</th>
                <td><?php echo $service['service_request_number'];?></td>
              </tr>
              
              <tr>
                <th>Service Type</th>
                <td><?php echo $service['service_type'];?></td>
              </tr>
              
              <tr>
                <th>Product Category</th>
                <td><?php echo $service['product_category_name'];?></td>
              </tr>
              
              <tr>
                <th>User Name</th>
                <td><?php echo $service['name'];?></td>
              </tr>
              
              
              <tr>
                <th>Install ID</th>
                <td><?php echo $service['install_id'];?></td>
              </tr>
              
              <tr>
                <th>Problem Details</th>
                <td><p><?php echo $service['problem_details'];?></p></td>
              </tr>
              
              <tr>
                <th>Created Date</th>
                <td><?php echo date("d-m-Y", strtotime($service['created_date']));?></td>
              </tr>
              
            </tbody>
          </table>
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
</body>
</html>
