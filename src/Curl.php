<?php
declare(strict_types=1);

namespace Chanshige\SimpleCurl;

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
     * @param string $url
     * @throws CurlException
     */
    public function init(string $url = '')
    {
        $handle = curl_init($url);
        if ($handle === false) {
            throw new CurlException('failed init curl.');
        }

        $this->resource = $handle;
    }

    /**
     * @param int   $option
     * @param mixed $value
     * @return bool
     */
    public function setOpt(int $option, $value): bool
    {
        return curl_setopt($this->resource, $option, $value);
    }

    /**
     * @param array $options
     * @return bool
     */
    public function setOptArray(array $options): bool
    {
        return curl_setopt_array($this->resource, $options);
    }

    /**
     * @return mixed
     * @throws CurlException
     */
    public function exec()
    {
        $response = curl_exec($this->resource);
        if ($response === false) {
            $httpCode = $this->getInfo(CURLINFO_HTTP_CODE);
            $this->close();
            throw new CurlException('execute failed.', $httpCode);
        }

        return $response;
    }

    /**
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
     * @return int
     */
    public function errno(): int
    {
        return curl_errno($this->resource);
    }

    /**
     * @return string
     */
    public function error(): string
    {
        return curl_error($this->resource);
    }

    /**
     * @param int $age
     * @return array
     */
    public function version(int $age = CURLVERSION_NOW): array
    {
        return curl_version($age);
    }

    /**
     * @return void
     */
    public function close(): void
    {
        curl_close($this->resource);
    }
}
