<?php
    
	include '../checkAccessLevels/security_level_b.php';
  				  
	$object = new SecurityLevel();
	$object->getAccessLevel();
	$myAccessLevel = $object->accessLevel;
	$myConsortiumID = $object->associatedConsortiumId;
	$unityid = $object->unity_id;
	
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    } else {		
	      	$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT consortium_id,name, date_initiated, end_date, status, no_of_members, responsible_admin, director, key_administrator, record_entered_by, record_entered_date,project_id FROM data WHERE data.consortium_id =?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();
			
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql1 = "SELECT acronym FROM main WHERE main.consortium_id =?";
            $q1 = $pdo->prepare($sql1);
            $q1->execute(array($id));
			$data1 = $q1->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();			
           
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7, maximum-scale=1" />
    <link   href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/table_style.css" rel="stylesheet">
    <link   href="../bootstrap/css/media_compatibility.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/jquery.fixer.js"></script>
     <script type="text/javascript" src="../bootstrap/js/tableExport.jquery.plugin/jspdf/libs/sprintf.js"></script>
    <script type="text/javascript" src="../bootstrap/js/tableExport.jquery.plugin/jspdf/jspdf.js"></script>
    <script type="text/javascript" src="../bootstrap/js/tableExport.jquery.plugin/jspdf/libs/base64.js"></script>
    <script type="text/javascript" src="../bootstrap/js/tableExport.jquery.plugin/tableExport.js"></script>
<script type="text/javascript" src="../bootstrap/js/tableExport.jquery.plugin/jquery.base64.js"></script>
<script type="text/javascript">							
		var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,', template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>', base64 = function(
                s) {
            return window.btoa(unescape(encodeURIComponent(s)))
        }, format = function(s, c) {
            return s.replace(/{(\w+)}/g, function(m, p) {
                return c[p];
            })
        }
        return function(table, name) {
            if (!table.nodeType)
                table = document.getElementById(table);
            var cln=table.cloneNode(true);
            var paras = cln.getElementsByClassName('ignore');

            while(paras[0]) {
                paras[0].parentNode.removeChild(paras[0]);
            }
            var ctx = {
                worksheet : name || 'Worksheet',
                table : cln.innerHTML
            }
            window.location.href = uri + base64(format(template, ctx))
        }
    })();

</script>


<script>
var tableToExcelOne = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        return function (table, name, filename) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

            document.getElementById("dlink").href = uri + base64(format(template, ctx));
            document.getElementById("dlink").download = filename;
            document.getElementById("dlink").click();

        }
    })()
</script>

</head>
 

<body>
<div class="container">
        <div class="row" align="center">
              <h3> <b>  Consortium Details</b> </h3>
            
             <div  style = "clear: right; float: right; text-align: right;">
              <p class="navbar-right">   
             <a href="https://www3.acs.ncsu.edu/Shibboleth.sso/Logout" class="btn btn-danger">Logout</a>
             </p>
            &nbsp;
            <p class="navbar-left">   
                <a href="index.php" class="btn btn-primary" >Back</a>
            </p>
            </div>
            
            <!-- Export to Excel Button -->
<input type="button" onclick="location.href='PHPToExcel.php?type=2&id=<?php echo $id?>'" value="Export to Excel">
             <!-- End of Export to Excel Button -->            
        </div>


<?php
if ($myAccessLevel == 3) $levelNo=4;
else if ($myAccessLevel == 2 && $myConsortiumID == $id) $levelNo=2;
else $levelNo=1;
?>
<a target="_blank" href="https://www3.acs.ncsu.edu/docs/docs.php?doc=F
<?php echo $levelNo; ?>00|<?php echo $unityid; ?>|<?php echo $myConsortiumID; ?>"> 
Link to Access Consortium Documents<br /></a><br />

    
<table id="show_table" class="table table-bordered">
<col width="25%">
<col width="75%">
                   <?php
				   
                    echo '<tr>';                     
                    	echo ' <th> '.Name.' </th> ';
                    	echo '<td>'.$data['name'] .'</td>';
					echo '</tr>';

                    echo '<tr>'; 
					
                      echo '<th>'.Acronym.'</th>';
                      echo '<td>'.$data1['acronym'] .'</td>';
                    echo '</tr>';
					
                    echo '<tr>'; 
                      echo '<th>'.Date.' '. Initiated.'</th>';
                      echo '<td>'.$data['date_initiated'] .'</td>';	
                    echo '</tr>';
					
					echo '<tr>'; 
                      echo '<th>'.End.' '. Date.'</th>';
                      echo '<td>'.$data['end_date'] .'</td>';	
                    echo '</tr>';
					
                    echo '<tr>'; 
                      echo '<th>'.Status.'</th>';
                      echo '<td>'.$data['status'] .'</td>';
                    echo '</tr>';
					
                    echo '<tr>'; 
                      echo '<th>'.Members.'</th>';
                      echo '<td>'.$data['no_of_members'] .'</td>';
                    echo '</tr>';
					
                    echo '<tr>'; 
                      echo '<th>'.Resp.' '. Admin.'</th>';
                      echo '<td>'.$data['responsible_admin'] .'</td>';
                    echo '</tr>';
					
                    echo '<tr>';  
                      echo '<th>'.Director.'</th>';
                      echo '<td>'.$data['director'] .'</td>';
                    echo '</tr>';
					
                    echo '<tr>';  
                      echo '<th>'.Key.' '. Admin.'</th>';
                      echo '<td>'.$data['key_administrator'] .'</td>';
                    echo '</tr>';
					             
					
                    echo '<tr>';  
                      echo '<th>'.Project.' '. ID.'</th>';
                      echo '<td>'.$data['project_id'] .'</td>';
                    echo '</tr>';
				
                    ?>
                 
                  </table>
                  
                  <!--<div align="center">       
                  <a class="btn btn-primary" href="index.php">Back</a>
                  </div>-->

</div>
</body>
</html>