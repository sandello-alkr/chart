<?php 
mysql_connect('localhost','root','dff302dff302');
mysql_query('CREATE DATABASE IF NOT EXISTS charts');
mysql_select_db('charts');
mysql_query('CREATE TABLE IF NOT EXISTS charts (name VARCHAR(150), chart varchar(169), PRIMARY KEY (name))');
if(isset($_POST['new_name']) && $_POST['new_name'] != '')
	mysql_query('INSERT `charts` (name, chart) VALUES ("'.$_POST['new_name'].'","'.implode('', $_POST['values']).'")');
elseif(isset($_POST['send']) && $_POST['new_name'] == '')
	mysql_query('UPDATE `charts` set chart="'.implode('', $_POST['values']).'" WHERE name="'.$_POST['chart'].'")');
echo mysql_error();
$q = mysql_query('SELECT * FROM `charts`');
$charts = array();
while($r = mysql_fetch_assoc($q)) {
	$charts[] = $r;
}
$select = "<form method='POST'><select name='chart'>";
foreach ($charts as $chart) {
	$select .= "<option value='".$chart['chart']."'>".$chart['name']."</option>";
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
echo $select."<select name='action'><option value='1'>fold</option><option value='2'>check</option><option value='3'>raise</option></select><table>";
//row
for ($i=0; $i < 13; $i++) { 
	echo "<tr>";
	//col
	for ($j=1; $j <= 13; $j++) { 
		echo "<td class='fold'><input type='hidden' name='values[".($i*13+$j)."]' value='1'/>&nbsp;</td>";
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
		val = $(this).val()
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
