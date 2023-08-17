<?php

/**
 * Правила для точек монтирования модулей
 * Каждый массив определяет порядок срабатывания, часть url с которого
 */

# Example:
# ['key'=>'/', "action"=>"App\\Main\\Controllers\\IndexController", "method"=>"index"],
# ['key'=>'/', 'router'=>'config/routes/main/routes.php'],
# ['key'=>'/', 'router'=>'config/routes/main.yaml'],

return [
	['key'=>'/', 'router'=>'config/routes/main.yaml'],
];
 