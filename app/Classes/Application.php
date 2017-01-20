<?php
namespace PentagonalProject\AlmiraTrans;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App as Slim;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Uri;

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
                    $template = new Template(dirname(__DIR__) . '/Views/', $container);
                    /**
                     * @var Request $request
                     * @var Uri $uri
                     */
                    $request = $container['request'];
                    $uri = $request->getUri();
                    $template->setAttributes(
                        [
                            'base:url' => rtrim($uri->getBaseUrl(), '/')
                        ]
                    );
                    if (file_exists(dirname(__DIR__).'/property.php')) {
                        ob_start();
                        $prop = require_once dirname(__DIR__) .'/property.php';
                        ob_clean();
                        if (is_array($prop)) {
                            $template->setAttributes($prop);
                        }
                    }

                    return $template;
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
        $mapAll = [
            'GET',
            'POTS',
            'PUT',
            'PATCH',
            'DELETE',
            'CONNECT',
            'TRACE',
            'HEAD',
            'OPTIONS'
        ];
        $this->slim->map(
            $mapAll,
            '[/]',
            function (ServerRequestInterface $request, ResponseInterface $response) {
                /**
                 * @var Template $view
                 */
                $view = $this['view'];
                return $view->render('home');
            }
        );
        $this->slim->map(
            $mapAll,
            '/google-fonts/{params: (?i)[a-z0-9\-\:\,]+}.css',
            function (ServerRequestInterface $request, ResponseInterface $response, $params) {
                $params = $params['params'];
                $params = explode('-', $params);
                $GoogleUri = $request->getUri()->getScheme()
                    . '://fonts.googleapis.com/css?family=';//Lato:300,400,700|Lobster;
                $GoogleUri .= implode('|', $params);
                $opts = [
                    'http' => [
                        'method'=> "GET",
                        'header'=> "User-Agent: {$request->getHeader('user-agent')[0]}\r\n"
                    ]
                ];
                $context = stream_context_create($opts);
                $content = file_get_contents($GoogleUri, false, $context);
                // Remove Comments
                $content = preg_replace('/(^\s*|\s*$|\/\*(?:(?!\*\/)[\s\S])*\*\/|[\r\n\t]+)/', '', $content);
                $regex = '(?six)
                  \s*+;\s*(})\s*
                | \s*([*$~^|]?=|[{};,>~+-]|\s+!important\b)\s*
                | ([[(:])\s+
                | \s+([\]\)])
                | \s+(:)\s+
                (?!
                    (?>
                        [^{}"\']++
                        | \"(?:[^"\\\\]++|\\\\.)*\"
                        | \'(?:[^\'\\\\]++|\\\\.)*\' 
                    )*
                    {
                )
                | ^\s+|\s+ \z
                | (\s)\s+
                | (\#((?:[a-f]|[A-F]|[0-9]){3}))(?:\\2)?\b # replace same value hex digit to 3 character eg 
                ';
                // clean CSS
                $content = preg_replace("%{$regex}%", '$1$2$3$4$5$6$7', $content);
                // strip http
                $content = preg_replace('%https?:\/\/%', '//', $content);
                $body = $response
                    ->getBody();
                $body->write($content);
                $response = $response
                    ->withHeader('Content-Type', 'text/css;charset=utf-8')
                    ->withHeader('Cache-Control', 'max-age=2678400, public')
                    ->withBody($body);
                return $response;
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
