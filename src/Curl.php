<?php
declare(strict_types=1);

namespace Chanshige\SimpleCurl;

use Chanshige\SimpleCurl\Exception\CurlException;

/**
 * Class Curl
 *
 * @package Chanshige\SimpleCurl
 */
final class Curl implements CurlInterface
{
    /** @var resource */
    private $resource;

    /**
     * {@inheritdoc}
     * @throws CurlException
     */
    public function init(?string $url = ''): CurlInterface
    {
        $handle = curl_init($url);
        if ($handle === false) {
            throw new CurlException('Failed to cURL initialized.');
        }
        $clone = clone $this;
        $clone->resource = $handle;

        return $clone;
    }

    /**
     * {@inheritdoc}
     * @throws CurlException
     */
    public function setOpt(int $option, $value)
    {
        if (!curl_setopt($this->resource, $option, $value)) {
            throw new CurlException('Failed to cURL option.');
        }
    }

    /**
     * {@inheritdoc}
     * @throws CurlException
     */
    public function setOptArray(array $options)
    {
        if (!curl_setopt_array($this->resource, $options)) {
            throw new CurlException('Failed to cURL option.');
        }
    }

    /**
     * {@inheritdoc}
     * @throws CurlException
     */
    public function exec()
    {
        $response = curl_exec($this->resource);
        if ($response === false) {
            throw new CurlException($this->error(), $this->errno());
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getInfo(?int $opt = null)
    {
        return curl_getinfo($this->resource, $opt);
    }

    /**
     * {@inheritdoc}
     */
    public function errno(): int
    {
        return curl_errno($this->resource);
    }

    /**
     * {@inheritdoc}
     */
    public function error(): string
    {
        return curl_error($this->resource);
    }

    /**
     * {@inheritdoc}
     */
    public function version(int $age = CURLVERSION_NOW): array
    {
        return curl_version($age);
    }

    /**
     * {@inheritdoc}
     */
    public function close(): void
    {
        curl_close($this->resource);
    }
}
