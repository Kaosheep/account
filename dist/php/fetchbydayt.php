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
  if($type == "4"){
      $start = $data->start;
      $end = $data->end;
  }


  if($type == "1"){
    $sql = "select m.m_id, m.m_name,sum(c.con_sum) sum,m.m_ord,m.t from con_detail c 
      join maintype m on c.m_id = m.m_id 
      join sub_type s on c.s_id = s.s_id WHERE m.t=0 and WEEK(con_day, 1) = WEEK(:day, 1) group by m_id order by m.m_ord"; 
      $dlt = $pdo->prepare($sql);
      $dlt->bindValue(":day", $full);
  }elseif($type == "2"){
    $sql = "select m.m_id, m.m_name,sum(c.con_sum) sum,m.m_ord,m.t from con_detail c 
    join maintype m on c.m_id = m.m_id 
    join sub_type s on c.s_id = s.s_id WHERE m.t=0 and MONTH(con_day) = MONTH(:day) group by m_id order by m.m_ord"; 
    $dlt = $pdo->prepare($sql);
    $dlt->bindValue(":day", $full);
  }elseif($type == "3"){
    $sql = "select m.m_id, m.m_name,sum(c.con_sum) sum,m.m_ord,m.t from con_detail c 
    join maintype m on c.m_id = m.m_id 
    join sub_type s on c.s_id = s.s_id WHERE m.t=0 and YEAR(con_day) = YEAR(:day) group by m_id order by m.m_ord"; 
    $dlt = $pdo->prepare($sql);
    $dlt->bindValue(":day", $full);
  }elseif($type == "4"){
    $sql = "select m.m_id, m.m_name,sum(c.con_sum) sum,m.m_ord,m.t from con_detail c 
    join maintype m on c.m_id = m.m_id 
    join sub_type s on c.s_id = s.s_id WHERE m.t=0 and con_day BETWEEN :start AND :end group by m_id order by m.m_ord"; 
    $dlt = $pdo->prepare($sql);
    $dlt->bindValue(":start", $start);
    $dlt->bindValue(":end", $end);
  }
  
  $dlt->execute();
  

  
  if ($dlt->rowCount() === 0) { 
    $dlts = 0;
  } else {
    $dlts = $dlt->fetchAll(PDO::FETCH_ASSOC);
  }

    echo json_encode($dlts);
  
} catch (PDOException $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
	  echo "錯誤原因 : ", $e->getMessage(), "<br>";
}
?>