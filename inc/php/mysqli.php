<?php
	require_once('inc/php/dbConfig.php');
    global $conn;

	$conn=new TMysqLiConnexion($dbHost, $dbUser, $dbPass, $dbName);
	$conn->Connect();
	
	function getTypeOf($value) {
		if(is_string($value)) $type = 's';
		elseif(is_float($value)) $type = 'd';
		elseif(is_int($value)) $type = 'i';
		else throw new Exception("type of '$value' is not string, int or float");
		return $type;
	}
	class TMysqLiConnexion
	{
		public $host, $user, $pass, $db, $debugging;		
		public $core;
		
		function __construct($host, $user, $pass, $db, $debugging=0) {
			$this->host=$host;
			$this->user=$user;
			$this->pass=$pass;
			$this->db=$db;
			$this->debugging=$debugging;
		}
		
		public function Connect(){
			if($this->Connected())
				return false;			
			$this->core = new mysqli($this->host, $this->user, $this->pass, $this->db);
			if ($this->core->connect_errno) {
				echo("Connect failed: %s\n". $this->core->connect_error);
				exit();
			}
			$this->core->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
			if ($this->Connected())
				return 1;
			return 0;
		}
		public function Connected(){
			if ($this->core && $this->core->ping())
				return 1;
			return 0;
		}
		
		public function EscapeString($str){
			return $this->core->real_escape_string($str);	
		}
		
		public function NonQuery($query){
            $args=func_get_args();$params=sizeof($args)>1?$args[1]:array();
			$stmt=$this->getStmtPreparedFromQuery($query, $params);
			$affectedRows=$stmt->affected_rows;
			$stmt->close();
			return $affectedRows;
		}
		public function Value($query){
            $args=func_get_args();$params=sizeof($args)>1?$args[1]:array();
			$p=$this->Row($query, $params);
			return $p[0];
		}
	
		public function Row($query){
            $args=func_get_args();$params=sizeof($args)>1?$args[1]:array();
			return $this->Rows($query, $params)->fetch_array();
		}
		public function Rows($query){
            $args=func_get_args();$params=sizeof($args)>1?$args[1]:array();
			$stmt=$this->getStmtPreparedFromQuery($query, $params);
			$stmt->store_result();
			$fieldCount=$stmt->field_count;
			$rowCount=$stmt->num_rows;
			$result1 = new TMysqLiResult;
			$firstArray=array_fill(0, $fieldCount, "0");
			$secondArray=array();
			$secondArray[0]=$stmt;
			for($i=0;$i<$fieldCount;$i++)
				$secondArray[$i+1]=&$firstArray[$i];
			call_user_func_array("mysqli_stmt_bind_result", $secondArray);
			for($j=0;$j<$rowCount;$j++){
				$stmt->fetch();
				$result1->addArray($firstArray);
			}
			$stmt->close();		
			return $result1;
		}
		public function Count($query){
            $args=func_get_args();$params=sizeof($args)>1?$args[1]:array();
            $c=-1;
			$stmt=$this->getStmtPreparedFromQuery($query, $params);
			$stmt->store_result();
			$stmt->bind_result($c);
			$stmt->fetch();;
			$stmt->close();
			return $c;	
		}
        public function Column($query){
            $args=func_get_args();$params=sizeof($args)>1?$args[1]:array();
            $rows=$this->Rows($query, $params);
            $ret=array();
            while($row=$rows->nextRow())
                array_push($ret, $row[0]);
            return $ret;
        }
        public function Columns($table){
            $table=$this->EscapeString($table);
            $query="SHOW COLUMNS FROM $table;";
            $rows=$this->Rows($query);
            $c=0;
            $cols=array();
            while($row=$rows->nextRow())
                $cols[$c++]=$row[0];
            return $cols;
        }
        public function LastId(){
            return $this->core->insert_id;
        }
		public function getStmtPreparedFromQuery($query, $params){
			$this->Connect();
			$stmt = $this->core->prepare($query);
			if(!$stmt)
				echo "Prepare failed: (" . $this->core->errno . ") " . $this->core->error."<br>$query";
			$type="";
			for($i=0;$i<count($params);$i++){
				$params[$i]=$this->core->real_escape_string($params[$i]);
                //$params[$i]=sanitize($params[$i]); deja in baseFuncs.php
				$type.=getTypeOf($params[$i]);
			}
			$stmtParams=array(&$stmt, &$type);		
			for($i=0;$i<count($params);$i++)
				$stmtParams[$i+2]=&$params[$i];	
			if($type!="")
				call_user_func_array('mysqli_stmt_bind_param', $stmtParams); 
			$stmt->execute();
			return $stmt;	
		}
		

		public function close(){
			unset($this->host);
			unset($this->user);
			unset($this->pass);
			unset($this->db);
			unset($this->core);
			unset($this);
		}
		public function __destruct() {
			$this->close();
		}
	
	}
	
	class TMysqLiResult
	{
		public $crtRowAdd=0;
		public $crtRowGet=0;
		public $theArray=array();
		public $field_count=-1;
		public $row_count=-1;
		
		public function addArray($aArray)
		{
			if($this->field_count!=-1 && $this->field_count!=sizeof($aArray))
				//return;
				throw new Exception("Fatal Error! diferent array length given");			
			$this->field_count=sizeof($aArray);
			$anotherArray=array();
			for($i=0;$i<$this->field_count;$i++)
				$anotherArray[$i]=$aArray[$i];
			$this->theArray[$this->crtRowAdd]=$anotherArray;
			$this->crtRowAdd++;	
			$this->row_count=$this->crtRowAdd;
			
		}
		
		public function nextRow()
		{
			if($this->crtRowAdd==$this->crtRowGet)
				return null;
			$row=$this->theArray[$this->crtRowGet];
			$this->crtRowGet++;
			return $row;
		}	
		public function fetch_array()
		{
			return $this->nextRow();
		}
		public function close()
		{
			unset($this->crtRowAdd);
			unset($this->crtRowGet);
			unset($this->theArray);
			unset($this);
		}
		public function allArrays()
		{
			$arrs=array();
			while($r=$this->nextRow())
				array_push($arrs, $r);
			return $arrs;
		}
		
		public function __destruct() {
			$this->close();
		}
		public function __toString()
		{
			$tostr="TMysqLiResult(fields=".$this->field_count.", rows=".$this->crtRowAdd."<br>";
			for($i=0; $i<$this->crtRowAdd; $i++)
			{
				$tostr.="rows [".$i."] =";
				for($j=0; $j<$this->field_count; $j++)
					$tostr.=" '".$this->theArray[$i][$j]."' ";				
				$tostr.=($i+1<$this->crtRowAdd)?";<br>":";";				
			}
			return $tostr.")";
		}
	}

?>