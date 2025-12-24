<?php

namespace Hhxsv5\LaravelS\Swoole\Proxy;

use Swoole\WebSocket\Server;

/**
 * WebSocketServerProxy solves the issue that PHP 8.2+ does not allow dynamic property creation.
 * Extends Swoole\WebSocket\Server to allow dynamic storage and access of tables.
 */
class WebSocketServerProxy extends Server
{
    use DynamicPropertiesTrait;
}

