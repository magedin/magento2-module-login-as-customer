<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
class Config
{
    /**
     * @var string
     */
    const XML_PATH_ENABLED = 'magedin_loginascustomer/general/enable';

    /**
     * @var string
     */
    const XML_PATH_SECRET_KEY_EXPIRATION_TIME = 'magedin_loginascustomer/security/secret_key_expiration_time';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var DateTime
     */
    private $dateTime;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->dateTime = $dateTime;
    }

    /**
     * @return bool
     */
    public function isEnabled() : bool
    {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return int
     */
    public function getSecretKeyExpirationTime() : int
    {
        return (int) $this->scopeConfig->getValue(
            self::XML_PATH_SECRET_KEY_EXPIRATION_TIME,
            ScopeInterface::SCOPE_STORE
        );
    }
}
