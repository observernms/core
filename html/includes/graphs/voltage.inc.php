<?php

$scale_min = "0";

include("common.inc.php");

$rrd_options .= " -A ";

  $rrd_options .= " COMMENT:'                           Last    Max\\n'";

  $voltage = mysql_fetch_array(mysql_query("SELECT * FROM voltage where volt_id = '".mres($_GET['id'])."'"));

  $hostname = mysql_result(mysql_query("SELECT hostname FROM devices WHERE device_id = '" . $voltage['device_id'] . "'"),0);

  $voltage['volt_descr_fixed'] = substr(str_pad($voltage['volt_descr'], 22),0,22);

  $rrd_filename  = $config['rrd_dir'] . "/".$hostname."/" . safename("volt-" . $voltage['volt_descr'] . ".rrd");

  $rrd_options .= " DEF:volt=$rrd_filename:volt:AVERAGE";
  $rrd_options .= " DEF:volt_max=$rrd_filename:volt:MAX";
  $rrd_options .= " DEF:volt_min=$rrd_filename:volt:MIN";

  $rrd_options .= " AREA:volt_max#c5c5c5";
  $rrd_options .= " AREA:volt_min#ffffffff";

  #$rrd_options .= " AREA:volt#FFFF99";
  $rrd_options .= " LINE1.5:volt#cc0000:'" . $voltage['volt_descr_fixed']."'";
  $rrd_options .= " GPRINT:volt:LAST:%3.2lfV";
  $rrd_options .= " GPRINT:volt:MAX:%3.2lfV\\\\l";

?>
