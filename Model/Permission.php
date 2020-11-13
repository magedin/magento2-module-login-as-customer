<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Framework\AuthorizationInterface;

class Permission
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var AuthorizationInterface
     */
    private $authorization;

    public function __construct(
        Config $config,
        AuthorizationInterface $authorization
    ) {
        $this->config = $config;
        $this->authorization = $authorization;
    }

    /**
     * @return bool
     */
    public function allowLoginAsCustomer() : bool
    {
        if (!$this->config->isEnabled()) {
            return false;
        }

        if (!$this->authorization->isAllowed('MagedIn_LoginAsCustomer::login_button')) {
            return false;
        }

        return true;
    }
}
