<?php
chdir("/usr/local/bin");
$tx_id = $argv[1];
exec('curl -d "tx_id='.$tx_id.'" -X POST http://romanroad.xyz/transactions/btc');
