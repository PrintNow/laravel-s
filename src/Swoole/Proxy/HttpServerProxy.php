<?php

namespace Hhxsv5\LaravelS\Swoole\Proxy;

use Swoole\Http\Server;

/**
 * HttpServerProxy solves the issue that PHP 8.2+ does not allow dynamic property creation.
 * Extends Swoole\Http\Server to allow dynamic storage and access of tables.
 */
class HttpServerProxy extends Server
{
    use DynamicPropertiesTrait;
}

