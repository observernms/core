<div style="margin: 10px;">
  <h3>ObserverNMS <?php echo($config['version']);?></h3>

    <div style="float: right; padding: 0px; width: 49%">
    <?php print_optionbar_start(NULL); ?>
    <h3>License</h3>
    <pre>ObserverNMS Network Management and Monitoring System
Copyright (C) 2006-2010 Adam Armstrong
 
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
 
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this program.  If not, see <a href="http://www.gnu.org/licenses/">http://www.gnu.org/licenses/</a>.</pre>
     <?php print_optionbar_end(); ?>

&nbsp;

 <?php print_optionbar_start(NULL); ?>


<h3>Statistics</h3>

<?php
    $stat_devices = mysql_result(mysql_query("SELECT COUNT(*) FROM `devices`"),0);
    $stat_ports = mysql_result(mysql_query("SELECT COUNT(*) FROM `ports`"),0);
    $stat_syslog = mysql_result(mysql_query("SELECT COUNT(*) FROM `syslog`"),0);
    $stat_events = mysql_result(mysql_query("SELECT COUNT(*) FROM `eventlog`"),0);
    $stat_apps = mysql_result(mysql_query("SELECT COUNT(*) FROM `applications`"),0);
    $stat_services = mysql_result(mysql_query("SELECT COUNT(*) FROM `services`"),0);
    $stat_storage = mysql_result(mysql_query("SELECT COUNT(*) FROM `storage`"),0);
    $stat_diskio = mysql_result(mysql_query("SELECT COUNT(*) FROM `ucd_diskio`"),0);
    $stat_processors = mysql_result(mysql_query("SELECT COUNT(*) FROM `processors`"),0);
    $stat_memory = mysql_result(mysql_query("SELECT COUNT(*) FROM `mempools`"),0);
    $stat_temp = mysql_result(mysql_query("SELECT COUNT(*) FROM `temperature`"),0);
    $stat_fanspeeds = mysql_result(mysql_query("SELECT COUNT(*) FROM `fanspeed`"),0);
    $stat_volt = mysql_result(mysql_query("SELECT COUNT(*) FROM `voltage`"),0);
    $stat_amp = mysql_result(mysql_query("SELECT COUNT(*) FROM `current`"),0);
    $stat_hz = mysql_result(mysql_query("SELECT COUNT(*) FROM `frequency`"),0);
    $stat_humid = mysql_result(mysql_query("SELECT COUNT(*) FROM `sensors` WHERE sensor_class='humidity'"),0);
    $stat_toner = mysql_result(mysql_query("SELECT COUNT(*) FROM `toner`"),0);
    $stat_hrdev = mysql_result(mysql_query("SELECT COUNT(*) FROM `hrDevice`"),0);
    $stat_entphys = mysql_result(mysql_query("SELECT COUNT(*) FROM `entPhysical`"),0);

    $stat_ipv4_addy = mysql_result(mysql_query("SELECT COUNT(*) FROM `ipv4_addresses`"),0);
    $stat_ipv4_nets = mysql_result(mysql_query("SELECT COUNT(*) FROM `ipv4_networks`"),0);
    $stat_ipv6_addy = mysql_result(mysql_query("SELECT COUNT(*) FROM `ipv6_addresses`"),0);
    $stat_ipv6_nets = mysql_result(mysql_query("SELECT COUNT(*) FROM `ipv6_networks`"),0);

    $stat_pw = mysql_result(mysql_query("SELECT COUNT(*) FROM `pseudowires`"),0);
    $stat_vrf = mysql_result(mysql_query("SELECT COUNT(*) FROM `vrfs`"),0);
    $stat_vlans = mysql_result(mysql_query("SELECT COUNT(*) FROM `vlans`"),0);


    echo("

<table width=95% cellpadding=5 cellspacing=0>
<tr>
    <td width=45%><img src='images/icons/device.png' class='optionicon'> <b>Devices</b></td><td align=right>$stat_devices</td>
    <td width=45%><img src='images/icons/port.png' class='optionicon'> <b>Ports</b></td><td align=right>$stat_ports</td>
</tr>
<tr>
    <td><img src='images/icons/ipv4.png'  class='optionicon'> <b>IPv4 Addresses<b></td><td align=right>$stat_ipv4_addy</td>
    <td><img src='images/icons/ipv4.png' class='optionicon'> <b>IPv4 Networks</b></td><td align=right>$stat_ipv4_nets</td>
</tr>
<tr>
    <td><img src='images/icons/ipv6.png'  class='optionicon'> <b>IPv6 Addresses<b></td><td align=right>$stat_ipv6_addy</td>
    <td><img src='images/icons/ipv6.png' class='optionicon'> <b>IPv6 Networks</b></td><td align=right>$stat_ipv6_nets</td>
</tr>
<tr>
    <td><img src='images/icons/services.png'  class='optionicon'> <b>Services<b></td><td align=right>$stat_services</td>
    <td><img src='images/icons/apps.png' class='optionicon'> <b>Applications</b></td><td align=right>$stat_apps</td>
</tr>
<tr>
    <td ><img src='images/icons/processors.png' class='optionicon'> <b>Processors</b></td><td align=right>$stat_processors</td>
    <td><img src='images/icons/memory.png' class='optionicon'> <b>Memory</b></td><td align=right>$stat_memory</td>
</tr>
<tr>
    <td><img src='images/icons/storage.png' class='optionicon'> <b>Storage</b></td><td align=right>$stat_storage</td>
    <td><img src='images/icons/diskio.png' class='optionicon'> <b>Disk I/O</b></td><td align=right>$stat_diskio</td>
</tr>
<tr>
    <td><img src='images/icons/inventory.png' class='optionicon'> <b>HR-MIB</b></td><td align=right>$stat_hrdev</td>
    <td><img src='images/icons/inventory.png' class='optionicon'> <b>Entity-MIB</b></td><td align=right>$stat_entphys</td>
</tr>
<tr>
    <td ><img src='images/icons/syslog.png' class='optionicon'> <b>Syslog Entries</b></td><td align=right>$stat_syslog</td>
    <td><img src='images/icons/eventlog.png' class='optionicon'> <b>Eventlog Entries</b></td><td align=right>$stat_events</td>
</tr>
<tr>
    <td ><img src='images/icons/temperatures.png' class='optionicon'> <b>Temperatures</b></td><td align=right>$stat_temp</td>
    <td><img src='images/icons/fanspeeds.png' class='optionicon'> <b>Fanspeeds</b></td><td align=right>$stat_fanspeeds</td>
</tr>
<tr>
    <td ><img src='images/icons/voltages.png' class='optionicon'> <b>Voltage</b></td><td align=right>$stat_volt</td>
    <td><img src='images/icons/current.png' class='optionicon'> <b>Current</b></td><td align=right>$stat_amp</td>
</tr>

<tr>
    <td ><img src='images/icons/frequencies.png' class='optionicon'> <b>Frequency</b></td><td align=right>$stat_hz</td>
    <td><img src='images/icons/toner.png' class='optionicon'> <b>Toner</b></td><td align=right>$stat_toner</td>
</tr>

<tr>
    <td ><img src='images/icons/humidity.png' class='optionicon'> <b>Humidity</b></td><td align=right>$stat_humid</td>
    <td><!--<img src='images/icons/toner.png' class='optionicon'> <b>Toner</b></td><td align=right>$stat_toner--></td>
</tr>


</table>
");



print_optionbar_end(); ?>

    
     </div>

<div style="float: left; padding: 0px; width: 49%">

    <?php

    $observer_version = $config['version'];
    if (file_exists('.svn/entries'))
    {
      $svn = File('.svn/entries');
      $observer_version .='-SVN r' . trim($svn[3]);
      unset($svn);
    }


$apache_version = str_replace("Apache/", "", $_SERVER['SERVER_SOFTWARE']);

$php_version = phpversion();

$t=mysql_query("select version() as ve");
$r=mysql_fetch_object($t);
$mysql_version = $r->ve;

$netsnmp_version = shell_exec($config['snmpget'] . " --version");

print_optionbar_start(NULL);

echo("
<h3>Versions</h3>
<table width=100% cellpadding=3 cellspacing=0 border=0>
<tr valign=top><td width=150><b>ObserverNMS</b></td><td>$observer_version</td></tr>
<tr valign=top><td><b>Apache</b></td><td>$apache_version</td></tr>
<tr valign=top><td><b>PHP</b></td><td>$php_version</td></tr>
<tr valign=top><td><b>MySQL</b></td><td>$mysql_version</td></tr>
</table>
");

print_optionbar_end();

    ?>

  <h5>ObserverNMS is an autodiscovering PHP/MySQL based network monitoring system.</h5>

  <p><a href="http://www.observernms.org">Website</a> | 
     <a href="http://www.observernms.org/wiki/">Support Wiki</a> | 
     <a href="http://www.observernms.org/forum/">Forum</a> | 
     <a href="http://www.observernms.org/bugs/">Bugtracker</a> | 
     <a href="http://www.observernms.org/pmwiki.php/Main/MailingLists">Mailing List</a> | 
     <a href="http://twitter.com/observernms">Twitter</a> |
     <a href="http://www.facebook.com/pages/Observer/128354461353">Facebook</a></p>


  <h4>The Team</h4>

    <img src="images/icons/flags/gb.png"> <strong>Adam Armstrong</strong> Project Founder<br />
    <img src="images/icons/flags/be.png"> <strong>Geert Hauwaerts</strong> Developer<br />
    <img src="images/icons/flags/be.png"> <strong>Tom Laermans</strong> Developer<br />
  </ul>

  <h4>Acknowledgements</h4>

    <b>Stu Nicholls</b> Dropdown menu CSS code. <br />
    <b>Mark James</b> Silk Iconset. <br />
    <b>Erik Bosrup</b> Overlib Library. <br />
    <b>Jonathan De Graeve</b> SNMP code improvements. <br />
    <b>Xiaochi Jin</b> Logo design. <br />
    <b>Bruno Pramont</b> Collectd code. <br />


</div>
