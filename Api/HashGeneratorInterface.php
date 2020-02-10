<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Api;

/**
 * Class HashGeneratorInterface
 *
 * @package MagedIn\LoginAsCustomer\Api
 */
interface HashGeneratorInterface
{
    /**
     * Get random string.
     *
     * @param int $length
     * @param null|string $chars
     *
     * @return string
     */
    public function generateHash($length, $chars = null);
}
