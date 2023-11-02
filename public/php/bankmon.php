<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json"); 
try{
  require_once("./connect.php");
  $data = json_decode(file_get_contents('php://input'));
  $limit = intval($data->limit);

  if($limit == 6){
    $sql = "SELECT 
  IFNULL(SUM(cd.con_sum), 0) AS sum, 
  mt.t, 
  all_months.month AS month 
FROM 
  maintype mt 
CROSS JOIN (
    SELECT DISTINCT DATE_FORMAT(con_day, '%Y-%m') AS month
    FROM con_detail
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 2 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 3 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 4 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 5 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 6 MONTH), '%Y-%m') AS month
) AS all_months
LEFT JOIN 
  (SELECT 
      con_sum, 
      m_id, 
      DATE_FORMAT(con_day, '%Y-%m') AS con_month 
   FROM con_detail) cd 
ON 
  mt.m_id = cd.m_id AND all_months.month = cd.con_month 
WHERE 
  mt.t = 1
GROUP BY 
  month 
ORDER BY 
  month DESC limit 6";

  $sql2 = "SELECT 
  IFNULL(SUM(cd.con_sum), 0) AS sum, 
  mt.t, 
  all_months.month AS month 
FROM 
  maintype mt 
CROSS JOIN (
    SELECT DISTINCT DATE_FORMAT(con_day, '%Y-%m') AS month
    FROM con_detail
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 2 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 3 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 4 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 5 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 6 MONTH), '%Y-%m') AS month
) AS all_months
LEFT JOIN 
  (SELECT 
      con_sum, 
      m_id, 
      DATE_FORMAT(con_day, '%Y-%m') AS con_month 
   FROM con_detail) cd 
ON 
  mt.m_id = cd.m_id AND all_months.month = cd.con_month 
WHERE 
  mt.t = 0
GROUP BY 
  month 
ORDER BY 
  month DESC limit 6";
  }elseif($limit == 12){
    $sql = "SELECT 
  IFNULL(SUM(cd.con_sum), 0) AS sum, 
  mt.t, 
  all_months.month AS month 
FROM 
  maintype mt 
CROSS JOIN (
    SELECT DISTINCT DATE_FORMAT(con_day, '%Y-%m') AS month
    FROM con_detail
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 2 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 3 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 4 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 5 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 6 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 7 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 8 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 9 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 10 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 11 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 12 MONTH), '%Y-%m') AS month
) AS all_months
LEFT JOIN 
  (SELECT 
      con_sum, 
      m_id, 
      DATE_FORMAT(con_day, '%Y-%m') AS con_month 
   FROM con_detail) cd 
ON 
  mt.m_id = cd.m_id AND all_months.month = cd.con_month 
WHERE 
  mt.t = 1
GROUP BY 
  month 
ORDER BY 
  month DESC limit 12";

  $sql2 = "SELECT 
  IFNULL(SUM(cd.con_sum), 0) AS sum, 
  mt.t, 
  all_months.month AS month 
FROM 
  maintype mt 
CROSS JOIN (
    SELECT DISTINCT DATE_FORMAT(con_day, '%Y-%m') AS month
    FROM con_detail
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 2 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 3 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 4 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 5 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 6 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 7 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 8 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 9 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 10 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 11 MONTH), '%Y-%m') AS month
    UNION
    SELECT DISTINCT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 12 MONTH), '%Y-%m') AS month
) AS all_months
LEFT JOIN 
  (SELECT 
      con_sum, 
      m_id, 
      DATE_FORMAT(con_day, '%Y-%m') AS con_month 
   FROM con_detail) cd 
ON 
  mt.m_id = cd.m_id AND all_months.month = cd.con_month 
WHERE 
  mt.t = 0
GROUP BY 
  month 
ORDER BY 
  month DESC limit 12";
  }
  $dlt = $pdo->query($sql);
  $offset = 0; 
  $dlt->execute();
  
  $dlt2 = $pdo->query($sql2);
  $dlt2->execute();
  
  if ($dlt->rowCount() === 0) { 
    $dlts = 0;
    $dlts2 = 0;
  } else {
    $dlts = $dlt->fetchAll(PDO::FETCH_ASSOC);
    $dlts2 = $dlt2->fetchAll(PDO::FETCH_ASSOC);
  }
    $monarr = array("1" => $dlts, "2" => $dlts2);
    echo json_encode($monarr);

  
} catch (PDOException $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
	  echo "錯誤原因 : ", $e->getMessage(), "<br>";
}
?>