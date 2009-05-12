<?

 $hostname = $device['hostname'];
 $hostid   = $device['interface_id'];
 $ifname   = $interface['ifDescr'];
 $ifIndex   = $interface['ifIndex'];
 $speed = humanspeed($interface['ifSpeed']);

 $ifalias = $interface['name'];

 if($interface['ifPhysAddress']) { $mac = "$interface[ifPhysAddress]"; } 

 $color = "black";
 if ($interface['ifAdminStatus'] == "down") { $status = "<span class='grey'>Disabled</span>"; }
 if ($interface['ifAdminStatus'] == "up" && $interface['ifOperStatus'] == "down") { $status = "<span class='red'>Enabled / Disconnected</span>"; }
 if ($interface['ifAdminStatus'] == "up" && $interface['ifOperStatus'] == "up") { $status = "<span class='green'>Enabled / Connected</span>"; }

 $i = 1; 
 $inf = fixifName($ifname);

 $bg="#ffffff";

 $query = mysql_query("SELECT *, (M.bps_in + M.bps_out) as bps FROM `mac_accounting` AS M, `interfaces` AS I, `devices` AS D WHERE M.interface_id = '".$interface['interface_id']."' AND I.interface_id = M.interface_id AND I.device_id = D.device_id ORDER BY bps DESC");

 while($acc = mysql_fetch_array($query)) { 

   $addy = mysql_fetch_array(mysql_query("SELECT * FROM ipv4_mac where mac_address = '".$acc['mac']."'"));
   $name = gethostbyaddr($addy['ipv4_address']);

   if($name == $addy['ipv4_address']) { unset ($name); }

   if($bg == "#ffffff") { $bg = "#e5e5e5"; } else { $bg="#ffffff"; }
   if(mysql_result(mysql_query("SELECT count(*) FROM bgpPeers WHERE device_id = '".$acc['device_id']."' AND bgpPeerIdentifier = '".$addy['ipv4_address']."'"),0)) {

     $peer_query = mysql_query("SELECT * FROM bgpPeers WHERE device_id = '".$acc['device_id']."' AND bgpPeerIdentifier = '".$addy['ipv4_address']."'");
     $peer_info = mysql_fetch_array($peer_query);

   } else { unset ($peer_info); }

   echo("<div style='background-color: $bg; padding: 8px;'>");

   if($peer_info) { $asn = "AS".$peer_info['bgpPeerRemoteAs']; $astext = $peer_info['astext']; } else {
   unset ($as); unset ($astext);
   }

   echo("
     <table>
       <tr>
         <td class=list-large width=200>".mac_clean_to_readable($acc['mac'])."</td>
         <td class=list-large width=200>".$addy['ipv4_address']."</td>
         <td class=list-large width=500>".$name."</td>
         <td class=list-large width=100>".formatRates($acc['bps_in'])."</td>
         <td class=list-large width=100>".formatRates($acc['bps_out'])."</td>
       </tr>
     </table>
   ");

   $peer_info['astext'];   


  $graph_type = "mac_acc";

  $daily_traffic   = "graph.php?id=" . $acc['ma_id'] . "&type=$graph_type&from=$day&to=$now&width=210&height=100";
  $daily_url       = "graph.php?id=" . $acc['ma_id'] . "&type=$graph_type&from=$day&to=$now&width=500&height=150";

  $weekly_traffic  = "graph.php?id=" . $acc['ma_id'] . "&type=$graph_type&from=$week&to=$now&width=210&height=100";
  $weekly_url      = "graph.php?id=" . $acc['ma_id'] . "&type=$graph_type&from=$week&to=$now&width=500&height=150";

  $monthly_traffic = "graph.php?id=" . $acc['ma_id'] . "&type=$graph_type&from=$month&to=$now&width=210&height=100";
  $monthly_url     = "graph.php?id=" . $acc['ma_id'] . "&type=$graph_type&from=$month&to=$now&width=500&height=150";

  $yearly_traffic  = "graph.php?id=" . $acc['ma_id'] . "&type=$graph_type&from=$year&to=$now&width=210&height=100";
  $yearly_url      = "graph.php?id=" . $acc['ma_id'] . "&type=$graph_type&from=$year&to=$now&width=500&height=150";

  echo("<a href='?page=interface&id=" . $interface['ma_id'] . "' onmouseover=\"return overlib('<img src=\'$daily_url\'>', LEFT".$config['overlib_defaults'].");\" onmouseout=\"return nd();\">
        <img src='$daily_traffic' border=0></a> ");
  echo("<a href='?page=interface&id=" . $interface['ma_id'] . "' onmouseover=\"return overlib('<img src=\'$weekly_url\'>', LEFT".$config['overlib_defaults'].");\" onmouseout=\"return nd();\">
        <img src='$weekly_traffic' border=0></a> ");
  echo("<a href='?page=interface&id=" . $interface['ma_id'] . "' onmouseover=\"return overlib('<img src=\'$monthly_url\'>', LEFT".$config['overlib_defaults'].", WIDTH, 350);\" onmouseout=\"return nd();\">
        <img src='$monthly_traffic' border=0></a> ");
  echo("<a href='?page=interface&id=" . $interface['ma_id'] . "' onmouseover=\"return overlib('<img src=\'$yearly_url\'>', LEFT".$config['overlib_defaults'].", WIDTH, 350);\" onmouseout=\"return nd();\">
        <img src='$yearly_traffic' border=0></a>");


  echo("</div>");

 }

?>