<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Controller\Customer;

use MagedIn\LoginAsCustomer\Api\SecretManagerInterface;
use MagedIn\LoginAsCustomer\Api\UrlParametersEncryptorInterface;
use MagedIn\LoginAsCustomer\Controller\Adminhtml\Customer\Login;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

/**
 * Class Auth
 *
 * @package MagedIn\LoginAsCustomer\Controller\Customer
 */
class Auth extends Action
{
    /**
     * @var UrlParametersEncryptorInterface
     */
    private $urlParametersEncryptor;

    /**
     * @var SecretManagerInterface
     */
    private $secretManager;

    public function __construct(
        Context $context,
        UrlParametersEncryptorInterface $urlParametersEncryptor,
        SecretManagerInterface $secretManager
    ) {
        parent::__construct($context);
        $this->urlParametersEncryptor = $urlParametersEncryptor;
        $this->secretManager = $secretManager;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $hash = (string) $this->getRequest()->getParam(Login::PARAM_HASH);
        $params = $this->urlParametersEncryptor->decrypt($hash);

        /** @todo Validate this. */
        $customerId = (int) $params[Login::PARAM_CUSTOMER_ID];
        $storeId = (int) $params[Login::PARAM_STORE_ID];
        $secret = (string) $params[Login::PARAM_SECRET];

        if (!$this->secretManager->match($customerId, $storeId, $secret)) {
            $this->messageManager->addErrorMessage(__('Could not login customer.'));
            return $this->_redirect('customer/account/login');
        }

        /** @todo Authenticate customer. */
    }
}
