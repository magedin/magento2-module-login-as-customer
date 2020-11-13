<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Controller\Customer;

use MagedIn\LoginAsCustomer\Model\LoginProcessorInterface;
use MagedIn\LoginAsCustomer\Model\UrlParametersEncryptorInterface;
use MagedIn\LoginAsCustomer\Model\Validator\ParametersValidator;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

/**
 * Class Auth
 */
class Auth extends Action
{
    /**
     * @var UrlParametersEncryptorInterface
     */
    private $urlParametersEncryptor;

    /**
     * @var ParametersValidator
     */
    private $parametersValidator;

    /**
     * @var LoginProcessorInterface
     */
    private $loginProcessor;

    /**
     * @var \MagedIn\LoginAsCustomer\Service\AdminUserService
     */
    private $adminUserService;

    /**
     * @var \MagedIn\LoginAsCustomer\Controller\CustomerRedirectorInterface
     */
    private $customerRedirector;

    public function __construct(
        Context $context,
        UrlParametersEncryptorInterface $urlParametersEncryptor,
        ParametersValidator $parametersValidator,
        LoginProcessorInterface $loginProcessor,
        \MagedIn\LoginAsCustomer\Service\AdminUserService $adminUserService,
        \MagedIn\LoginAsCustomer\Controller\CustomerRedirectorInterface $customerRedirector
    ) {
        parent::__construct($context);
        $this->urlParametersEncryptor = $urlParametersEncryptor;
        $this->parametersValidator = $parametersValidator;
        $this->loginProcessor = $loginProcessor;
        $this->adminUserService = $adminUserService;
        $this->customerRedirector = $customerRedirector;
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
            return $this->customerRedirector->redirectOnFail();
        }

        $customerId  = (int) $params[ParametersValidator::PARAM_CUSTOMER_ID];
        $adminUserId = (int) $params[ParametersValidator::PARAM_ADMIN_USER_ID];

        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $this->loginProcessor->process($customerId, $adminUserId);

        if (!$customer->getId()) {
            $this->messageManager->addErrorMessage(__('Could not login customer.'));
            return $this->customerRedirector->redirectOnFail();
        }

        $user = $this->adminUserService->getRegisteredAdminUser();
        $this->messageManager->addSuccessMessage(
            __('Hi, %1! You are now logged in as %2.', $user->getName(), $customer->getName())
        );
        return $this->customerRedirector->redirectOnSuccess();
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
}
