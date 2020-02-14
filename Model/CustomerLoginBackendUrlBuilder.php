<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

/**
 * Class CustomerLoginBackendUrlBuilder
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
class CustomerLoginBackendUrlBuilder
{
    /**
     * @var \Magento\Framework\UrlInterface
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
