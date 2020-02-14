<?php

namespace MagedIn\LoginAsCustomer\Block\Adminhtml\Customer\Edit;

use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class LoginButton
 *
 * @package MagedIn\LoginAsCustomer\Block\Adminhtml\Customer\Edit
 */
class LoginButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $authorization;

    /**
     * @var \MagedIn\LoginAsCustomer\Model\Config
     */
    private $config;

    /**
     * @var \MagedIn\LoginAsCustomer\Model\CustomerLoginBackendUrlBuilder
     */
    private $loginUrlBuilder;

    /**
     * @var \MagedIn\LoginAsCustomer\Model\Permission
     */
    private $permission;

    /**
     * LoginButton constructor.
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry           $registry
     * @param \MagedIn\LoginAsCustomer\Model\Config $config
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \MagedIn\LoginAsCustomer\Model\Config $config,
        \MagedIn\LoginAsCustomer\Model\Permission $permission,
        \MagedIn\LoginAsCustomer\Model\CustomerLoginBackendUrlBuilder $loginUrlBuilder
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
    public function getButtonData() : array
    {
        if (!$this->isButtonAvailable()) {
            return [];
        }

        return $this->getButtonInfo();
    }

    /**
     * @return array
     */
    private function getButtonInfo() : array
    {
        return [
            'label'      => __('Login As Customer'),
            'title'      => __('Login as this customer in the frontend and access customer panel.'),
            'class'      => 'add login login-button',
            'on_click'   => "window.open('{$this->loginUrlBuilder->getUrl((int) $this->getCustomerId())}')",
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
