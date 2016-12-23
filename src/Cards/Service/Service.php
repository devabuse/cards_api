<?php

namespace Cards\Service;

abstract class Service {
    protected $cacheServiceProvider;
    protected $db;

    /**
     * Service constructor.
     * @param $db
     * @param $cacheServiceProvider
     */
    public function __construct($db, $cacheServiceProvider) {
        $this->cacheServiceProvider = $cacheServiceProvider;
        $this->db = $db;
    }

    /**
     * Sets a cache for a specific service call based on provided lifetime
     *
     * @param array $results
     * @param $lifetime
     */
    protected function setCache(array $results, $lifetime) {
        $this->cacheServiceProvider->save($this->getCacheID(), $results, $lifetime);
    }

    /**
     * Returns the cached version of the data
     *
     * @return mixed
     */
    protected function getCache() {
        return $this->cacheServiceProvider->fetch($this->getCacheID());
    }
}