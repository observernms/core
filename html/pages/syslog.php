<meta http-equiv="refresh" content="60">
<div style="background-color: #eeeeee; padding: 10px;">
<form method="post" action="">
  <label><strong>Search</strong>
    <input type="text" name="string" id="string" value="<?php  echo($_POST['string']); ?>" />
  </label>
  <label>
    <strong>Program</strong>
    <select name="program" id="program">
      <option value="">All Programs</option>
      <?php
        $query = mysql_query("SELECT `program` FROM `syslog` GROUP BY `program` ORDER BY `program`");
        while($data = mysql_fetch_array($query)) {
          echo("<option value='".$data['program']."'"); 
	  if($data['program'] == $_POST['program']) { echo("selected"); }
          echo(">".$data['program']."</option>");
        }
      ?>
    </select>
  </label>
  <label>
    <strong>Device</strong>
    <select name="device" id="device">
      <option value="">All Devices</option>
      <?php
        $query = mysql_query("SELECT * FROM `devices` ORDER BY `hostname`");
        while($data = mysql_fetch_array($query)) {
          echo("<option value='".$data['device_id']."'");

	  if($data['device_id'] == $_POST['device']) { echo("selected"); }
            
          echo(">".$data['hostname']."</option>");
        }
      ?>
    </select>
  </label>

  <input type=submit value=Search>

</form>
</div>

<?

if($_POST['string']) {
  $where = " AND S.msg LIKE '%".$_POST['string']."%'";
}

if($_POST['program']) {
  $where .= " AND S.program = '".$_POST['program']."'";
}

if($_POST['device']) {
  $where .= " AND D.device_id = '".$_POST['device']."'";
}

$sql = "SELECT *, DATE_FORMAT(datetime, '%D %b %T') AS date from syslog AS S, devices AS D WHERE S.device_id = D.device_id $where ORDER BY datetime DESC LIMIT 1000";
$query = mysql_query($sql);
echo("<table cellspacing=0 cellpadding=2 width=100%>");
while($entry = mysql_fetch_array($query)) { include("includes/print-syslog.inc"); }
echo("</table>");

?>
</table>
