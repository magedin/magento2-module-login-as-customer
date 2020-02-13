<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

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
     * @param int    $storeId
     * @param string $secret
     * @param int    $adminUserId
     *
     * @return bool
     */
    public function match(int $customerId, int $storeId, string $secret, int $adminUserId) : bool;

    /**
     * @param string $secret
     *
     * @return bool
     */
    public function delete(string $secret) : bool;

    /**
     * @param int $customerId
     *
     * @return bool
     */
    public function deleteByCustomerId(int $customerId) : bool;
}
