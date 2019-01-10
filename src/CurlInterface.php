<?php
namespace Chanshige\SimpleCurl;

/**
 * Interface CurlInterface
 *
 * @package Chanshige\SimpleCurl
 */
interface CurlInterface
{
    public function init(string $url): CurlInterface;

    public function close();

    public function errno(): int;

    public function error(): string;

    public function exec();

    public function getInfo(int $opt = 0);

    public function setOptArray(array $options);

    public function setOpt(int $option, $value);

    public function version(int $age): array;
}
