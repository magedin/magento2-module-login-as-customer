<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Plugin;

use MagedIn\LoginAsCustomer\Model\CustomerLoginBackendUrlBuilder;
use MagedIn\LoginAsCustomer\Model\Permission;
use Magento\Customer\Ui\Component\Listing\Column\Actions;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class AddLoginActionToCustomerListing
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var CustomerLoginBackendUrlBuilder
     */
    private $loginUrlBuilder;

    /**
     * @var Permission
     */
    private $permission;

    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        CustomerLoginBackendUrlBuilder $loginUrlBuilder,
        Permission $permission
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->context = $context;
        $this->loginUrlBuilder = $loginUrlBuilder;
        $this->permission = $permission;
    }

    /**
     * @param Actions $subject
     * @param array   $dataSource
     *
     * @return array
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
