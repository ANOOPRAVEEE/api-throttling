<?php

//include throttle library
require_once('lib/throttle.php');

// Set the throttle limit
$throttle_limit = 10; // number of requests per second
$throttle       = new Throttle();
$throttle->shouldThrottle($throttle_limit);

// Serve the requested resource
echo 'Hello, world!';

?>