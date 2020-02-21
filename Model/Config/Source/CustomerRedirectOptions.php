<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */
declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class CustomerRedirectOptions
 *
 * @package MagedIn\LoginAsCustomer\Model\Config\Source
 */
class CustomerRedirectOptions implements OptionSourceInterface
{
    /**
     * This is the default URL Path in case of misconfiguration.
     * @see \MagedIn\LoginAsCustomer\Controller\CustomerRedirectorInterface::redirectOnSuccess
     * @var string
     */
    const URL_PATH_CUSTOMER_ACCOUNT = 'customer/account';

    /**
     * @var string
     */
    const URL_PATH_CUSTOMER_ACCOUNT_INFORMATION = 'customer/account/edit';

    /**
     * @var string
     */
    const URL_PATH_CUSTOMER_ACCOUNT_ORDERS = 'customer/account/orders';

    /**
     * This is the default URL Path in case of fail in the login process.
     * @see \MagedIn\LoginAsCustomer\Controller\CustomerRedirectorInterface::redirectOnFail
     * @var string
     */
    const URL_PATH_CUSTOMER_LOGIN = 'customer/account/login';

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $options = [];

        /**
         * @var string $key
         * @var string $value
         */
        foreach ($this->toArray() as $key => $value) {
            $options[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        return $options;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            self::URL_PATH_CUSTOMER_ACCOUNT             => __('Customer Account Dashboard'),
            self::URL_PATH_CUSTOMER_ACCOUNT_INFORMATION => __('Customer Account Information'),
            self::URL_PATH_CUSTOMER_ACCOUNT_ORDERS      => __('Customer Account Orders'),
        ];
    }
}
