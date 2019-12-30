<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes;

interface UrlGeneratorInterface
{
    /**
     * Sets the base path used by a URI.
     *
     * @param  string  $path
     */
    public function setBasePath(string $path): void;
}