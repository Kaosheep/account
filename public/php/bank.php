<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json"); 
try{
  require_once("./connect.php");
  $data = json_decode(file_get_contents('php://input'));
  
  $type = $data->type;
  $full = $data->full;
  if($type == "3"){
      $start = $data->start;
      $end = $data->end;
  }


  if($type == "1"){
      $sql = "select m.m_id, m.m_name,sum(c.con_sum) sum,m.m_ord,m.t,s.sub_name,s.s_id from con_detail c join maintype m on c.m_id = m.m_id 
      join sub_type s on c.s_id = s.s_id WHERE m.t=1 and MONTH(con_day) = MONTH(:day) group by s.s_id"; 

      $sql2 = "select m.m_id, m.m_name,c.con_sum,m.m_ord,m.t,s.sub_name,s.s_id,con_day from con_detail c join maintype m on c.m_id = m.m_id join sub_type s on c.s_id = s.s_id WHERE m.t=1 and MONTH(con_day) = MONTH(:day) order by con_day DESC"; 
      $dlt = $pdo->prepare($sql);
      $dlt->bindValue(":day", $full);
      $dlt2 = $pdo->prepare($sql2);
      $dlt2->bindValue(":day", $full);
  }elseif($type == "2"){
    $sql = "select m.m_id, m.m_name,sum(c.con_sum) sum,m.m_ord,m.t,s.sub_name,s.s_id from con_detail c 
      join maintype m on c.m_id = m.m_id 
      join sub_type s on c.s_id = s.s_id WHERE m.t=1 and YEAR(con_day) = YEAR(:day) group by s.s_id"; 
  
      $sql2 = "select m.m_id, m.m_name,c.con_sum,m.m_ord,m.t,s.sub_name,s.s_id,con_day from con_detail c join maintype m on c.m_id = m.m_id join sub_type s on c.s_id = s.s_id WHERE m.t=1 and YEAR(con_day) = YEAR(:day) order by con_day DESC"; 
    $dlt = $pdo->prepare($sql);
    $dlt->bindValue(":day", $full);
    $dlt2 = $pdo->prepare($sql2);
      $dlt2->bindValue(":day", $full);
  }elseif($type == "3"){
    $sql = "select m.m_id, m.m_name,sum(c.con_sum) sum,m.m_ord,m.t,s.sub_name,s.s_id from con_detail c 
      join maintype m on c.m_id = m.m_id 
      join sub_type s on c.s_id = s.s_id WHERE m.t=1 and con_day BETWEEN :start AND :end group by s.s_id"; 
      $sql2 = "select m.m_id, m.m_name,c.con_sum,m.m_ord,m.t,s.sub_name,s.s_id,con_day from con_detail c join maintype m on c.m_id = m.m_id join sub_type s on c.s_id = s.s_id WHERE m.t=1 and con_day BETWEEN :start AND :end order by con_day DESC"; 
    $dlt = $pdo->prepare($sql);
    $dlt->bindValue(":start", $start);
    $dlt->bindValue(":end", $end);
    $dlt2 = $pdo->prepare($sql2);
    $dlt2->bindValue(":start", $start);
    $dlt2->bindValue(":end", $end);
  }
  
  $dlt->execute();
  $dlt2->execute();
  

  
  if ($dlt->rowCount() === 0) { 
    $dlts = [] ;
    $dlts2 = [];
  } else {
    $dlts = $dlt->fetchAll(PDO::FETCH_ASSOC);
    $dlts2 = $dlt2->fetchAll(PDO::FETCH_ASSOC);
  }
    $dltarr = array("1" => $dlts, "2" => $dlts2);
    echo json_encode($dltarr);

  
} catch (PDOException $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
	  echo "錯誤原因 : ", $e->getMessage(), "<br>";
}
?>