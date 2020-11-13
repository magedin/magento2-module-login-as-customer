<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model;

use MagedIn\LoginAsCustomer\Api\Data;

/**
 * Class LoginRepositoryInterface
 */
interface LoginRepositoryInterface
{
    /**
     * @param Data\LoginInterface $login
     *
     * @return Data\LoginInterface
     */
    public function save(Data\LoginInterface $login) : Data\LoginInterface;

    /**
     * @param int $customerId
     *
     * @return Data\LoginInterface|null
     */
    public function getById(int $customerId) : ?Data\LoginInterface;

    /**
     * @param string $secret
     *
     * @return Data\LoginInterface|null
     */
    public function getBySecret(string $secret) : ?Data\LoginInterface;

    /**
     * @param string $secret
     *
     * @return bool
     */
    public function deleteBySecret(string $secret) : bool;

    /**
     * @param int $customerId
     *
     * @return bool
     */
    public function deleteByCustomerId(int $customerId) : bool;
}
