<?php 
mysql_connect('localhost','alkr','Z32fsFrZKR3AjBtE');
mysql_query('CREATE DATABASE IF NOT EXISTS charts');
mysql_select_db('charts');
mysql_query('CREATE TABLE IF NOT EXISTS charts (name VARCHAR(150), chart varchar(169), PRIMARY KEY (name))');
if(isset($_POST['new_name']) && $_POST['new_name'] != '')
	mysql_query('INSERT `charts` (name, chart) VALUES ("'.$_POST['new_name'].'","'.implode('', $_POST['values']).'")');
elseif(isset($_POST['send']) && $_POST['new_name'] == '')
	mysql_query('UPDATE `charts` set chart="'.implode('', $_POST['values']).'" WHERE name="'.$_POST['chart'].'"');
echo mysql_error();
$q = mysql_query('SELECT * FROM `charts`');
$charts = array();
while($r = mysql_fetch_assoc($q)) {
	$charts[] = $r;
}
$select = "<form method='POST'><select name='chart'><option data-chart=".implode(array_fill(0, 169, 1))."></option>";
foreach ($charts as $chart) {
	$select .= "<option data-chart='".$chart['chart']."' value='".$chart['name']."'>".$chart['name']."</option>";
}
$select .= "</select>";
?>
<style type="text/css">
table td {
	height: 30px;
	width: 30px;
	border: 1px solid #ccc;
	-ms-user-select: none;
	-moz-user-select: none;
	-khtml-user-select: none;
	-webkit-user-select: none;
}
td.fold {
	background: #f99;
}
td.check {
	background: #000;
}
td.raise {
	background: #9f9;
}
</style>
<?php
$cards = array_reverse(array(
	"AA","AKs","AQs","AJs","ATs","A9s","A8s","A7s","A6s","A5s","A4s","A3s","A2s",
	"AKo","KK","KQs","KJs","KTs","K9s","K8s","K7s","K6s","K5s","K4s","K3s","K2s",
	"AQo","KQo","QQ","QJs","QTs","Q9s","Q8s","Q7s","Q6s","Q5s","Q4s","Q3s","Q2s",
	"AJo","KJo","QJo","JJ","JTs","J9s","J8s","J7s","J6s","J5s","J4s","J3s","J2s",
	"ATo","KTo","QTo","JTo","TT","T9s","T8s","T7s","T6s","T5s","T4s","T3s","T2s",
	"A9o","K9o","Q9o","J9o","T9o","99","98s","97s","96s","95s","94s","93s","92s",
	"A8o","K8o","Q8o","J8o","T8o","98o","88","87s","86s","85s","84s","83s","82s",
	"A7o","K7o","Q7o","J7o","T7o","97o","87o","77","76s","75s","74s","73s","72s",
	"A6o","K6o","Q6o","J6o","T6o","96o","86o","76o","66","65s","64s","63s","62s",
	"A5o","K5o","Q5o","J5o","T5o","95o","85o","75o","65o","55","54s","53s","52s",
	"A4o","K4o","Q4o","J4o","T4o","94o","84o","74o","64o","54o","44","43s","42s",
	"A3o","K3o","Q3o","J3o","T3o","93o","83o","73o","63o","53o","43o","33","32s",
	"A2o","K2o","Q2o","J2o","T2o","92o","82o","72o","62o","52o","42o","32o","22",
	));
echo $select."<select name='action'><option value='1'>fold</option><option value='2'>check</option><option value='3'>raise</option></select><table>";
//row
for ($i=0; $i < 13; $i++) { 
	echo "<tr>";
	//col
	for ($j=1; $j <= 13; $j++) { 
		echo "<td class='fold'><input type='hidden' name='values[".($i*13+$j)."]' value='1'/>".array_pop($cards)."</td>";
	}
	echo "</tr>";
}
echo "</table><input type='text' name='new_name'/><input type='submit' name='send'/></form>";
?>
<script type="text/javascript" src="https://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
	$('td').click(function(){
		selected = $('select[name="action"] option:selected')
		$(this).attr('class','').addClass(selected.text()).find('input').val(selected.val())
	})
	$('select[name="chart"]').change(function(){
		val = $(this).find('option:selected').data('chart')
		for (var i = 0; i < 169; i++) {
			switch(val[i]) {
				case "1":
					$('td').eq(i).attr('class','').addClass('fold').find('input').val(1)
					break
				case "2":
					$('td').eq(i).attr('class','').addClass('check').find('input').val(2)
					break
				case "3":
					$('td').eq(i).attr('class','').addClass('raise').find('input').val(3)
					break
			}
		};
	})
</script>
