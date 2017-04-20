<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>FOC Request</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/responsive.dataTables.min.css">
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
                    <h1>FOC Request</h1>
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active">FOC Request</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="combined-search-row">
                        <div class="table-responsive">
                            <div class="text-right export-btn">
                                <form action="<?php echo base_url().'foc/export_excel'?>" method="post">
                                    <button type="submit" class="btn">Export</button>
                                </form>
                            </div>
                            <table class="table table-striped responsive" id="users">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Service Request No.</th>
                                        <th>Product Category</th>
                                        <th>User ID</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($foc as $val) {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><a href="<?php echo base_url() . 'foc/foc_request_detail/'.$val['foc_request_id']; ?>"><?php echo $val['foc_request_number'];?></a></td>
                                            <td><?php echo $val['product_category_name'];?></td>
                                            <td><?php echo $val['name'];?></td>
                                            <td><?php echo date("d-m-Y", strtotime($val['created_date']));?></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <p>Copyright &copy; FANUC INDIA Private Limited <?php echo date('Y'); ?>. All rights reserved.</p>
            </footer>
        </div>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.2.3.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.responsive.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom-script.js"></script> 
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    $('#users').DataTable({
                        lengthMenu: [[10, 25], [10, 25]],
                        //searching: false,
                        //ordering: false,
                        info: false
                    });
                });
            })(jQuery.noConflict());
        </script>
    </body>
</html>
