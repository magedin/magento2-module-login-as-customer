<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Api\Data;

/**
 * Interface LoginInterface
 */
interface LoginInterface
{
    /**
     * @var string
     */
    const CUSTOMER_ID = 'customer_id';

    /**
     * @var string
     */
    const STORE_ID = 'store_id';

    /**
     * @var string
     */
    const ADMIN_USER_ID = 'admin_user_id';

    /**
     * @var string
     */
    const SECRET = 'secret';

    /**
     * @var string
     */
    const EXPIRES_AT = 'expires_at';

    /**
     * @return int
     */
    public function getCustomerId() : int;

    /**
     * @param int $customerId
     *
     * @return $this
     */
    public function setCustomerId(int $customerId) : self;

    /**
     * @return int
     */
    public function getStoreId() : int;

    /**
     * @param int $storeId
     *
     * @return $this
     */
    public function setStoreId(int $storeId) : self;

    /**
     * @return int
     */
    public function getAdminUserId() : int;

    /**
     * @param int $userId
     *
     * @return $this
     */
    public function setAdminUserId(int $userId) : self;

    /**
     * @return string
     */
    public function getSecret() : string;

    /**
     * @param string $secret
     *
     * @return $this
     */
    public function setSecret(string $secret) : self;

    /**
     * @return string
     */
    public function getExpiresAt() : string;

    /**
     * @param string $expiration
     *
     * @return $this
     */
    public function setExpiresAt(string $expiration) : self;
}
