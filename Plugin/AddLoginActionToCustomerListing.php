<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Plugin;

use Magento\Customer\Ui\Component\Listing\Column\Actions;

/**
 * Class AddLoginActionToCustomerListing
 *
 * @package MagedIn\LoginAsCustomer\Plugin
 */
class AddLoginActionToCustomerListing
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    /**
     * @var \Magento\Framework\View\Element\UiComponent\ContextInterface
     */
    private $context;

    /**
     * @var \MagedIn\LoginAsCustomer\Model\CustomerLoginBackendUrlBuilder
     */
    private $loginUrlBuilder;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \MagedIn\LoginAsCustomer\Model\CustomerLoginBackendUrlBuilder $loginUrlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->context = $context;
        $this->loginUrlBuilder = $loginUrlBuilder;
    }

    /**
     * @param Actions $subject
     * @param array   $dataSource
     */
    public function afterPrepareDataSource(Actions $subject, array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $customerId = $item['entity_id'];

                $item[$subject->getData('name')]['login'] = [
                    'href'          => $this->loginUrlBuilder->getUrl((int) $customerId),
                    'target'        => '_blank',
                    'label'         => __('Login as Customer'),
                    'hidden'        => false,
                    '__disableTmpl' => true
                ];
            }
        }

        return $dataSource;
    }
}
