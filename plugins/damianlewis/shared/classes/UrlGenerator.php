<?php

declare(strict_types=1);

namespace DamianLewis\Shared\Classes;

trait UrlGenerator
{
    /**
     * @var string
     */
    protected ?string $basePath = null;

    /**
     * Returns a URL for the given parameters.
     *
     * @param  array  $parameters
     * @return string
     */
    public function getUrl(array $parameters = []): string
    {
        if ($this->basePath !== null) {
            return url($this->basePath, $parameters);
        }

        return url('', $parameters);
    }

    /**
     * Returns a URL if the URI isn't an empty value.
     *
     * @param  string|null  $uri
     * @param  array  $parameters
     * @return string|null
     */
    public function getUrlOrNull(?string $uri, array $parameters = []): ?string
    {
        if (empty($uri)) {
            return null;
        }

        return $this->getUrl($parameters);
    }

    /**
     * Sets the base path used to generate the URL.
     *
     * @param  string  $path
     */
    public function setBasePath(string $path): void
    {
        $this->basePath = $path;
    }
}
