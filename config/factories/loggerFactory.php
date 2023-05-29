<?php
return (new \Monolog\Logger('system'))->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__.'/../../var/logs/log'.date('Ymd').'.log'));
