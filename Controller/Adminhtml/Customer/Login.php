<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Controller\Adminhtml\Customer;

use MagedIn\LoginAsCustomer\Model\FrontendUrlBuilder;
use MagedIn\LoginAsCustomer\Model\SecretManagerInterface;
use MagedIn\LoginAsCustomer\Model\UrlParametersEncryptorInterface;
use MagedIn\LoginAsCustomer\Model\Validator\CustomerIdValidator;
use MagedIn\LoginAsCustomer\Model\Validator\ParametersValidator;
use Magento\Backend\App\Action;
use Magento\Backend\Model\Auth\Session;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use MagedIn\LoginAsCustomer\Api\Data;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class Login extends Action
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var FrontendUrlBuilder
     */
    private $frontendUrlBuilder;

    /**
     * @var SecretManagerInterface
     */
    private $secretManager;

    /**
     * @var UrlParametersEncryptorInterface
     */
    private $urlParametersEncryptor;

    /**
     * @var CustomerIdValidator
     */
    private $customerIdValidator;

    public function __construct(
        Action\Context $context,
        CustomerRepositoryInterface $customerRepository,
        Session $session,
        StoreManagerInterface $storeManager,
        FrontendUrlBuilder $frontendUrlBuilder,
        SecretManagerInterface $secretManager,
        UrlParametersEncryptorInterface $urlParametersEncryptor,
        CustomerIdValidator $customerIdValidator
    ) {
        parent::__construct($context);
        $this->customerRepository = $customerRepository;
        $this->session = $session;
        $this->storeManager = $storeManager;
        $this->frontendUrlBuilder = $frontendUrlBuilder;
        $this->secretManager = $secretManager;
        $this->urlParametersEncryptor = $urlParametersEncryptor;
        $this->customerIdValidator = $customerIdValidator;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $customerId = $this->getCustomerId();

        if (!$this->customerIdValidator->validate($customerId)) {
            $this->messageManager->addErrorMessage(__('Please inform a valid customer ID.'));

            return $this->_redirect('customer/index/index');
        }

        try {
            /** @var CustomerInterface $customer */
            $customer = $this->initCustomer($customerId);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Please inform a valid customer ID.'));

            return $this->_redirect('customer/index/index');
        }

        /** @var Data\LoginInterface $login */
        $login = $this->secretManager->create(
            (int) $customer->getId(),
            (int) $customer->getStoreId(),
            (int) $this->session->getUser()->getId()
        );

        $redirectUrl = $this->getFrontendUrl($login);

        $result = $this->resultRedirectFactory->create();
        $result->setUrl($redirectUrl);

        return $result;
    }

    /**
     * @param int $customerId
     *
     * @return CustomerInterface|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function initCustomer(int $customerId): ?CustomerInterface
    {
        $customer = $this->customerRepository->getById($customerId);

        if (!$customer->getId()) {
            return null;
        }

        return $customer;
    }

    /**
     * @return int
     */
    private function getCustomerId(): int
    {
        return (int) $this->getRequest()->getParam(ParametersValidator::PARAM_CUSTOMER_ID);
    }

    /**
     * @param Data\LoginInterface $login
     *
     * @return string
     * @throws NoSuchEntityException
     */
    private function getFrontendUrl(Data\LoginInterface $login): string
    {
        $data = [
            ParametersValidator::PARAM_STORE_ID => $login->getStoreId(),
            ParametersValidator::PARAM_CUSTOMER_ID => $login->getCustomerId(),
            ParametersValidator::PARAM_SECRET => $login->getSecret(),
            ParametersValidator::PARAM_ADMIN_USER_ID => $login->getAdminUserId(),
        ];

        $params = [
            ParametersValidator::PARAM_HASH => $this->urlParametersEncryptor->encrypt($data),
            '_nosid' => true,
        ];

        $store = $this->storeManager->getStore($login->getStoreId());
        $this->frontendUrlBuilder->setStore($store);

        return $this->frontendUrlBuilder->buildUrl('magedin_loginascustomer/customer/auth', $params);
    }
}
