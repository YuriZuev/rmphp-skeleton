<?php
# Example:
# ['key'=>'/', "action"=>"App\\Main\\Controllers\\IndexController", "method"=>"index"],
# ['key'=>'', 'router'=>'config/routes-cli/routes.php'],
# ['key'=>'/', 'router'=>[]],

return [
	['key'=>'', 'router'=>[
		[
			'key'=>'index',
			'routes' => [
				[
					'action' => "App\Infrastructure\Handlers\IndexHandler",
					'method' => "index"
				]
			]
		]
	]],
];
