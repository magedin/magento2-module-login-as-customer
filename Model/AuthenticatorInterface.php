<?php
/**
 * MagedIn Technology
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category  MagedIn
 * @copyright Copyright (c) 2021 MagedIn Technology.
 *
 * @author    MagedIn Support <support@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model;

/**
 * Class Authenticator
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
