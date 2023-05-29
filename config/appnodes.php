<?php

/**
 * Правила для точек монтирования модулей
 * Каждый массив определяет порядок срабатывания, часть url с которого
 */

# Example:
# ['key'=>'/', "action"=>"App\\Main\\Controllers\\IndexController", "method"=>"index"],
# ['key'=>'/', 'router'=>'config/routes/main/collection.php'],
# ['key'=>'/', 'router'=>'config/routes/main.json']
# ['key'=>'/', 'router'=>'config/routes/main.yaml'],

return [
	['key'=>'/', 'router'=>'config/routes/main.yaml'],
];
 