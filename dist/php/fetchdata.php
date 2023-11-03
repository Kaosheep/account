<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json"); 
try{
	require_once("./connect.php");
  $data = json_decode(file_get_contents('php://input'));
 
  $full = $data->full;
  $sql = "select * from con_detail c 
  join maintype m on c.m_id = m.m_id 
  join sub_type s on c.s_id = s.s_id
  where con_day=:con_day"; 
  $dlt = $pdo->prepare($sql);
  $dlt->bindValue(":con_day", $full);
  $dlt->execute();
  $sql2 = "select sum(con_sum) from con_detail where con_day=:con_day";
  $sum = $pdo->prepare($sql2);
  $sum->bindValue(":con_day", $full);
  $sum->execute();
  
  if ($dlt->rowCount() === 0) { 
    $dlts = 0;
  } else {
    $dlts = $dlt->fetchAll(PDO::FETCH_ASSOC);
  }

  if ($sum->rowCount() === 0) { 
    $result = 0;
  } else {
    $result = $sum->fetch(PDO::FETCH_ASSOC);
  }

    $arr = array("result" => $result, "data" => $dlts);
    echo json_encode($arr);
  
} catch (PDOException $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
	  echo "錯誤原因 : ", $e->getMessage(), "<br>";
}
?>