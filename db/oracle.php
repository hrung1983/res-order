<?php
/***************************************************************************
 *                                oracle.php
 *                            -------------------
 *   begin                : Thrusday Feb 15, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: oracle.php,v 1.18.2.1 2002/11/26 11:42:12 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if(!defined("SQL_LAYER"))
{

define("SQL_LAYER","oracle");

class sql_db
{
	var $db_connect_id;
	var $query_result;
	var $in_transaction = 0;
	var $row = array();
	var $rowset = array();
	var $num_queries = 0;
	var $last_query_text = "";

	//
	// Constructor
	//
	function sql_db($sqlserver, $sqluser, $sqlpassword, $database="", $persistency = true)
	{
		//echo "xxxxxxxxxxxxx";
		$this->persistency = $persistency;
		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;

		if($this->persistency)
		{
			$this->db_connect_id = OCIPLogon($this->user, $this->password, $this->server);
		}
		else
		{
			$this->db_connect_id = OCINLogon($this->user, $this->password, $this->server);
		}
		if($this->db_connect_id)
		{
			return $this->db_connect_id;
		}
		else
		{
			$opt = '<br/><br/><br/>
			<table align="center" width="500" style="border: 1px solid #FF0000; background-color: #FFD9D9">
				<tr height="120">
					<td align="center"><font size="2px"  face="MS Sans Serif" color="#FF0000">ติดต่อฐานข้อมูลไม่ได้</font></td>
				</tr>
			</table>';
			echo $opt;
			return false;
			exit();
		}
	}

	//
	// Other base methods
	//
	function sql_close()
	{
		if($this->db_connect_id)
		{
			// Commit outstanding transactions
			if($this->in_transaction)
			{
				OCICommit($this->db_connect_id);
			}

			if($this->query_result)
			{
				@OCIFreeStatement($this->query_result);
			}
			$result = @OCILogoff($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}


	//
	// Base query method
	//
	function sql_query($query = "", $transaction = FALSE, $bypass = FALSE)
	{
		// Remove any pre-existing queries
		$query = trim($query);
		unset($this->query_result);        
		// Put us in transaction mode because with Oracle as soon as you make a query you're in a transaction
		$this->in_transaction = TRUE;

		if($query != "")
		{
			$query = str_replace(array('"', 'GETDATE()', 'NOW()'), array('\'', 'SYSDATE', 'SYSDATE'), $query);
			$this->last_query = $query;
			$this->num_queries++;

			if(eregi("LIMIT", $query))
			{
				preg_match("/^(.*)LIMIT ([0-9]+)[, ]*([0-9]+)*/s", $query, $limits);

				$query = $limits[1];
				if($limits[3])
				{
					$row_offset = $limits[2];
					$num_rows = $limits[3];
				}
				else
				{
					$row_offset = 0;
					$num_rows = $limits[2];
				}
				if(eregi("SELECT", $query)){
					$query = "SELECT * FROM (SELECT ORC.*, ROWNUM RNUM FROM (".$query." ) ORC WHERE ROWNUM <= ".($row_offset+$num_rows).") WHERE RNUM > ".$row_offset;
				}             
			}
			if(eregi("^(INSERT|UPDATE) ", $query))
			{
				$query = preg_replace("/\\\'/s", "''", $query);
			}

            
			$this->query_result = @OCIParse($this->db_connect_id, $query);
			$success = @OCIExecute($this->query_result, OCI_DEFAULT);
		}else return false;
		if($success)
		{
			if($transaction == END_TRANSACTION)
			{
				@OCICommit($this->db_connect_id);
				$this->in_transaction = FALSE;
			}

			unset($this->row[$this->query_result]);
			unset($this->rowset[$this->query_result]);
			$this->last_query_text[$this->query_result] = $query;

			return $this->query_result;
		}
		else
		{
			if($this->in_transaction)
			{
				@OCIRollback($this->db_connect_id);
			}
			return false;
		}
	}

	//
	// Other query methods
	//
	//function sql_numrows($query = "", $transaction = FALSE)
	function sql_numrows($query_id = 0)
	{
			if(!$query_id)
			{
				$query_id = $this->query_result;
			}
			if($query_id && $this->last_query_text[$query_id] != "") {
				$query=$this->last_query_text[$query_id];
			}
			//if (  substr(strtoupper($query),0,7)=="SELECT " && ($id2=strpos(strtoupper($query)," FROM "))!==FALSE  ) {
			//if (  substr(strtoupper($query),0,7)=="SELECT " && ($id2=strpos(strtoupper($query)," FROM"))!==FALSE  ) {
			if ( substr(strtoupper($query),0,6)=="SELECT" ) {
				//$query="SELECT COUNT(*) AS NUMROW ".substr($query,$id2);
				$query="SELECT COUNT(*) AS NUMROW  FROM (".$query.")";
			}
		//	echo $query;
          
            
			$statement = OCIParse ($this->db_connect_id,  $query);
			@OCIExecute ($statement);
			if (OCIFetchInto ($statement, $row, OCI_ASSOC)) {
                  
			   return $row['NUMROW'];
			} else {
				return false;
			}		
	}

	function sql_numrowss($query = "", $transaction = FALSE)
	{
// Remove any pre-existing queries
		unset($this->query_result);

		// Put us in transaction mode because with Oracle as soon as you make a query you're in a transaction
		$this->in_transaction = TRUE;

		if($query != "")
		{
			$this->last_query = $query;
			//$query = $this->last_query ;
			$this->num_queries++;

			if(eregi("LIMIT", $query))
			{
				preg_match("/^(.*)LIMIT ([0-9]+)[, ]*([0-9]+)*/s", $query, $limits);

				$query = $limits[1];
				if($limits[3])
				{
					$row_offset = $limits[2];
					$num_rows = $limits[3];
				}
				else
				{
					$row_offset = 0;
					$num_rows = $limits[2];
				}
				/*
				if(eregi("SELECT", $query)){
					$query = "SELECT * FROM (SELECT P.*, ROWNUM RNUM FROM (".$query." ) P WHERE ROWNUM <= ".($row_offset+$num_rows).") WHERE RNUM > ".$row_offset;
				}
				*/
			}

			if(eregi("^(insERT|UPdate) ", $query))
			{
				$query = preg_replace("/\\\'/s", "''", $query);
			}
			//$query = str_replace("*", "count(*) as num" ,$query);
			//echo $query;
			//$this->query_result = @OCIParse($this->db_connect_id, $query);
			//$success = @OCIExecute($this->query_result, OCI_DEFAULT);
			$query_result = $this->sql_query($query); // bank pro
			$rowsnum = $this->sql_fetchrow($query_result);  // bank pro
		}else return false;
		if($query_result)
		{
			//print_r($rowsnum);
			if($transaction == END_TRANSACTION)
			{
				@OCICommit($this->db_connect_id);
				$this->in_transaction = FALSE;
			}

			unset($this->row[$this->query_result]);
			unset($this->rowset[$this->query_result]);
			$this->last_query_text[$this->query_result] = $query;

			//return $this->query_result;
			return $rowsnum["num"];
		}
		else
		{
			if($this->in_transaction)
			{
				@OCIRollback($this->db_connect_id);
			}
			return false;
		}
		
	}
	function sql_affectedrows($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @OCIRowCount($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_numfields($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @OCINumCols($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldname($offset, $query_id = 0)
	{
		// OCIColumnName uses a 1 based array so we have to up the offset by 1 in here to maintain
		// full abstraction compatibitly
		$offset += 1;
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = strtolower(@OCIColumnName($query_id, $offset));
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldtype($offset, $query_id = 0)
	{
		// This situation is the same as fieldname
		$offset += 1;
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @OCIColumnType($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchrow($query_id = 0, $debug = FALSE, $bypass = FALSE)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result_row = "";
			$result = @OCIFetchInto($query_id, $result_row, OCI_ASSOC+OCI_RETURN_NULLS);
			if($debug){
				echo "Query was: ".$this->last_query . "<br>";
				echo "Result: $result<br>";
				echo "Query ID: $query_id<br>";
				echo "<pre>";
				var_dump($result_row);
				echo "</pre>";
			}
			if( eregi("^SELECT.+FROM[[:space:]][\"]?([a-zA-Z0-9\_\-]+)[\"]?", $this->last_query, $tablename)) {
				$tablename = $tablename[1];
			}
			if($result_row == "")
			{
				return false;
			}

			for($i = 0; $i < count($result_row); $i++)
			{
				list($key, $val) = each($result_row);
				$return_arr[strtolower($key)] = $val;
			}
			$this->row[$query_id] = $return_arr;

			return $this->row[$query_id];
		}
		else
		{
			return false;
		}
	}


	// This function probably isn't as efficant is it could be but any other way I do it
	// I end up losing 1 row...
	function sql_fetchrowset($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			if( eregi("^SELECT.+FROM[[:space:]][\"]?([a-zA-Z0-9\_\-]+)[\"]?", $this->last_query, $tablename)) {
				$tablename = $tablename[1];
			}
			$rows = @OCIFetchStatement($query_id, $results);
			@OCIExecute($query_id, OCI_DEFAULT);
			for($i = 0; $i < $rows; $i++)
			{
				@OCIFetchInto($query_id, $tmp_result, OCI_ASSOC+OCI_RETURN_NULLS);

				for($j = 0; $j < count($tmp_result); $j++)
				{
					list($key, $val) = each($tmp_result);
					$return_arr[strtolower($key)] = $val;
				}
				$result[] = $return_arr;
			}
			return $result;   
		}
		else
		{
			return false;
		}
	}
	function sql_fetchfield($field, $rownum = -1, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			if($rownum > -1)
			{
				// Reset the internal rownum pointer.
				@OCIExecute($query_id, OCI_DEFAULT);
				for($i = 0; $i < $rownum; $i++)
				  {
						// Move the interal pointer to the row we want
						@OCIFetch($query_id);
				  }
				// Get the field data.
				$result = @OCIResult($query_id, strtoupper($field));
			}
			else
			{
				// The internal pointer should be where we want it
				// so we just grab the field out of the current row.
				$result = @OCIResult($query_id, strtoupper($field));
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_rowseek($rownum, $query_id = 0)
	{
		if(!$query_id)
		{
				$query_id = $this->query_result;
		}
		if($query_id)
		{
				@OCIExecute($query_id, OCI_DEFAULT);
			for($i = 0; $i < $rownum; $i++)
				{
					@OCIFetch($query_id);
				}
			$result = @OCIFetch($query_id);
			return $result;
		}
		else
		{
				return false;
		}
	}
	function sql_nextid($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id && $this->last_query_text[$query_id] != "")
		{
			if( eregi("^(INSERT{1}|^INSERT INTO{1})[[:space:]][\"]?([a-zA-Z0-9\_\-]+)[\"]?", $this->last_query_text[$query_id], $tablename))
			{
				$query = "SELECT ".$tablename[2]."_id_seq.currval FROM DUAL";
				$stmt = @OCIParse($this->db_connect_id, $query);
				@OCIExecute($stmt,OCI_DEFAULT );
				$temp_result = @OCIFetchInto($stmt, $temp_result, OCI_ASSOC+OCI_RETURN_NULLS);
				if($temp_result)
				{
					return $temp_result['CURRVAL'];
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	function sql_freeresult($query_id = 0)
	{
		if(!$query_id)
		{
				$query_id = $this->query_result;
		}
		if($query_id)
		{
				$result = @OCIFreeStatement($query_id);
				return $result;
		}
		else
		{
				return false;
		}
	}
	function sql_error($query_id  = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		$result  = @OCIError($query_id);
		return $result;
	}
    function sql_insert($tablename,$col,$val,$transaction=false){
           $sql="insert into ".$tablename." (".implode(', ', $col).") VALUES(".implode(', ', $val).")";      
           $this->sql_query($sql,$transaction); 
    }
    function sql_update($tablename,$val,$where,$transaction=false){
        
         $sql="update ".$tablename." set ".implode(', ', $val) ;          
         $sql.= empty($where)?'':" where ".trim($where);  
         echo $sql;    
        $this->sql_query($sql,$transaction); 
    }
    function sql_delete($tablename,$where,$transaction=false){          
           $sql="delete from ".$tablename. " ";
           $sql.= empty($where)?"":" where ".trim($where);                       
           $this->sql_query($sql,$transaction); 
    }

} // class sql_db

} // if ... define

?>