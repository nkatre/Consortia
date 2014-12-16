<?php
    require '../Database/database.php';
    $id = 0;
     
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
         
        // delete data
		$pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM main  WHERE consortium_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        
		
		$pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM data  WHERE consortium_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
		
        header("Location: index.php");
         
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7, maximum-scale=1" />
    <link   href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link   href="../bootstrap/css/media_compatibility.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</head>
 
<body>
   <div class="container">
     
                <!--<div class="span10 offset1">-->
                    <div class="row" align="center">
                    <h3> <b> Delete Consortium </b> </h3> 
                    <p class="navbar-right">   
             <a href="https://www3.acs.ncsu.edu/Shibboleth.sso/Logout" class="btn btn-danger">Logout</a>
                    </p>                   
                    </div>   
                    
                     
                     
                    <form class="form-horizontal"  role= "form" action="delete.php" method="post">
                     
                      
                      <div class="form-group">
                         <input type="hidden" name="id" value="<?php echo $id;?>"/>
                            <div class="col-sm-offset-2 col-sm-10">
      						<p class="alert alert-error">Are you sure to delete ?</p>
    						</div>
                      </div>
                      
                      
                      
                      
                        
                         <div class="form-group">
                      	<div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn btn-default" href="index.php">Back</a>
                        </div>
                      </div>
                        
                    </form>
                    
           <!--     </div> <!--span10 offset1-->
                 
    </div> <!-- /container -->
  </body>
</html>
