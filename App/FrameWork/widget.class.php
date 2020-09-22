<?php
class widget {

	//输出数据库查询的2维表
	public static function printArr($arr)
	{
		$title = array_keys($arr[0]);

		echo "<table>";
		echo "</tr>";
		    foreach ($title as $v ){echo "<td>$v</td>"; }
		echo "</tr>";
		echo "\n\n";

		foreach ($arr as $row)
		{
		    echo '<tr>';    
		    foreach ($row as $r){
		            echo "<td>$r</td>";    
		    }
		    echo "</tr>";
		    echo "\n\n";
		}
		echo "</table>";
	}

}
?>