<?php

/*
 * This file is part of the Cache package.
 *
 * Copyright (c) Daniel González
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

namespace Desarrolla2\Test\Cache;

use Desarrolla2\Cache\Memcached as MemcachedCache;
use Memcached as BaseMemcached;

/**
 * MemcachedTest
 */
class MemcachedTest extends AbstractCacheTest
{
    public function createSimpleCache()
    {
        if (!extension_loaded('memcached') || !class_exists('\Memcached')) {
            $this->markTestSkipped(
                'The Memcached extension is not available.'
            );
        }

        $adapter = new BaseMemcached();
        $adapter->addServer($this->config['memcached']['host'], $this->config['memcached']['port']);

        if (!$adapter->flush()) {
            return $this->markTestSkipped("Unable to flush Memcached; not running?");
        }

        return new MemcachedCache($adapter);
    }

    /**
     * @return array
     */
    public function dataProviderForOptionsException()
    {
        return [
            ['ttl', 0, '\Desarrolla2\Cache\Exception\InvalidArgumentException'],
            ['file', 100, '\Desarrolla2\Cache\Exception\InvalidArgumentException'],
        ];
    }
}