<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json"); 
try{
	require_once("./connect.php");

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if($input["mod"]== 1){

    $sql = "insert into con_detail (con_day, m_id, con_sum, s_id) values (:con_day, :m_id, :con_sum, :s_id)";

    $newdlt = $pdo->prepare($sql);
    $newdlt->bindValue(":con_day", $input["con_day"]);
    $newdlt->bindValue(":m_id", $input["m_id"]);
    $newdlt->bindValue(":con_sum", $input["con_sum"]);
    $newdlt->bindValue(":s_id", $input["s_id"]);

    $newdlt->execute();

    echo json_encode("新增成功");  

    }elseif($input["mod"]== 2){

    $sql = "update con_detail set con_day=:con_day, m_id=:m_id, con_sum=:con_sum,s_id=:s_id where con_id=:con_id";

    $upd = $pdo->prepare($sql);

    $upd->bindValue(":con_day", $input["con_day"]);
    $upd->bindValue(":m_id", $input["m_id"]);
    $upd->bindValue(":con_sum", $input["con_sum"]);
    $upd->bindValue(":s_id", $input["s_id"]);
    $upd->bindValue(":con_id", $input["con_id"]);

    $upd->execute();
    echo json_encode("修改成功");  

    }elseif($input["mod"]== 3){
        
    $sql = "DELETE FROM con_detail where con_id=:con_id";

    $del = $pdo->prepare($sql);
    $del->bindValue(":con_id", $input["con_id"]);

    $del->execute();
    echo json_encode("刪除成功");  

    }
    

  
} catch (PDOException $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
	  echo "錯誤原因 : ", $e->getMessage(), "<br>";
}
?>