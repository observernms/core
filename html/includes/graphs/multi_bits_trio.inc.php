<?php

if($_GET['legend']) { $legend = $_GET['legend']; }

  $rrd_options = " --alt-autoscale-max -E --start $from --end " . ($to - 150) . " --width $width --height $height ";
  $rrd_options .= $config['rrdgraph_def_text'];
  if($height < "99") { $rrd_options .= " --only-graph"; }
  $i = 1;
  foreach(explode(",", $_GET['ports']) as $ifid) {
    $query = mysql_query("SELECT `ifIndex`, `hostname` FROM `ports` AS I, devices as D WHERE I.interface_id = '" . $ifid . "' AND I.device_id = D.device_id");
    $int = mysql_fetch_row($query);
    if(is_file($config['rrd_dir'] . "/" . $int[1] . "/" . $int[0] . ".rrd")) {
      if(strstr($inverse, "a")) { $in = "OUT"; $out = "IN"; } else { $in = "IN"; $out = "OUT"; }
      $rrd_options .= " DEF:inoctets" . $i . "=" . $config['rrd_dir'] . "/" . $int[1] . "/" . $int[0] . ".rrd:".$in."OCTETS:AVERAGE";
      $rrd_options .= " DEF:outoctets" . $i . "=" . $config['rrd_dir'] . "/" . $int[1] . "/" . $int[0] . ".rrd:".$out."OCTETS:AVERAGE";
      $in_thing .= $seperator . "inoctets" . $i . ",UN,0," . "inoctets" . $i . ",IF";
      $out_thing .= $seperator . "outoctets" . $i . ",UN,0," . "outoctets" . $i . ",IF";
      $pluses .= $plus;
      $seperator = ",";
      $plus = ",+";
      $i++;
    }
  }
  unset($seperator); unset($plus);
  foreach(explode(",", $_GET['ports_b']) as $ifid) {
    $query = mysql_query("SELECT `ifIndex`, `hostname` FROM `ports` AS I, devices as D WHERE I.interface_id = '" . $ifid . "' AND I.device_id = D.device_id");
    $int = mysql_fetch_row($query);
    if(is_file($config['rrd_dir'] . "/" . $int[1] . "/" . $int[0] . ".rrd")) {
      if(strstr($inverse, "b")) { $in = "OUT"; $out = "IN"; } else { $in = "IN"; $out = "OUT"; }
      $rrd_options .= " DEF:inoctetsb" . $i . "=" . $config['rrd_dir'] . "/" . $int[1] . "/" . $int[0] . ".rrd:".$in."OCTETS:AVERAGE";
      $rrd_options .= " DEF:outoctetsb" . $i . "=" . $config['rrd_dir'] . "/" . $int[1] . "/" . $int[0] . ".rrd:".$out."OCTETS:AVERAGE";
      $in_thingb .= $seperator . "inoctetsb" . $i . ",UN,0," . "inoctetsb" . $i . ",IF";
      $out_thingb .= $seperator . "outoctetsb" . $i . ",UN,0," . "outoctetsb" . $i . ",IF";
      $plusesb .= $plus;
      $seperator = ",";
      $plus = ",+";
      $i++;
    }
  }
  unset($seperator); unset($plus);
  foreach(explode(",", $_GET['ports_c']) as $ifid) {
    $query = mysql_query("SELECT `ifIndex`, `hostname` FROM `ports` AS I, devices as D WHERE I.interface_id = '" . $ifid . "' AND I.device_id = D.device_id");
    $int = mysql_fetch_row($query);
    if(is_file($config['rrd_dir'] . "/" . $int[1] . "/" . $int[0] . ".rrd")) {
      if(strstr($inverse, "c")) { $in = "OUT"; $out = "IN"; } else { $in = "IN"; $out = "OUT"; }
      $rrd_options .= " DEF:inoctetsc" . $i . "=" . $config['rrd_dir'] . "/" . $int[1] . "/" . $int[0] . ".rrd:".$in."OCTETS:AVERAGE";
      $rrd_options .= " DEF:outoctetsc" . $i . "=" . $config['rrd_dir'] . "/" . $int[1] . "/" . $int[0] . ".rrd:".$out."OCTETS:AVERAGE";
      $in_thingc .= $seperator . "inoctetsc" . $i . ",UN,0," . "inoctetsc" . $i . ",IF";
      $out_thingc .= $seperator . "outoctetsc" . $i . ",UN,0," . "outoctetsc" . $i . ",IF";
      $plusesc .= $plus;
      $seperator = ",";
      $plus = ",+";
      $i++;
    }
  }
  $rrd_options .= " CDEF:inoctets=" . $in_thing . $pluses;
  $rrd_options .= " CDEF:outoctets=" . $out_thing . $pluses;
  $rrd_options .= " CDEF:inoctetsb=" . $in_thingb . $plusesb;
  $rrd_options .= " CDEF:outoctetsb=" . $out_thingb . $plusesb;
  $rrd_options .= " CDEF:inoctetsc=" . $in_thingc . $plusesc;
  $rrd_options .= " CDEF:outoctetsc=" . $out_thingc . $plusesc;
  $rrd_options .= " CDEF:doutoctets=outoctets,-1,*";
  $rrd_options .= " CDEF:inbits=inoctets,8,*";
  $rrd_options .= " CDEF:outbits=outoctets,8,*";
  $rrd_options .= " CDEF:doutbits=doutoctets,8,*";
  $rrd_options .= " CDEF:doutoctetsb=outoctetsb,-1,*";
  $rrd_options .= " CDEF:inbitsb=inoctetsb,8,*";
  $rrd_options .= " CDEF:outbitsb=outoctetsb,8,*";
  $rrd_options .= " CDEF:doutbitsb=doutoctetsb,8,*";
  $rrd_options .= " CDEF:doutoctetsc=outoctetsc,-1,*";
  $rrd_options .= " CDEF:inbitsc=inoctetsc,8,*";
  $rrd_options .= " CDEF:outbitsc=outoctetsc,8,*";
  $rrd_options .= " CDEF:doutbitsc=doutoctetsc,8,*";
  $rrd_options .= " CDEF:inbits_tot=inbits,inbitsb,inbitsc,+,+";
  $rrd_options .= " CDEF:outbits_tot=outbits,outbitsb,outbitsc,+,+";
  $rrd_options .= " CDEF:inbits_stot=inbitsc,inbitsb,+";
  $rrd_options .= " CDEF:outbits_stot=outbitsc,outbitsb,+";
  $rrd_options .= " CDEF:doutbits_stot=outbits_stot,-1,*";
  $rrd_options .= " CDEF:doutbits_tot=outbits_tot,-1,*";
  $rrd_options .= " CDEF:nothing=outbits_tot,outbits_tot,-";

  if($legend == "no") {
   $rrd_options .= " AREA:inbits_tot#cdeb8b:";
   $rrd_options .= " AREA:doutbits_tot#cdeb8b:";
   $rrd_options .= " LINE1.25:inbits_tot#aacc77:";
   $rrd_options .= " LINE1.25:doutbits_tot#aacc88:";
   $rrd_options .= " AREA:inbits_stot#c3d9ff:";
   $rrd_options .= " AREA:doutbits_stot#c3d9ff:";
   $rrd_options .= " LINE1:inbits_stot#b3a9cf:";
   $rrd_options .= " LINE1:doutbits_stot#b3a9cf:";
   $rrd_options .= " AREA:inbitsc#ffcc99:";
   $rrd_options .= " AREA:doutbitsc#ffcc99:";
   $rrd_options .= " LINE1.25:inbitsc#ddaa88";
   $rrd_options .= " LINE1.25:doutbitsc#ddaa88";
   $rrd_options .= " LINE1:inbits#006600:";
   $rrd_options .= " LINE1:doutbits#006600:";
   $rrd_options .= " LINE1:inbitsb#000099:";
   $rrd_options .= " LINE1:doutbitsb#000099:";
   $rrd_options .= " LINE0.5:nothing#555555:";
  } else {
   $rrd_options .= " COMMENT:BPS\ \ \ \ \ \ \ \ \ \ \ \ Current\ \ \ Average\ \ \ \ \ \ Min\ \ \ \ \ \ Max\\\\n";
   $rrd_options .= " AREA:inbits_tot#cdeb8b:ATM\ \ In\ ";
   $rrd_options .= " GPRINT:inbits:LAST:%6.2lf%s";
   $rrd_options .= " GPRINT:inbits:AVERAGE:%6.2lf%s";
   $rrd_options .= " GPRINT:inbits:MIN:%6.2lf%s";
   $rrd_options .= " GPRINT:inbits:MAX:%6.2lf%s\\\\l";
   $rrd_options .= " AREA:doutbits_tot#cdeb8b:";
   $rrd_options .= " COMMENT:\ \ \ \ \ \ \ Out";
   $rrd_options .= " GPRINT:outbits:LAST:%6.2lf%s";
   $rrd_options .= " GPRINT:outbits:AVERAGE:%6.2lf%s";
   $rrd_options .= " GPRINT:outbits:MIN:%6.2lf%s";
   $rrd_options .= " GPRINT:outbits:MAX:%6.2lf%s\\\\l";
   $rrd_options .= " LINE1.25:inbits_tot#aacc77:";
   $rrd_options .= " LINE1.25:doutbits_tot#aacc88:";
   $rrd_options .= " AREA:inbits_stot#c3d9ff:NGN\ \ In\ ";
   $rrd_options .= " GPRINT:inbitsb:LAST:%6.2lf%s";
   $rrd_options .= " GPRINT:inbitsb:AVERAGE:%6.2lf%s";
   $rrd_options .= " GPRINT:inbitsb:MIN:%6.2lf%s";
   $rrd_options .= " GPRINT:inbitsb:MAX:%6.2lf%s\\\\l";
   $rrd_options .= " AREA:doutbits_stot#c3d9ff:";
   $rrd_options .= " COMMENT:\ \ \ \ \ \ \ Out";
   $rrd_options .= " GPRINT:outbitsb:LAST:%6.2lf%s";
   $rrd_options .= " GPRINT:outbitsb:AVERAGE:%6.2lf%s";
   $rrd_options .= " GPRINT:outbitsb:MIN:%6.2lf%s";
   $rrd_options .= " GPRINT:outbitsb:MAX:%6.2lf%s\\\\l";
   $rrd_options .= " LINE1:inbits_stot#b3a9cf:";
   $rrd_options .= " LINE1:doutbits_stot#b3a9cf:";
   $rrd_options .= " AREA:inbitsc#ffcc99:Wave\ In\ ";
   $rrd_options .= " GPRINT:inbitsc:LAST:%6.2lf%s";
   $rrd_options .= " GPRINT:inbitsc:AVERAGE:%6.2lf%s";
   $rrd_options .= " GPRINT:inbitsc:MIN:%6.2lf%s";
   $rrd_options .= " GPRINT:inbitsc:MAX:%6.2lf%s\\\\l";
   $rrd_options .= " AREA:doutbitsc#ffcc99:";
   $rrd_options .= " COMMENT:\ \ \ \ \ \ \ Out";
   $rrd_options .= " GPRINT:outbitsc:LAST:%6.2lf%s";
   $rrd_options .= " GPRINT:outbitsc:AVERAGE:%6.2lf%s";
   $rrd_options .= " GPRINT:outbitsc:MIN:%6.2lf%s";
   $rrd_options .= " GPRINT:outbitsc:MAX:%6.2lf%s\\\\l";
   $rrd_options .= " LINE1.25:inbitsc#ddaa88";
   $rrd_options .= " LINE1.25:doutbitsc#ddaa88";
   $rrd_options .= " LINE1:inbits#006600:";
   $rrd_options .= " LINE1:doutbits#006600:";
   $rrd_options .= " LINE1:inbitsb#000099:";
   $rrd_options .= " LINE1:doutbitsb#000099:";
   $rrd_options .= " LINE0.5:nothing#555555:";

   $rrd_options .= " COMMENT:Total\ \ In\ ";
   $rrd_options .= " GPRINT:inbits_tot:LAST:%6.2lf%s";
   $rrd_options .= " GPRINT:inbits_tot:AVERAGE:%6.2lf%s";
   $rrd_options .= " GPRINT:inbits_tot:MIN:%6.2lf%s";
   $rrd_options .= " GPRINT:inbits_tot:MAX:%6.2lf%s\\\\l";
   $rrd_options .= " COMMENT:\ \ \ \ \ \ \ Out";
   $rrd_options .= " GPRINT:outbits_tot:LAST:%6.2lf%s";
   $rrd_options .= " GPRINT:outbits_tot:AVERAGE:%6.2lf%s";
   $rrd_options .= " GPRINT:outbits_tot:MIN:%6.2lf%s";
   $rrd_options .= " GPRINT:outbits_tot:MAX:%6.2lf%s\\\\l";


  }
  if($width <= "300") { $rrd_options .= " --font LEGEND:7:".$config['mono_font']." --font AXIS:6:".$config['mono_font']." --font-render-mode normal"; }

?>
