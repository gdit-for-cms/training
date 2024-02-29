<?php
$redis = new Redis();
$redis->connect('192.168.1.217', 6379);
echo "Connection to server successfully";
// Check whether server is running or not
echo "Server is running: " . $redis->ping();
