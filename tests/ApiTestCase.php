<?php

abstract class ApiTestCase extends CommonPluginTestCase
{
    private $apiPrefix;

    /**
     * @param  string  $prefix
     */
    protected function setApiPrefix(string $prefix): void
    {
        $this->apiPrefix = trim($prefix, '/');
    }

    /**
     * @param  string  $uri
     * @return string
     */
    protected function getApiEndpoint(string $uri = ''): string
    {
        $uri = trim($uri, '/');

        return '/'.$this->apiPrefix.'/'.$uri;
    }
}
