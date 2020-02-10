<?php

namespace MagedIn\LoginAsCustomer\Block\Adminhtml\Customer\Edit;

use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Context;

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
     * LoginButton constructor.
     *
     * @param Context                                   $context
     * @param Registry                                  $registry
     * @param \MagedIn\LoginAsCustomer\Model\Config     $config
     * @param \Magento\Framework\AuthorizationInterface $authorization
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \MagedIn\LoginAsCustomer\Model\Config $config
    ) {
        parent::__construct($context, $registry);
        $this->config = $config;
        $this->authorization = $context->getAuthorization();
    }

    /**
     * @return array
     */
    public function getButtonData() : array
    {
        $data      = [];
        $canModify = $this->getCustomerId() && $this->authorization->isAllowed('MagedIn_LoginAsCustomer::login_button');

        if (!$canModify || !$this->config->isEnabled()) {
            return $data;
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
            'class'      => 'add login login-button',
            'on_click'   => "window.open('{$this->getLoginAsCustomerUrl()}')",
            'sort_order' => 70,
        ];
    }

    /**
     * @return string
     */
    private function getLoginAsCustomerUrl() : string
    {
        return $this->getUrl('magedin_loginascustomer/customer/login', ['customer_id' => $this->getCustomerId()]);
    }
}
