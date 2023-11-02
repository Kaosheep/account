<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json"); 
try{
	require_once("./connect.php");

    $sql = "select * from maintype order by m_ord"; 
    $typ = $pdo->query($sql);
    $typ->execute();
    
    $sql2 = 
    "select * from sub_type s join maintype m on s.m_id = m.m_id
    "; 
    $styp = $pdo->query($sql2);
    $styp->execute();

    $typs = $typ->fetchAll(PDO::FETCH_ASSOC);
    $styps = $styp->fetchAll(PDO::FETCH_ASSOC);

    $arr = array("typs" => $typs, "styps" => $styps);
    echo json_encode($arr);
      

  
} catch (PDOException $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
	  echo "錯誤原因 : ", $e->getMessage(), "<br>";
}
?>