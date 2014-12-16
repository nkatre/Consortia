
<?php
    require '../Database/database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
		$acronymError =null;
        $date_initiatedError = null;
		$end_dateError = null;
        $statusError = null;
		$no_of_membersError =null;
		$responsible_adminError = null;
		$directorError = null;
		$key_administratorError = null;
		$project_idError=null;
		//$record_entered_byError = null;
		//$record_entered_dateError = null;
							
							
        // keep track post values
        $name = $_POST['name'];
		$acronym = $_POST['acronym'];
		$date_initiated = $_POST['date_initiated'];
		$end_date = $_POST['end_date'];
		$status = $_POST['status'];
		$no_of_members = $_POST['no_of_members'];
        $responsible_admin = $_POST['responsible_admin'];
		$director = $_POST['director'];
		$key_administrator = $_POST['key_administrator'];
		$record_entered_by = $_POST['record_entered_by'];   
		$record_entered_date = $_POST['record_entered_date'];
		$project_id = $_POST['project_id'];
	    
		
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
		
		if (empty($acronym)) {
            $nameError = 'Please enter Acronym';
            $valid = false;
        }
         
        if (empty($date_initiated)) {
            $date_initiatedError = 'Please enter Date Initiated';
            $valid = false;
        }
		 if (empty($end_date)) {
            $end_dateError = 'Please enter End Date';
            $valid = false;
        }
		if (empty($status)) {
            $statusError = 'Please enter the current status of the Consortium';
            $valid = false;
        } 
		
		if (empty($no_of_members)) {
            $no_of_membersError = 'Please enter the Number of Members in the Consortium. Enter "NIL" if number of members is 0';
            $valid = false;
        } 
		 
        if (empty($responsible_admin)) {
            $responsible_adminError = 'Please enter the Responsible Administrator for the Consortium';
            $valid = false;
        } 
		
		 if (empty($director)) {
            $directorError = 'Please enter the name and email address (separated by ,) of Director of the Consortium';
            $valid = false;
        } 
        
		if (empty($key_administrator)) {
            $key_administratorError = 'Please enter the name and email address (separated by ,) of Key Administrator of the Consortium';
            $valid = false;
        } 
		if (empty($project_id)) {
            $project_idError = 'Please enter the Project ID';
            $valid = false;
        }
		
		/*if (empty($record_entered_by)) {
            $record_entered_byError = 'Please enter your full name';
            $valid = false;
        } 
		
		if (empty($record_entered_date)) {
            $record_entered_dateError = 'Please enter today\'s date';
            $valid = false;
        } */
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE data SET name = ?, date_initiated=?,end_date=?, status =?, no_of_members=?, responsible_admin=?, director =?, key_administrator =?, record_entered_by =?, record_entered_date =? WHERE data.consortium_id =?";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$date_initiated,$end_date,$status,$no_of_members,$responsible_admin,$director,$key_administrator,$record_entered_by,$record_entered_date,$id));
            Database::disconnect();
			
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE main SET acronym = ? WHERE main.consortium_id =?";
            $q = $pdo->prepare($sql);
            $q->execute(array($acronym,$id));
            Database::disconnect();
			
            header("Location: index.php");
        }
    } else {
		
		
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT name,date_initiated,end_date,status,no_of_members,responsible_admin,director,key_administrator,project_id FROM data where data.consortium_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['name'];
		$date_initiated = $data['date_initiated'];
		$end_date = $data['end_date'];
		$status = $data['status'];
		$no_of_members = $data['no_of_members'];
        $responsible_admin = $data['responsible_admin'];
		$director = $data['director'];
		$key_administrator = $data['key_administrator'];
		$project_id = $data['project_id'];
		 
		// setting the current date
		date_default_timezone_set('America/Raleigh'); // CDT
        $current_date = date('Y-m-d H:i:s');
		// Getting values of record_entered_by and record_entered_date
		$record_entered_by = $_SERVER["HTTP_KDUSER"];   // Get the Unity ID of the user from the Shibboleth Server
		$record_entered_date = $current_date;           // Get the current date-time
		Database::disconnect();
		
		$pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql2 = "SELECT main.acronym from main where main.consortium_id = ?";
		$q2 = $pdo -> prepare($sql2);
		$q2 -> execute(array($id));
		$data2 = $q2 ->fetch(PDO::FETCH_ASSOC);
		$acronym = $data2['acronym'];	
        Database::disconnect();
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
                                   
                    <form class="form-horizontal"  role= "form" action="update.php?id=<?php echo $id?>" method="post">
                
                    <div class="row" align="center">
                    <h3> <b> Update Consortium </b> </h3>  
                  
                    <div  style = "clear: right; float: right; text-align: right;"> 
                    <p class="navbar-right">   
             <a href="https://www3.acs.ncsu.edu/Shibboleth.sso/Logout" class="btn btn-danger">Logout</a>&nbsp;
                    </p>  
                                   
                    <p class="navbar-left">   
                	<a href="index.php" class="btn btn-primary" >Back</a>  &nbsp;
            		</p>
                    <p class="navbar-left"> 
                    <button type="submit" class="btn btn-info">Update</button> &nbsp;
                    </p>
            		</div>  
                    </div>
                    <br>
                    <br>         
                    
         
                             
                      <div class="form-group <?php echo !empty($nameError)?'error':'';?>">
                           <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-8">
                     
                            <input name="name" type="text" class="form-control" placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                      
                      
                      <div class="form-group <?php echo !empty($acronymError)?'error':'';?>">
                        <label class="col-sm-2 control-label">Acronym</label>
                        <div class="col-sm-8">
                            <input name="acronym" type="text" class="form-control" placeholder="Acronym" value="<?php echo !empty($acronym)?$acronym:'';?>">
                            <?php if (!empty($acronymError)): ?>
                                <span class="help-inline"><?php echo $acronymError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      
                      
                      
                      <div class="form-group <?php echo !empty($date_initiatedError)?'error':'';?>">
                        <label class="col-sm-2 control-label">Date Initiated</label>
                        <div class="col-sm-8">
                            <input name="date_initiated" type="text" class="form-control" placeholder="Date Initiated" value="<?php echo !empty($date_initiated)?$date_initiated:'';?>">
                            <?php if (!empty($date_initiatedError)): ?>
                                <span class="help-inline"><?php echo $date_initiatedError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      
                      <div class="form-group <?php echo !empty($end_dateError)?'error':'';?>">
                        <label class="col-sm-2 control-label">End Date</label>
                        <div class="col-sm-8">
                            <input name="end_date" type="text" class="form-control" placeholder="End Date" value="<?php echo !empty($end_date)?$end_date:'';?>">
                            <?php if (!empty($end_dateError)): ?>
                                <span class="help-inline"><?php echo $end_dateError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      
                      <div class="form-group <?php echo !empty($statusError)?'error':'';?>">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-8">
                            <select name="status" type="text" class="form-control" placeholder="Status" value="<?php echo !empty($status)?$status:'';?>">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            </select>
                            <?php if (!empty($statusError)): ?>
                                <span class="help-inline"><?php echo $statusError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      
                      
                      
                      <div class="form-group <?php echo !empty($no_of_membersError)?'error':'';?>">
                        <label class="col-sm-2 control-label">No Of Members</label>
                        <div class="col-sm-8">
                            <input name="no_of_members" type="text"  class="form-control"  placeholder="No Of Members" value="<?php echo !empty($no_of_members)?$no_of_members:'';?>">
                            <?php if (!empty($no_of_membersError)): ?>
                                <span class="help-inline"><?php echo $no_of_membersError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      
                      
                      
                      <div class="form-group <?php echo !empty($responsible_adminError)?'error':'';?>">
                        <label class="col-sm-2 control-label">Responsible Administrator</label>
                        <div class="col-sm-8">
                            <input name="responsible_admin" type="text"  class="form-control"  placeholder="Responsible Administrator" value="<?php echo !empty($responsible_admin)?$responsible_admin:'';?>">
                            <?php if (!empty($responsible_adminError)): ?>
                                <span class="help-inline"><?php echo $responsible_adminError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      
                      
                      
                       <div class="form-group <?php echo !empty($directorError)?'error':'';?>">
                        <label class="col-sm-2 control-label">Director</label>
                        <div class="col-sm-8">
                            <input name="director" type="text"  class="form-control"  placeholder="Director name and email separated by comma ','" value="<?php echo !empty($director)?$director:'';?>">
                            <?php if (!empty($directorError)): ?>
                                <span class="help-inline"><?php echo $directorError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      
                      
                       <div class="form-group <?php echo !empty($key_administratorError)?'error':'';?>">
                        <label class="col-sm-2 control-label">Key Administrator</label>
                        <div class="col-sm-8">
                            <input name="key_administrator" type="text"  class="form-control"  placeholder="Key Administrator name and email separated by comma ','" value="<?php echo !empty($key_administrator)?$key_administrator:'';?>">
                            <?php if (!empty($key_administratorError)): ?>
                                <span class="help-inline"><?php echo $key_administratorError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      
                                       
                      <div class="form-group <?php echo !empty($project_idError)?'error':'';?>">
                        <label class="col-sm-2 control-label">Project ID</label>
                        <div class="col-sm-8">
                            <input name="project_id" type="text"  class="form-control"  placeholder="Project ID" value="<?php echo !empty($project_id)?$project_id:'';?>">
                            <?php if (!empty($project_idError)): ?>
                                <span class="help-inline"><?php echo $project_idError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      
                
                      <div class="form-group <?php echo !empty($record_entered_byError)?'error':'';?>">
                        <!--<label class="col-sm-2 control-label">Record Entered By</label>-->
                        <div class="col-sm-8">
                            <input name="record_entered_by" type="hidden"  class="form-control"  placeholder="Enter your name" value="<?php echo !empty($record_entered_by)?$record_entered_by:'';?>">
                            <?php if (!empty($record_entered_byError)): ?>
                                <span class="help-inline"><?php echo $record_entered_byError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                                 
                            
                      
                      <div class="form-group <?php echo !empty($record_entered_dateError)?'error':'';?>">
                        <!--<label class="col-sm-2 control-label">Record Update DateTime</label>-->
                        <div class="col-sm-8">
                            <input name="record_entered_date" type="hidden"  class="form-control"   placeholder="Today's Date-Time" value="<?php echo !empty($record_entered_date)?$record_entered_date:'';?>">
                            <?php if (!empty($record_entered_dateError)): ?>
                                <span class="help-inline"><?php echo $record_entered_dateError;?></span>
                            <?php endif;?>
                        </div>                      
                      </div>
                        
                      
 
                
                      <!--<div class="form-group">
                      	<div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-info">Update</button>
                          <a class="btn btn-default" href="index.php">Back</a>
                        </div>
                      </div>-->
                    </form>
               
                 
    </div> <!-- /container -->
  </body>
</html>