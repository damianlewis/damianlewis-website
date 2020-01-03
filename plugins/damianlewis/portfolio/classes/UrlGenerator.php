<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes;

trait UrlGenerator
{
    /**
     * @var string
     */
    protected $basePath;

    /**
     * Returns a URL for the given parameters.
     *
     * @param  array  $parameters
     * @return string
     */
    public function getUrl(array $parameters = []): string
    {
        if ($this->basePath === null) {
            return '';
        }

        return url($this->basePath, $parameters);
    }

    public function setBasePath(string $path): void
    {
        $this->basePath = $path;
    }

}