<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Api;

/**
 * Class UrlParametersEncryptorInterface
 *
 * @package MagedIn\LoginAsCustomer\Api
 */
interface UrlParametersEncryptorInterface
{
    /**
     * @param array $parameters
     *
     * @return string|null
     */
    public function encrypt(array $parameters) : ?string;

    /**
     * @param string $hash
     *
     * @return array|null
     */
    public function decrypt(string $hash) : ?array;
}
