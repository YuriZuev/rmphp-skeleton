<?php

return [
	/**
	 * Путь к файлу фабрики возвращающий реализацию RouterInterface или сам экземпляр класса
	 */
	\Rmphp\Foundation\RouterInterface::class => 'config/components/routerFactory.php',
	/**
	 * Путь к файлу фабрики возвращающий реализацию TemplateInterface или сам экземпляр класса
	 */
	\Rmphp\Foundation\TemplateInterface::class => 'config/components/templateFactory.php',
	/**
	 * Путь к файлу фабрики возвращающий реализацию PSR-3 LoggerInterface или сам экземпляр класса
	 */
	\Psr\Log\LoggerInterface::class => 'config/components/loggerFactory.php',
	/**
	 * Путь к файлу фабрики возвращающий реализацию PSR-11 ContainerInterface или сам экземпляр класса
	 */
	\Psr\Container\ContainerInterface::class => 'config/components/containerFactory.php',
];
