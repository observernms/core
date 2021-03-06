
<?php

if(isset($bg) && $bg == $list_colour_a) { $bg = $list_colour_b; } else { $bg=$list_colour_a; }

  $hostname = gethostbyid($entry['host']);

  unset($icon);

  $icon = geteventicon($entry['message']);
  if($icon) {$icon = '<img src="images/16/' . $icon . '" />'; }


  echo('<tr style="background-color: ' . $bg . '">
    <td width="0"></td>
    <td class="syslog" width="160">
      ' . $entry['datetime'] . '
    </td>');
  if(!isset($_GET['id']) && (!isset($overview) || $overview == 0)) {
    $dev['device_id'] = $entry['host'];
    $dev['hostname'] = $hostname;
    echo("<td class=list-bold width=150>
      " . generatedevicelink($dev, shorthost($dev['hostname'])) . "
    </td>");
  }

  if($entry['type'] == "interface") {
    $entry['link'] = "<b>".generateiflink(getifbyid($entry['reference']))."</b>";
  } else {
    $entry['link'] = "System";
  }
  
  echo("<td>".$entry['link']."</td>");

  echo("<td>".htmlspecialchars($entry['message']) . "</td>
  </tr>");




?>
