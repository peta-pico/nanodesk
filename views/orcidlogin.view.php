<?php 
  //insert this view
  include('snippets/header.php'); 
?>

<div class="site-container site-main">
  <div class="container">
    <div class="row no-gutter site-main-holder">
          <div class="panel panel-default">
            <div class="panel-body" style="padding-top:60px; padding-bottom:60px;">

              <?php 
                if($orcid->errors !='')
                {
                  echo '<div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                     '.$orcid->errors.'</div>';
                } 
              ?>
              <div class="text-center">
                <a href="<?php echo $orcid->loginUrl(); ?>" class="btn btn-lg btn-success">
                  Login With ORCID
                </a>
              </div>
             
            </div>
          </div>
    </div>
  </div>
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>
