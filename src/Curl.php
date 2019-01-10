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
     * Initialize a cURL session and clone object.
     *
     * @param string $url
     * @return CurlInterface
     * @throws CurlException
     */
    public function init(string $url = ''): CurlInterface
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
     * Set an option for a cURL transfer.
     *
     * @param int      $option
     * @param int|bool $value
     * @return void
     * @throws CurlException
     */
    public function setOpt(int $option, $value)
    {
        if (!curl_setopt($this->resource, $option, $value)) {
            throw new CurlException('Failed to cURL option.');
        }
    }

    /**
     * Set multiple options for a cURL transfer.
     *
     * @param array $options
     * @return void
     * @throws CurlException
     */
    public function setOptArray(array $options)
    {
        if (!curl_setopt_array($this->resource, $options)) {
            throw new CurlException('Failed to cURL option.');
        }
    }

    /**
     * Execute.
     *
     * @return mixed
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
     * Get information regarding a specific transfer.
     *
     * @param int $opt
     * @return mixed
     */
    public function getInfo(int $opt = 0)
    {
        if ($opt === 0) {
            return curl_getinfo($this->resource);
        }

        return curl_getinfo($this->resource, $opt);
    }

    /**
     * Return the last error number.
     *
     * @return int
     */
    public function errno(): int
    {
        return curl_errno($this->resource);
    }

    /**
     * Return a string containing the last error for the current session.
     *
     * @return string
     */
    public function error(): string
    {
        return curl_error($this->resource);
    }

    /**
     * Gets cURL version information.
     *
     * @param int $age
     * @return array
     */
    public function version(int $age = CURLVERSION_NOW): array
    {
        return curl_version($age);
    }

    /**
     * Close a cURL session.
     *
     * @return void
     */
    public function close(): void
    {
        curl_close($this->resource);
    }
}
