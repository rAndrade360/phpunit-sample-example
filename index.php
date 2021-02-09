<?php

require __DIR__.'/getcep.php';

$getcep = new GetCep();
$response = $getcep->execute('65380000');
print_r($response);