<?php
use  XP\C4\Controllers\Providers\CrossCrossCoffeeCupControllerProvider;
use  XP\C4\Controllers\Providers\DefaultControllerProvider;

$app->mount('/c4/', new CrossCrossCoffeeCupControllerProvider());
$app->mount('/', new DefaultControllerProvider());