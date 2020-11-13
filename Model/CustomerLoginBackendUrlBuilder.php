<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Framework\UrlInterface;

/**
 * Class CustomerLoginBackendUrlBuilder
 *
 * This class is responsible for building URL for backend.
 */
class CustomerLoginBackendUrlBuilder
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    public function __construct(
        \Magento\Backend\Model\UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @return string
     */
    public function getUrl(int $customerId) : string
    {
        $params = ['customer_id' => $customerId];
        return $this->urlBuilder->getUrl('magedin_loginascustomer/customer/login', $params);
    }
}
