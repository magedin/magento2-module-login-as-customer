<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

/**
 * Class Authenticator
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
interface AuthenticatorInterface
{
    /**
     * @param int $entityId
     * @param int $adminUserId
     *
     * @return object
     */
    public function authenticate(int $entityId, int $adminUserId) : ?object;
}
