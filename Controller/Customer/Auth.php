<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Controller\Customer;

use MagedIn\LoginAsCustomer\Api\SecretManagerInterface;
use MagedIn\LoginAsCustomer\Api\UrlParametersEncryptorInterface;
use MagedIn\LoginAsCustomer\Model\CustomerAuthenticator;
use MagedIn\LoginAsCustomer\Model\Validator\ParametersValidator;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

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

    /**
     * @var CustomerAuthenticator
     */
    private $customerAuthenticator;

    /**
     * @var ParametersValidator
     */
    private $parametersValidator;

    public function __construct(
        Context $context,
        UrlParametersEncryptorInterface $urlParametersEncryptor,
        SecretManagerInterface $secretManager,
        CustomerAuthenticator $customerAuthenticator,
        ParametersValidator $parametersValidator
    ) {
        parent::__construct($context);
        $this->urlParametersEncryptor = $urlParametersEncryptor;
        $this->secretManager = $secretManager;
        $this->customerAuthenticator = $customerAuthenticator;
        $this->parametersValidator = $parametersValidator;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $hash = (string) $this->getRequest()->getParam(ParametersValidator::PARAM_HASH);
        $params = $this->unpackHash($hash);

        try {
            $this->parametersValidator->validate($params);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->redirectToLogin();
        }

        $customerId = (int) $params[ParametersValidator::PARAM_CUSTOMER_ID];
        return $this->processLogin($customerId);
    }

    /**
     * @param string $hash
     *
     * @return array
     */
    private function unpackHash(string $hash) : array
    {
        $params = $this->urlParametersEncryptor->decrypt($hash);
        return (array) $params;
    }

    /**
     * @param int $customerId
     *
     * @return ResponseInterface
     */
    private function processLogin(int $customerId)
    {
        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $this->customerAuthenticator->authenticate($customerId);

        if (!$customer->getId()) {
            $this->messageManager->addErrorMessage(__('Could not login customer.'));
            return $this->redirectToLogin();
        }

        $this->messageManager->addSuccessMessage(__('You are now logged in as %1.', $customer->getName()));
        return $this->redirectToCustomerAccount();
    }

    /**
     * @return ResponseInterface
     */
    private function redirectToLogin() : ResponseInterface
    {
        return $this->_redirect('customer/account/login');
    }

    /**
     * @return ResponseInterface
     */
    private function redirectToCustomerAccount() : ResponseInterface
    {
        return $this->_redirect('customer/account');
    }
}
