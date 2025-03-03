<?php
return (new \Monolog\Logger('system'))->pushHandler(new \Monolog\Handler\StreamHandler(dirname(__DIR__, 2).'/var/logs/log'.date('Ymd').'.log'));
