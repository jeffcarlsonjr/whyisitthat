<?php

$IP = filter_input(INPUT_SERVER,'REMOTE_ADDR');

$json[] = array('ip' => $IP );

echo json_encode($json);
