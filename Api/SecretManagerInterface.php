<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Api;

/**
 * Class SecretManagerInterface
 *
 * @package MagedIn\LoginAsCustomer\Api
 */
interface SecretManagerInterface
{
    /**
     * @return string
     */
    public function generate() : string;

    /**
     * @param int    $customerId
     * @param string $secret
     *
     * @return bool
     */
    public function match(int $customerId, string $secret) : bool;
}
