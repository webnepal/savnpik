<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title_for_layout; ?></title>
    
        <!-- JavaScript -->
    <!--script src="js/jquery-1.10.2.js"></script-->
      
    <!--script src="js/bootstrap.js"></script-->

    <!-- Page Specific Plugins -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <!--script src="js/morris/chart-data-morris.js"></script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script-->
    
    <?php echo $this->Html->script('jquery-1.10.2',array('fullBase'=>true));?>
    
    <?php echo $this->Html->script('bootstrap',array('fullBase'=>true));?>
    
    <?php echo $this->Html->script('morris/chart-data-morris',array('fullBase'=>true));?>
        <?php $this->Html->script('tablesorter/jquery.tablesorter',array('fullBase'=>true));?>
        <?php $this->Html->script('tablesorter/tables',array('fullBase'=>true));?>
      
    <!-- Bootstrap core CSS -->
    <!--link href="css/bootstrap.css" rel="stylesheet"-->
   
    <?php echo $this->Html->css('bootstrap',array('fullBase'=>true)); ?>
 
  
    <!-- Add custom CSS here -->
    <!--link href="css/sb-admin.css" rel="stylesheet"-->
        <?php echo $this->Html->css('sb-admin',array('fullBase'=>true)); ?>
    <!--link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"-->
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
  </head>

  <body>

    <div id="wrapper">

      <div id="page-wrapper">
        
        <!-- Calling Menu Element-->
        <?php echo $this->element('menu', array('cache' => false)); ?>
          
        <div class="row">
          <div class="col-lg-12">
            <h1><?php echo $title_for_layout; ?></h1>
            <!--ol class="breadcrumb">
              <li class="active"><i class="fa fa-dashboard"></i><?php echo $title_for_layout; ?></li>
            </ol-->
        </div>
        </div><!-- /.row -->

        <?php echo $content_for_layout; ?>
      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

  
        
  </body>
</html>
