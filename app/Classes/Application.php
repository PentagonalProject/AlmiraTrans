<?php
namespace PentagonalProject\AlmiraTrans;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App as Slim;
use Slim\Http\Environment;

/**
 * Class Application
 * @package Pentagonal\Project\AlmiraTrans
 */
class Application
{
    /**
     * @var Slim
     */
    protected $slim;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->slim = $this->buildSlim();
    }

    /**
     * Build Slim
     *
     * @return Slim
     */
    protected function buildSlim()
    {
        return new Slim(
            [
                /**
                 * Environments
                 */
                'environment' => Environment::mock($this->portServerManipulation()),
                'settings' => [
                    'displayErrorDetails' => true,
                ],
                'view' => function($container) {
                    return new Template(dirname(__DIR__) . '/Views/', $container);
                },
                'notFoundHandler' => function($container) {
                    return function ($request, $response) use ($container) {
                        /** @var ResponseInterface $response */
                        $response = $container['response'];
                        $response = $response
                            ->withStatus(404)
                            ->withHeader('Content-Type', 'text/html');

                        /**
                         * @var Template $container ['view']
                         */
                        return $container['view']
                            ->render(
                                '404',
                                $response
                            );
                    };
                },
                'errorHandler' => function($container) {
                    return function ($request, $response, $exception) use ($container) {
                        /** @var ResponseInterface $response */
                        $response = $container['response'];
                        $response = $response
                            ->withStatus(500)
                            ->withHeader('Content-Type', 'text/html');

                        /**
                         * @var Template $container ['view']
                         */
                        return $container['view']
                            ->render(
                                '500',
                                $response,
                                [
                                    'exception' => $exception
                                ]
                            );
                    };
                },
                'notAllowedHandler' => function($container) {
                    return function ($request, $response, $methods) use ($container) {
                        /** @var ResponseInterface $response */
                        $response = $container['response'];
                        $response = $response
                            ->withStatus(405)
                            ->withHeader('Content-Type', 'text/html');

                        /**
                         * @var Template $container ['view']
                         */
                        return $container['view']
                            ->render(
                                '405',
                                $response,
                                [
                                    'methods' => $methods
                                ]
                            );
                    };
                }
            ]
        );
    }

    /**
     * Detecting & Fix Environment on some cases
     *     Default Environment uses $_SERVER to attach
     *     just to fix https
     *
     * @return array
     */
    protected function portServerManipulation()
    {
        static $server;
        if (isset($server)) {
            return $server;
        }

        $server = $_SERVER;
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off'
            // hide behind proxy / maybe cloud flare cdn
            || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
            || !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off'
        ) {
            // detect if non standard protocol
            if ($_SERVER['SERVER_PORT'] == 80
                && (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])
                    || isset($_SERVER['HTTP_FRONT_END_HTTPS'])
                )
            ) {
                $_SERVER['SERVER_PORT_MANIPULATED'] = 443;
                $server['SERVER_PORT'] = 443;
                $server['SERVER_PORT_MANIPULATED'] = 80;
            }
            // fixing HTTPS Environment
            $_SERVER['HTTPS_MANIPULATED'] = 'on';
            $server['HTTPS'] = 'on';
            $server['HTTPS_MANIPULATED'] = 'on';
        }

        return $server;
    }

    protected function buildRoutes()
    {
        $this->slim->map(
            [
                'GET',
                'POTS',
                'PUT',
                'PATCH',
                'DELETE',
                'CONNECT',
                'TRACE',
                'HEAD',
                'OPTIONS'
            ],
            '[/]',
            function (ServerRequestInterface $request, ResponseInterface $response) {
                /**
                 * @var Template $view
                 */
                $view = $this['view'];
                return $view->render('home');
            }
        );
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function run()
    {
        $this->buildRoutes();
        return $this->slim->run();
    }
}
