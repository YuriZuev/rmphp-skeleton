<?php

/**
 * Правила для точек монтирования модулей
 */

# Example:
# ['key'=>'/', "action"=>"App\\Main\\Controllers\\IndexController", "method"=>"index"],
# ['key'=>'/', 'router'=>'config/routes/main/routes.php'],
# ['key'=>'/', 'router'=>[]],

return [
	['key'=>'/', 'router'=>'config/routes/main/routes.php'],
];
 