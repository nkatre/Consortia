<?php
// Include PEAR::Spreadsheet_Excel_Writer
require_once("Spreadsheet/Excel/Writer.php");
include '../Database/database.php';
// Create an instance
$xls = new Spreadsheet_Excel_Writer();
$xls->setVersion(8);

$header_format =& $xls->addFormat(array('Align' => 'left',
                                      'Color' => 'black',
                                      'Pattern' => 1,
                                      'FgColor' => 26));
$header_format -> setTextWrap();
$number_format =& $xls->addFormat();
$number_format -> setNumFormat("000000000");
$time = time();
// Send HTTP headers to tell the browser what's coming
if($_GET['type']==1){
$xls->send("ConsortiaDatabase.xls");
}
if($_GET['type']==2){
$xls->send("ConsortiumDetails.xls");
}
// Add a worksheet to the file, returning an object to add data to
$worksheet =& $xls->addWorksheet('Consortia');
$worksheet->setLandscape();
	if ($_GET['type']==1) 
	{
		
		$worksheet->setColumn(0,0,60);
		$worksheet->setColumn(1,1,10);
		$worksheet->setColumn(2,2,10);
		$worksheet->setColumn(3,3,10);
		$worksheet->setColumn(4,4,10);
		$worksheet->setColumn(5,5,10);
		$worksheet->setColumn(6,6,15);
		$worksheet->write(0,0,"Name", $header_format);
		$worksheet->write(0,1,"Acronym", $header_format);
		$worksheet->write(0,2,"Initiation Date", $header_format);
		$worksheet->write(0,3,"End Date", $header_format);
		$worksheet->write(0,4,"Status", $header_format);
		$worksheet->write(0,5,"Members", $header_format);
		$worksheet->write(0,6,"Responsible Admin", $header_format);
		$currentRow = 1;
		
		 $query = "SELECT name,acronym,date_initiated,end_date,status,no_of_members,responsible_admin FROM Consortia.data INNER JOIN Consortia.main on Consortia.main.consortium_id=Consortia.data.consortium_id ORDER BY name";

    if ($result = mysql_query($query) or die(mysql_error())){
		
		while ($row = mysql_fetch_assoc($result)){
			$worksheet->write($currentRow,0,$row['name']);
			$worksheet->write($currentRow,1,$row['acronym']);
			$worksheet->write($currentRow,2,$row['date_initiated']);
			$worksheet->write($currentRow,3,$row['end_date']);
			$worksheet->write($currentRow,4,$row['status']);
			$worksheet->write($currentRow,5,$row['no_of_members']);
			$worksheet->write($currentRow,6,$row['responsible_admin']);
			$currentRow++;
		}
	} // end of inner if
	} // end of outer if
	
	
	
		if ($_GET['type']==2) 
	{
		// set the 0th column width
		$worksheet->setColumn(0,0,20);
		$worksheet->setColumn(1,0,20);
		$worksheet->setColumn(2,0,20);
		$worksheet->setColumn(3,0,20);
		$worksheet->setColumn(4,0,20);
		$worksheet->setColumn(5,0,20);
		$worksheet->setColumn(6,0,20);
		$worksheet->setColumn(7,0,20);
		$worksheet->setColumn(8,0,20);
		$worksheet->setColumn(9,0,20);
		// set the 1st column width
		$worksheet->setColumn(0,1,60);
		$worksheet->setColumn(1,1,60);
		$worksheet->setColumn(2,1,60);
		$worksheet->setColumn(3,1,60);
		$worksheet->setColumn(4,1,60);
		$worksheet->setColumn(5,1,60);
		$worksheet->setColumn(6,1,60);
		$worksheet->setColumn(7,1,60);
		$worksheet->setColumn(8,1,60);
		$worksheet->setColumn(9,1,60);
		$worksheet->write(0,0,"Name", $header_format);
		$worksheet->write(1,0,"Acronym", $header_format);
		$worksheet->write(2,0,"Initiation Date", $header_format);
		$worksheet->write(3,0,"End Date", $header_format);
		$worksheet->write(4,0,"Status", $header_format);
		$worksheet->write(5,0,"Members", $header_format);
		$worksheet->write(6,0,"Responsible Admin", $header_format);
		$worksheet->write(7,0,"Director", $header_format);
		$worksheet->write(8,0,"Key Admin", $header_format);
		$worksheet->write(9,0,"Project ID", $header_format);
		$currentCol = 1;
		
		 $id = $_GET['id'];

		// Establish the database connection
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT name,acronym,date_initiated,end_date,status,no_of_members,responsible_admin,director,key_administrator,project_id FROM Consortia.data INNER JOIN Consortia.main on Consortia.main.consortium_id=Consortia.data.consortium_id WHERE Consortia.data.consortium_id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $row = $q->fetch(PDO::FETCH_ASSOC);
       

			$worksheet->write(0,$currentCol,$row['name']);
			$worksheet->write(1,$currentCol,$row['acronym']);
			$worksheet->write(2,$currentCol,$row['date_initiated']);
			$worksheet->write(3,$currentCol,$row['end_date']);
			$worksheet->write(4,$currentCol,$row['status']);
			$worksheet->write(5,$currentCol,$row['no_of_members']);
			$worksheet->write(6,$currentCol,$row['responsible_admin']);
			$worksheet->write(7,$currentCol,$row['director']);
			$worksheet->write(8,$currentCol,$row['key_administrator']);
			$worksheet->write(9,$currentCol,$row['project_id']);
			$currentCol++;

	
	}  // end of outer if
	
// Disconnect the connection
Database::disconnect();
// Finish the spreadsheet, dumping it to the browser
$xls->close();

?>