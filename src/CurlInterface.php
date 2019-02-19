<?php
namespace Chanshige\SimpleCurl;

/**
 * Interface CurlInterface
 *
 * @package Chanshige\SimpleCurl
 */
interface CurlInterface
{
    /**
     * Initialize a cURL session and clone object.
     *
     * @param string $url
     * @return CurlInterface
     */
    public function init(string $url = ''): CurlInterface;

    /**
     * Close a cURL session.
     *
     * @return void
     */
    public function close();

    /**
     * Return the last error number.
     *
     * @return int
     */
    public function errno(): int;

    /**
     * Return a string containing the last error for the current session.
     *
     * @return string
     */
    public function error(): string;

    /**
     * Execute.
     *
     * @return mixed
     */
    public function exec();

    /**
     * Get information regarding a specific transfer.
     *
     * @param int|null $opt
     * @return mixed
     */
    public function getInfo(?int $opt = null);

    /**
     * Set multiple options for a cURL transfer.
     *
     * @param array $options
     * @return void
     */
    public function setOptArray(array $options);

    /**
     * Set an option for a cURL transfer.
     *
     * @param int   $option
     * @param mixed $value
     * @return void
     */
    public function setOpt(int $option, $value);

    /**
     * Gets cURL version information.
     *
     * @param int $age
     * @return array
     */
    public function version(int $age): array;
}
