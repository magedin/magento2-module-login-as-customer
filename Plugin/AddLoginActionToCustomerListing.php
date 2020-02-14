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

    /**
     * @var \MagedIn\LoginAsCustomer\Model\Permission
     */
    private $permission;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \MagedIn\LoginAsCustomer\Model\CustomerLoginBackendUrlBuilder $loginUrlBuilder,
        \MagedIn\LoginAsCustomer\Model\Permission $permission
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->context = $context;
        $this->loginUrlBuilder = $loginUrlBuilder;
        $this->permission = $permission;
    }

    /**
     * @param Actions $subject
     * @param array   $dataSource
     */
    public function afterPrepareDataSource(Actions $subject, array $dataSource)
    {
        if (!$this->permission->allowLoginAsCustomer()) {
            return $dataSource;
        }

        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        array_walk($dataSource['data']['items'], [$this, 'processItem'], $subject);

        return $dataSource;
    }

    /**
     * @param array   $item
     * @param int     $key
     * @param Actions $subject
     */
    private function processItem(array &$item, int $key, Actions $subject)
    {
        if (!isset($item['entity_id'])) {
            return;
        }

        $item[$subject->getData('name')]['login'] = [
            'href'          => $this->loginUrlBuilder->getUrl((int) $item['entity_id']),
            'target'        => '_blank',
            'label'         => __('Login as Customer'),
            'hidden'        => false,
            '__disableTmpl' => true
        ];
    }
}
