
<?php

  ## Very basic parser to parse classic Observer-type schemes.
  ## Parser should populate $port_ifAlias array with type, descr, circuit, speed and notes

  unset ($port_ifAlias);

#  echo("parser!");

  list($type,$descr) = preg_split("/[\:\[\]\{\}\(\)]/", $this_port['ifAlias']);
  list(,$circuit) = preg_split("/[\{\}]/", $this_port['ifAlias']);
  list(,$notes) = preg_split("/[\(\)]/", $this_port['ifAlias']);
  list(,$speed) = preg_split("/[\[\]]/", $this_port['ifAlias']);
  $descr = trim($descr);

  if($type && $descr) {
    $port_ifAlias['type']  = $type;
    $port_ifAlias['descr'] = $descr;
    $port_ifAlias['circuit'] = $circuit;
    $port_ifAlias['speed'] = $speed;
    $port_ifAlias['notes'] = $notes;

    print_r($port_ifAlias);

  }

  unset ($port_type, $port_descr, $port_circuit, $port_notes, $port_speed);

?>
