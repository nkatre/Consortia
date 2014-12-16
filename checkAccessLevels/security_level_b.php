
<?php
include "../Database/database.php";
class SecurityLevel

/**The SecurityLevel class obtains the unity id of the user who is logged in from the header
then determines the user's security flag and consortium id from the consortia_login_info table.
If the user is not found in the database, the security flag is set to 1 (Read-only access)
and consortium id is set to 0.
To use this class to get the security flag and consortium id for the user:
1. Instantiate class.
$mySecurityLevel = new SecurityLevel();
2. Get properties
$secFlag = $mySecurityLevel->security_level;
$consortium_id = mySecurityLevel->consortium_id;
*/

{
    public $accessLevel;
	public $associatedConsortiumId;
	public $unity_id;

    public function getAccessLevel()
    {
    
         $user =$_SERVER["HTTP_KDUSER"];
		 $this->unity_id = $user;
		 //echo "$user";
         $pdo = Database::connect();
		 //echo "test";
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM consortia_login_info WHERE unity_id='$user' LIMIT 1";
            $q = $pdo->prepare($sql);
            $q->execute();
			$data = $q->fetch(PDO::FETCH_ASSOC);
			//print_r($data);
            Database::disconnect();
			//echo "test";
        if ($data['unity_id'] == NULL) {   
        $this->accessLevel = 1;
		$this->associatedConsortiumId = 0;
		}
		else {
		$this->accessLevel = $data['secFlag'];
		$this->associatedConsortiumId = $data['consortium_id'];	
		}
    }
   
}
//echo "test";
//$mySecurityLevel = new SecurityLevel();
//echo "new object";
//$mySecurityLevel->getAccessLevel();
//echo "access test";
//$secFlag = $mySecurityLevel->accessLevel;
//$consortium_id = $mySecurityLevel->associatedConsortiumId;
//echo $secFlag.$consortium_id;
?>
