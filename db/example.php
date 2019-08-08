<?php 
  error_reporting(E_ALL ^ E_NOTICE); 

  include('class.oracle.php'); 
  $ora = new ORACLE(); //::CreateInstance("XE", "olton", "yfnfkmz", "RUSSIAN_CIS.AL32UTF8"); 
  $ora->Connect("XE", "olton", "yfnfkmz"); 
   
  $ora->SetFetchMode(OCI_ASSOC); 
  $ora->SetAutoCommit(true); 
                       
   
//  $ora->Update("t1", array("id"=>":id", "name"=>":name"), "name='ttt'", array(":id"=>2, ":name"=>"tt2")); 

  /* Select tests *************************************************************************************/ 
  echo "Select tests...\n"; 
  echo "select sysdate from dual\n"; 
  $h = $ora->Select("select sysdate from dual"); 
  $r = $ora->FetchArray($h); 
  var_dump($r); 
  echo "Select with binding vars test\n"; 
  echo "select * from test where dummy = :dummy\n"; 
  echo "Binding :dummy as moon\n"; 
  $h = $ora->Select("select * from test where dummy = :dummy", array(":dummy"=>"moon")); 
  $r = $ora->FetchArray($h); 
  var_dump($r); 
  /***************************************************************************************************/ 
   
  /* Insert tests ************************************************************************************/ 
  echo "Insert tests...\n"; 
  echo "insert into test(id, dummy) values(:id, :dummy); /* binding data with id=2010, dummy=November*/\n"; 
  $bind = array(":id"=>2010, ":dummy"=>"'November'"); 
  $r = $ora->Insert("test", array("id"=>":id", "dummy"=>":dummy"), $bind); 
  var_dump($r); 
  echo "insert into test(id, dummy) values(:id, :dummy) returning id into :id_ret; /* binding data with id=2010, dummy=November*/\n";
  $bind = array(":id"=>2010, ":dummy"=>"'November'"); 
  $returning = array("id"=>"id_ret"); 
  $r = $ora->Insert("test", array("id"=>":id", "dummy"=>":dummy"), $bind, $returning); 
  var_dump($r); 
  /***************************************************************************************************/ 
   
  /* Update tests ************************************************************************************/ 
  echo "Update tests...\n"; 
  echo "without binding... update test set id=9 where id=1\n"; 
  $ora->Update("test", array("id"=>9), "id=1"); 
  echo "with binding... update test set id=:id where id=1\n"; 
  $bind = array(":id"=>10); 
  $ora->Update("test", array("id"=>":id"), "id=9", $bind); 
  echo "with binding and returning... update test set id=:id where id=1 returning id into :ret_id\n"; 
  $bind = array(":id"=>11); 
  $ret = array("id"=>"ret_id"); 
  $r = $ora->Update("test", array("id"=>":id"), "id=10", $bind, $ret); 
  var_dump($r); 
  /***************************************************************************************************/ 
   
  /* Functions tests *********************************************************************************/ 
  echo "Stored Function test...\n"; 
  $bind = array(":test"=>"'test function'"); 
  $result = $ora->Func("test_f", array(":test"), $bind); 
  var_dump($result); 
  /***************************************************************************************************/ 
   
  /* Stored Procedures tests *************************************************************************/ 
  echo "Stored Procedure test...\n"; 
  $bind = array(":r"=>""); 
  $ora->StoredProc("test_p", array("'test'", ":r"), $bind); 
  var_dump($bind[":r"]); 
  /***************************************************************************************************/ 
   
  /* Cursor tests ************************************************************************************/ 
  echo "Cursor tests...\n"; 
  echo "get Cursor from stored_proc with binding as :data\n"; 
  echo "begin utils.get_cursor(:dataset); end;\n"; 
  $cursor = $ora->Cursor("util.get_cursor", "data"); 
  if ($cursor) { 
    while($r = $ora->FetchRow($cursor)){     
      var_dump($r); 
    } 
    $ora->FreeStatement($cursor); 
  } else { 
      echo "Beee...\n"; 
  } 
  /***************************************************************************************************/ 
   
  /* Collections tests *******************************************************************************/ 
  echo "Collections tests...\n"; 
  $coll1 = $ora->NewCollection("DOMAIN_NAMES_COLTYPE"); 
  $coll2 = $ora->NewCollection("DOMAIN_NAMES_COLTYPE"); 
   
  $coll1->append("t1"); 
  $coll1->append("t2"); 
  $coll1->append("t3"); 
  $coll1->append("t4"); 
   
   
  echo "Return collection from StoredProc...\n"; 
  $bind = array(":coll1"=>$coll1, ":coll2"=>$coll2); 
   
  $ora->StoredProc("domain_check", array(":coll1", ":coll2"), $bind);   

  for($i = 0; $i<$coll2->size(); $i++) 
  var_dump($coll2->getElem($i)); 
   
  echo "Return count of collection elements transfered into StoredProc...\n"; 
  $bind = array(":coll1"=>$coll1, ":coll2"=>""); 
  $ora->StoredProc("domain_check2", array(":coll1", ":coll2"), $bind);   
  var_dump($bind[":coll2"]); 
  /***************************************************************************************************/ 
   
   
  $ora->DumpQueriesStack(); 
   
  $ora->Bye(); 
?> 