<?php
return (new \Rmphp\Content\Content('/templates/base.tpl'))->setSubtemplatePath('/templates/')->setSubtemplatePathAlias([
	"main" => "/src/Infrastructure/subtemplates",
]);
