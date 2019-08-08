<?php

class Database{

	private $db_host = "localhost";
	private $db_user = "root";
	private $db_pass = "";
	private $db_name = "qr-code-register";
	
	private $con = false; 
    private $myconn = ""; 
	private $result = array(); 
    private $myQuery = "";
    private $numResults = "";
	
	// Connection 
	public function connect(){
		if(!$this->con){
			$this->myconn = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name); 
		//	mysqli_set_charset($this->con,"utf8");
            if($this->myconn->connect_errno > 0){
                array_push($this->result,$this->myconn->connect_error);
                return false; 
            }else{
				$this->myconn->set_charset("utf8");
                $this->con = true;
                return true; 
			} 
			
        }else{  
            return true; 
        }  	
	}
	
	// Disconnect
    public function disconnect(){
    	
    	if($this->con){
    		if($this->myconn->close()){
    			$this->con = false;
				return true;
			}else{
				return false;
			}
		}
    }
	
	public function sql($sql){
		
		$query = $this->myconn->query($sql);
        $this->myQuery = $sql; 
		if($query){
			$this->numResults = $query->num_rows;
			for($i = 0; $i < $this->numResults; $i++){
				$r = $query->fetch_array();
               	$key = array_keys($r);
               	for($x = 0; $x < count($key); $x++){
                   	if(!is_int($key[$x])){
                   		if($query->num_rows >= 1){
                   			$this->result[$i][$key[$x]] = $r[$key[$x]];
						}else{
							$this->result = null;
						}
					}
				}
			}
			return true; // Successful
		}else{
			array_push($this->result,$this->myconn->error);
			return false; // No rows
		}
	}
	
	// SELECT
	public function jsonSelect($table){
		$q=$table;
        $this->myQuery = $q; 
        if(empty($q)){
			return false; 
		}else{
        	$query = $this->myconn->query($q);    
			if($query){
				$this->numResults = $query->num_rows;
				for($i = 0; $i < $this->numResults; $i++){
					$r = $query->fetch_array();
                	$key = array_keys($r);
                	for($x = 0; $x < count($key); $x++){
                    	if(!is_int($key[$x])){
                    		if($query->num_rows >= 1){
                    			$this->result[$i][$key[$x]] = $r[$key[$x]];
							}else{
								$this->result[$i][$key[$x]] = null;
							}
						}
					}
				}
				return true; // Successful
			}else{
				array_push($this->result,$this->myconn->error);
				return false; // No rows
			}
      	}
    }
	
	// Insert
    public function insert($table,$params=array()){
    	 if(empty($table)){
			return false;
		}else{
    	 	$sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';
            $this->myQuery = $sql;
            if($ins = $this->myconn->query($sql)){
            	array_push($this->result,$this->myconn->insert_id);
                return true; // exectued correctly
            }else{
            	array_push($this->result,$this->myconn->error);
                return false; // did not execute correctly
            }
        }
    }
	
	// Delete
    public function delete($table,$where = null){
    	if(empty($table)){
			return false;
		}else{

    	 	if($where == null){
                $delete = 'DELETE '.$table; 
            }else{
                $delete = 'DELETE FROM '.$table.' WHERE '.$where; 
            }
            
            if($del = $this->myconn->query($delete)){
            	array_push($this->result,$this->myconn->affected_rows);
                $this->myQuery = $delete; 
                return true; // exectued correctly
            }else{
            	array_push($this->result,$this->myconn->error);
               	return false; // did not execute correctly
            }
        }
    }
	
	// Update
    public function update($table,$params=array(),$where){
    	if(empty($table)){
			return false;
		}else{
            $args=array();
			foreach($params as $field=>$value){
				$args[]=$field.'="'.$value.'"';
			}
			$sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
            $this->myQuery = $sql; 
            if($query = $this->myconn->query($sql)){
            	array_push($this->result,$this->myconn->affected_rows);
            	return true; // exectued correctly
            }else{
            	//array_push($this->result,$this->myconn->error);
                return $sql;//false; // did not execute correctly
            }
        }
    }
	
	
	// return data
    public function getResult(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }
	
    //Pass SQL back for debugging
    public function getSql(){
        $val = $this->myQuery;
        $this->myQuery = array();
        return $val;
    }

    //Pass number of rows back
    public function numRows(){
        $val = $this->numResults;
        $this->numResults = array();
        return $val;
    }

    // Escape your string
    public function escapeString($data){
        return $this->myconn->real_escape_string($data);
    }
} 
