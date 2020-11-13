<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

namespace MagedIn\LoginAsCustomer\Block\Adminhtml\Customer\Edit;

use MagedIn\LoginAsCustomer\Model\Config;
use MagedIn\LoginAsCustomer\Model\CustomerLoginBackendUrlBuilder;
use MagedIn\LoginAsCustomer\Model\Permission;
use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class LoginButton
 *
 * This class is responsible for generating a button for login action.
 */
class LoginButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @var AuthorizationInterface
     */
    protected $authorization;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var CustomerLoginBackendUrlBuilder
     */
    private $loginUrlBuilder;

    /**
     * @var Permission
     */
    private $permission;

    /**
     * LoginButton constructor.
     *
     * @param Context                        $context
     * @param Registry                       $registry
     * @param Config                         $config
     * @param Permission                     $permission
     * @param CustomerLoginBackendUrlBuilder $loginUrlBuilder
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Config $config,
        Permission $permission,
        CustomerLoginBackendUrlBuilder $loginUrlBuilder
    ) {
        parent::__construct($context, $registry);
        $this->config = $config;
        $this->authorization = $context->getAuthorization();
        $this->loginUrlBuilder = $loginUrlBuilder;
        $this->permission = $permission;
    }

    /**
     * @return array
     */
    public function getButtonData(): array
    {
        if (!$this->isButtonAvailable()) {
            return [];
        }

        return $this->getButtonInfo();
    }

    /**
     * @return array
     */
    private function getButtonInfo(): array
    {
        return [
            'label' => __('Login As Customer'),
            'title' => __('Login as this customer in the frontend and access customer panel.'),
            'class' => 'add login login-button',
            'on_click' => "window.open('{$this->loginUrlBuilder->getUrl((int) $this->getCustomerId())}')",
            'sort_order' => 70,
        ];
    }

    /**
     * Check if button can be available.
     *
     * @return bool
     */
    private function isButtonAvailable()
    {
        if (!$this->permission->allowLoginAsCustomer()) {
            return false;
        }

        if (!$this->getCustomerId()) {
            return false;
        }

        return true;
    }
}
