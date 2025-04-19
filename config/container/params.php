<?php

return [
	'MYSQL_PARAM' => json_decode(getenv("MYSQL_PARAM"), true),
	'REDIS_PARAM' => json_decode(getenv("REDIS_PARAM"), true),
];
