<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5, maximum-scale=1" />  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link   href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link   href="../bootstrap/css/media_compatibility.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/jquery.fixer.js"></script>
    <script type="text/javascript" src="../bootstrap/js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/tableExport.jquery.plugin/jspdf/libs/sprintf.js"></script>
    <script type="text/javascript" src="../bootstrap/js/tableExport.jquery.plugin/jspdf/jspdf.js"></script>
    <script type="text/javascript" src="../bootstrap/js/tableExport.jquery.plugin/jspdf/libs/base64.js"></script>
    <script type="text/javascript" src="../bootstrap/js/tableExport.jquery.plugin/tableExport.js"></script>
<script type="text/javascript" src="../bootstrap/js/tableExport.jquery.plugin/jquery.base64.js"></script>
    <script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	})		
  </script>
  

<style>
#fixed_table {
	border-collapse: collapse; 
}

#fixed_table th {
	background-color: #DFAFDF;
}

#fixed_table td,th {border: 1px solid black; padding-left:10px; padding-right:5px;padding-top:5px ; padding-bottom:5px;}

</style>

<script>
	$(document).ready(function() {
		$('#fixed_table').fixer({fixedrows:1,fixedcols:0,height:550,width:930,});
	});
</script>
<title>Consortia Database</title>
<STYLE type="text/css">
.rowcolor {
background: #CCCCCC;
}
.title{
color: black
background-color:#CCCCCC;
}
</STYLE>

 <script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	$(function() {
		$( "input[type=submit], button" )
		  .button()
	  });
	// extend jquery.tablesorter to properly sort numbers against ones with commas.
	// the default jquery.tablesorter does not have this functionality.
	jQuery.tablesorter.addParser({ id: "fancyNumber", is: function(s) { return /^[0-9]?[0-9,\.]*$/.test(s); }, format: function(s) { return jQuery.tablesorter.formatFloat( s.replace(/,/g,'') ); }, type: "numeric" });
  </script>
  <script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	})
  </script>
</head>
<script>

/*$('div.ui-page').live("swipeleft", function(){
var nextpage = $(this).next('div[data-role="page"]');
if (nextpage.length > 0) {
$.mobile.changePage(nextpage, "slide", false);
}
});
$('div.ui-page').live("swiperight", function(){
var prevpage = $(this).prev('div[data-role="page"]');
if (prevpage.length > 0) { 
$.mobile.changePage(prevpage, {transition: "slide",
reverse: true});
}
});
*/
var JTable = function() {};
JTable.Setup = function() {
    var table = $('.jtable');
    $('caption', table).addClass('ui-state-default');
    $('th', table).addClass('ui-state-default');
    $('td', table).addClass('ui-widget-content');
    $(table).delegate('tr', 'hover', function() {
        $('td', $(this)).toggleClass('ui-state-hover');
    });
    $(table).delegate('tr', 'click', function() {
        $('td', $(this)).toggleClass('ui-state-highlight');
    });
};
</script>


</head>

<body>

    <div class="container">
        <div class="row" align="center">
              <h3> <b>  Consortia Database</b> </h3>
             
             <div  style = "clear: right; float: right; text-align: right;">
              <p class="navbar-right">   
             <a href="https://www3.acs.ncsu.edu/Shibboleth.sso/Logout" class="btn btn-danger">Logout</a>
             </p>
            &nbsp;
            <p class="navbar-left">   
                <a href="create.php" class="btn btn-success" >Create</a>
            </p>
            </div>
            
<input type="button" onclick="location.href='PHPToExcel.php?type=1'" value="Export to Excel">
        </div>
       

            
       <div class="table-responsive">
          <table id="fixed_table" border="1" cellpadding="1" cellspacing="1" width="930" style="table-layout:fixed">
<!--          N = Number of Members    --> 
                  <thead>
                    <tr>                     
                      <th col width="250"><center>Name</center></th>
                      <th col width="80"><center>Acronym</center></th>
                      <th col width="100"><center>Initiation Date</center></th>
                      <th col width="100"><center>End Date</center></th>
                      <th col width="80"><center>Status</center></th>
                     <!-- <th>Number of Members</th>-->
                      <th col width="80"><center>Members</center></th>
                      <th col width="100"><center>Respons. Admin.</center></th>
                      <!--<th>Director</th>
                      <th>Key Administrator</th>
                      <th>Record Entered By</th>
                      <th>Record Entered Date</th>-->
                      <th col width="120" class="exclude"><center>Actions</center></th>
                    
                    </tr>
                  </thead>
                  
                  <tbody>
                  
                  <?php
                   				   
				   include '../checkAccessLevels/security_level_b.php';
    
					  
				   $object = new SecurityLevel();
				   $object->getAccessLevel();
				   $myAccessLevel = $object->accessLevel;
				   $myConsortiumID = $object->associatedConsortiumId;
				  
	
				   $pdo = Database::connect();
				   $unity_id=$_SERVER["HTTP_KDUSER"];
				   
				  
                   $sql = "SELECT main.consortium_id,name,main.acronym,date_initiated,end_date,status,no_of_members,responsible_admin,director,key_administrator, record_entered_by,record_entered_date FROM data,main where data.consortium_id = main.consortium_id ORDER BY name";
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td class="filterable-cell">';
							echo '<a href="show.php?id='.$row['consortium_id'].'">'.$row['name'].'</a>';
                            echo '<td  class="filterable-cell">'. $row['acronym'] . '</td>';
							echo '<td class="filterable-cell">'. $row['date_initiated'] . '</td>';
							echo '<td class="filterable-cell">'. $row['end_date'] . '</td>';
							echo '<td class="filterable-cell">'. $row['status'] . '</td>';
							echo '<td class="filterable-cell">'. $row['no_of_members'] . '</td>';
                            echo '<td class="filterable-cell">'. $row['responsible_admin'] . '</td>';
							/*echo '<td class="filterable-cell">'. $row['director'] . '</td>';
                            echo '<td class="filterable-cell">'. $row['key_administrator'] . '</td>';
							echo '<td class="filterable-cell">'. $row['record_entered_by'] . '</td>';
                            echo '<td class="filterable-cell">'. $row['record_entered_date'] . '</td>';*/
							echo '<div class="btn-group">';
							echo '<td class="exclude" width=200 align="center">';		
							if($myAccessLevel==1){					
							echo '<a class="btn btn-default btn-sm" href="show.php?id='.$row['consortium_id'].'">Show</a>';
							echo '&nbsp;';
							}
							else if($myAccessLevel>1){
							echo '<span style="display: block; width: 100px; vertical-align: top;">';
                            echo '<a class="btn btn-info btn-sm" href="update.php?id='.$row['consortium_id'].'">Update</a>'; 
						  /*  echo '&nbsp;';*/
							echo '<a class="btn btn-danger btn-sm" href="delete.php?id='.$row['consortium_id'].'">Delete.</a>';
							echo '</span>';
							}
							echo '</td>';
							echo '</div>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div><!--/table-responsive -->
       
    </div> <!-- /container -->
    
  </body>
</html>
