<?php
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);
include DOCUMENT_ROOT.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'dt_init.php';
//include "db.php";
//include_once '..'.DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR.'Require'.DIRECTORY_SEPARATOR.'promotionRequire.class.php';
include_once '../App/Require/promotionRequire.class.php';
//if($dbh) echo "ert";
$orderList = array (
  0 =>
  array (
    'comm_id' => '40',
    'keyid' => 40,
    'commname' => 'Dreamtimes Q1晶萃面膜',
    'buynum' => 23,
    'zprice' => 414,
    'price' => '18.00',
    'newprice' => '18.00',
    'property' => '',
  ),
  1 =>
  array (
    'comm_id' => '64',
    'keyid' => '64-23_19',
    'commname' => 'Dreamtimes M2梦幻三部曲4件套（含自然款BB霜）',
    'buynum' => 1,
    'zprice' => 352,
    'price' => '352.00',
    'newprice' => '352.00',
    'property' => '【关联:关联】',
  ),
  2 =>
  array (
    'comm_id' => '32032',
    'keyid' => 32032,
    'commname' => 'Dreamtimes K2男士乳液',
    'buynum' => 2,
    'zprice' => 668,
    'price' => '334.00',
    'newprice' => '334.00',
    'property' => '',
  ),
  3 =>
  array (
    'comm_id' => '39',
    'keyid' => 39,
    'commname' => 'Dreamtimes HD高清五合一 BB霜（无痕）',
    'buynum' => 4,
    'zprice' => 372,
    'price' => '93.00',
    'newprice' => '93.00',
    'property' => '',
  ),
  4 =>
  array (
    'comm_id' => '38',
    'keyid' => 38,
    'commname' => 'Dreamtimes HD高清五合一 BB霜（自然）',
    'buynum' => 1,
    'zprice' => 93,
    'price' => '93.00',
    'newprice' => '93.00',
    'property' => '',
  ),
  5 =>
  array (
    'comm_id' => '83010',
    'keyid' => '83010-23_19',
    'commname' => 'Dreamtimes M3梦幻三部曲',
    'buynum' => 1,
    'zprice' => 331,
    'price' => '331.00',
    'newprice' => '331.00',
    'property' => '【关联:关联】',
  ),
);

echo <<<___END
<!DOCTYPE html>
<html lang="zh-en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <title>Promotion测试</title>
  <link rel="icon" type="image/x-icon" href="/favicon.ico">
  <link rel="stylesheet" href="/template/bootstrap/css/bootstrap.min.css">
<style>
td {
border-bottom: 1px solid #a0a0a0;
border-right: 1px solid #a0a0a0;
}</style>
<body>
<table>
___END;

echo "<h3>促销规则</h3>";
promotionRequire::getRules( $dbh );
//echo json_encode(promotionRequire::$pmt_rules, JSON_UNESCAPED_UNICODE);
printArr( promotionRequire::$pmt_rules );
//printArr( $rules );

echo "<h3>订单详情</h3>";
printArr( $orderList );

echo "<h3>促销结果集</h3>";
promotionRequire::process( $orderList );
var_export(promotionRequire::$pmt_result);
if(isset(promotionRequire::$pmt_result['P'])) printArr( promotionRequire::$pmt_result['P'] );
if(isset(promotionRequire::$pmt_result['L'])) printArr( promotionRequire::$pmt_result['L'] );
if(isset(promotionRequire::$pmt_result['T'])) printArr( promotionRequire::$pmt_result['T'] );

//总金额
$totalAmount = 0;
foreach( $orderList as $k => $v ){
		$totalAmount +=  $v['buynum'] * $v['price'];
}

//优惠后金额
$reduced_value = 0;
if(isset(promotionRequire::$pmt_result['P'])) {
	foreach( promotionRequire::$pmt_result['P'] as $k => $v ){
		$reduced_value += $v['reduced_value'];
	}
}
$totalAmountAfterPromotion = $totalAmount + $reduced_value;//优惠后金额



$freight = promotionRequire::getFreightAfterPromotion( $totalAmountAfterPromotion ) ;
echo "<br /><h3>订单总金额: {$totalAmount} </h3>";
echo "<br /><h3>优惠后金额: {$totalAmountAfterPromotion} </h3>";

if( is_null($freight))
	echo "<br /><h3>促销期间运费: 无限制 </h3>";
else
	echo "<br /><h3>促销期间运费: {$freight} </h3>";


	//sql查询结果输出到表格 zht 170106
	function printArr( $arr=array(), $id='' ){

			if( empty($arr) ) {$table = '<table><tr><td>没有数据</td></tr></table>'; goto printArrEnd;}

	    $i = 0;
	    $id = empty($id)? '' : 'id="'.$id.'"';
	    $table= "<table {$id} class='table table-bordered' style='border-color: #efefef;' border='1px' cellpadding='10px' cellspacing='0px'>";
	    foreach ($arr as $row)
	    {
	        if ($i==0){
            $title = array_keys($row);
            $table.= '<tr>';
            foreach ($title as $v ){$table.= "<th style='padding:5px;'>$v</th>"; }
            $table.= "</tr>";
	        }
	        $table.= "<tr>";
	        foreach ($row as $r){
	          $table.= "<td  style='padding:5px;'>$r</td>";
	        }
	        $table.= "</tr>";
	        $table.= "\n\n";
	        $i++;
	    }
	    $table.= "</table>";
	printArrEnd:
	    echo $table;

	}

echo <<<___END
</body>
</html>
___END;

?>
