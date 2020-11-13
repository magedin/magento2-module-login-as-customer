<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model;

use MagedIn\LoginAsCustomer\Service\AdminUserService;

/**
 * Class CustomerAuthenticator
 *
 * Customer authenticator model class.
 */
class CustomerAuthenticator implements AuthenticatorInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;

    /**
     * @var AdminUserService
     */
    private $adminUserService;

    public function __construct(
        \Magento\Customer\Model\Session $session,
        AdminUserService $adminUserService
    ) {
        $this->session = $session;
        $this->adminUserService = $adminUserService;
    }

    /**
     * @param int $entityId
     * @param int $adminUserId
     *
     * @return object|null
     */
    public function authenticate(int $entityId, int $adminUserId) : ?object
    {
        if ($this->session->isLoggedIn()) {
            $this->session->logout();
        }

        if (!$this->session->loginById($entityId)) {
            /** @todo Do something when authentication fails. */
            return null;
        }

        $this->adminUserService->registerAdminUser($adminUserId);

        return $this->session->getCustomer();
    }
}
