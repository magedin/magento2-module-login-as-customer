<?php

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
}
