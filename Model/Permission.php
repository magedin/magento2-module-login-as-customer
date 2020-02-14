<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

/**
 * Class Permission
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
class Permission
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    private $authorization;

    public function __construct(
        Config $config,
        \Magento\Framework\AuthorizationInterface $authorization
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
