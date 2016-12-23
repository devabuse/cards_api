<?php

namespace Cards\Service;

interface ServiceInterface
{
    /**
     * Provides a method to execute a service call
     *
     */
    public function execute();

    /**
     * Provide a caching ID if you wish the request to be cached. This of course only makes sense for GET requests
     *
     * @return string
     */
    public function getCacheID();
}
