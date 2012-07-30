<?php

$app->mount('/c4/', new XP\C4\Controllers\Providers\CrossCrossCoffeeCupControllerProvider());

$app->mount('/', new XP\C4\Controllers\Providers\TranversalControllerProvider());