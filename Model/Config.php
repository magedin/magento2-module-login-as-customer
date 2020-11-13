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
    const XML_PATH_REDIRECT_AFTER_LOGIN = 'magedin_loginascustomer/general/redirect_after_login';

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
        return (bool) $this->getConfig(self::XML_PATH_ENABLED);
    }

    /**
     * @return string
     */
    public function getRedirectAfterLogin() : ?string
    {
        return (string) $this->getConfig(self::XML_PATH_REDIRECT_AFTER_LOGIN);
    }

    /**
     * @return int
     */
    public function getSecretKeyExpirationTime() : int
    {
        return (int) $this->getConfig(self::XML_PATH_SECRET_KEY_EXPIRATION_TIME);
    }

    /**
     * @param string $path
     * @param string $scopeType
     *
     * @return string
     */
    private function getConfig(string $path, $scopeType = ScopeInterface::SCOPE_STORE)
    {
        return $this->scopeConfig->getValue($path, $scopeType);
    }
}
