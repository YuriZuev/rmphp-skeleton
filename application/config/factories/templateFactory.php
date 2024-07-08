<?php
return (new \Rmphp\Content\Content('/application/src/Infrastructure/templates/base.tpl'))->setSubtemplatePath('/application/src/Infrastructure/templates/')->setSubtemplatePathAlias([
	"main" => "/src/Main/Infrastructure/templates",
]);
