<?php

## Polls Apache statistics from script via SNMP

$apache_rrd   = $config['rrd_dir'] . "/" . $device['hostname'] . "/app-apache-".$app['app_id'].".rrd";
$apache_cmd  = $config['snmpget'] ." -m NET-SNMP-EXTEND-MIB -O qv -" . $device['snmpver'] . " -c " . $device['community'] . " " . $device['hostname'].":".$device['port'];
$apache_cmd .= " nsExtendOutputFull.6.97.112.97.99.104.101";
$apache  = `$apache_cmd`;
list ($total_access, $total_kbyte, $cpuload, $uptime, $reqpersec, $bytespersec, $bytesperreq, $busyworkers, $idleworkers, 
      $score_wait, $score_start, $score_reading, $score_writing, $score_keepalive, $score_dns, $score_closing, $score_logging, $score_graceful, $score_idle, $score_open) = explode("\n", $apache);

if (!is_file($apache_rrd)) {
      rrdtool_create ($apache_rrd, "--step 300 \
      DS:access:DERIVE:600:0:125000000000 \
      DS:kbyte:DERIVE:600:0:125000000000 \
      DS:cpu:GAUGE:600:0:125000000000 \
      DS:uptime:GAUGE:600:0:125000000000 \
      DS:reqpersec:GAUGE:600:0:125000000000 \
      DS:bytespersec:GAUGE:600:0:125000000000 \
      DS:byesperreq:GAUGE:600:0:125000000000 \
      DS:busyworkers:GAUGE:600:0:125000000000 \
      DS:idleworkers:GAUGE:600:0:125000000000 \
      DS:sb_wait:GAUGE:600:0:125000000000 \
      DS:sb_start:GAUGE:600:0:125000000000 \
      DS:sb_reading:GAUGE:600:0:125000000000 \
      DS:sb_writing:GAUGE:600:0:125000000000 \
      DS:sb_keepalive:GAUGE:600:0:125000000000 \
      DS:sb_dns:GAUGE:600:0:125000000000 \
      DS:sb_closing:GAUGE:600:0:125000000000 \
      DS:sb_logging:GAUGE:600:0:125000000000 \
      DS:sb_graceful:GAUGE:600:0:125000000000 \
      DS:sb_idle:GAUGE:600:0:125000000000 \
      DS:sb_open:GAUGE:600:0:125000000000 \
      RRA:AVERAGE:0.5:1:600 \
      RRA:AVERAGE:0.5:6:700 \
      RRA:AVERAGE:0.5:24:775 \
      RRA:AVERAGE:0.5:288:797 \
      RRA:MIN:0.5:1:600 \
      RRA:MIN:0.5:6:700 \
      RRA:MIN:0.5:24:775 \
      RRA:MIN:0.5:288:797 \
      RRA:MAX:0.5:1:600 \
      RRA:MAX:0.5:6:700 \
      RRA:MAX:0.5:24:775 \
      RRA:MAX:0.5:288:797");
}

rrdtool_update($apache_rrd,  "N:$total_access:$total_kbyte:$cpuload:$uptime:$reqpersec:$bytespersec:$bytesperreq:$busyworkers:$idleworkers:$score_wait:$score_start:$score_reading:$score_writing:$score_keepalive:$score_dns:$score_closing:$score_logging:$score_graceful:$score_idle:$score_open");


?>
