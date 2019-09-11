<?php 
  //insert this view
  include('snippets/header.php'); 
?>

<div class="site-container site-main login-container">
  <div class="container">
    <div class="row no-gutter site-main-holder">
    	<div class="col-md-6 col-md-offset-3">
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
              	<h3 class="text-center">Login to Nanodesk</h3>
              	<p>Nanodesk requires you to login with an <a href="#">ORCID</a> account.</p>
                <a  style="margin-top:20px;" href="<?php echo $orcid->loginUrl(); ?>" class="btn btn-lg btn-success">
                  Login With ORCID
                </a>
              </div>
             
            </div>
          </div>
        </div>
    </div>
  </div>
</div><!--//site container-->


<?php include('snippets/footer.php');  ?>
