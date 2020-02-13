<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Controller\Adminhtml\Customer;

use MagedIn\LoginAsCustomer\Api\UrlParametersEncryptorInterface;
use MagedIn\LoginAsCustomer\Model\Validator\ParametersValidator;
use Magento\Backend\App\Action;
use Magento\Customer\Api\Data\CustomerInterface;
use MagedIn\LoginAsCustomer\Api\Data;

/**
 * Class Login
 *
 * @package MagedIn\LoginAsCustomer\Controller\Adminhtml\Customer
 */
class Login extends Action
{
    /**
     * @var \MagedIn\LoginAsCustomer\Model\LoginFactory
     */
    private $loginFactory;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var \Magento\Customer\Model\ResourceModel\CustomerFactory
     */
    private $customerResourceFactory;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    private $session;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \MagedIn\LoginAsCustomer\Model\FrontendUrlBuilder
     */
    private $frontendUrlBuilder;

    /**
     * @var \MagedIn\LoginAsCustomer\Api\SecretManagerInterface
     */
    private $secretManager;

    /**
     * @var UrlParametersEncryptorInterface
     */
    private $urlParametersEncryptor;

    public function __construct(
        Action\Context $context,
        \MagedIn\LoginAsCustomer\Model\LoginFactory $loginFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Model\ResourceModel\CustomerFactory $customerResourceFactory,
        \Magento\Backend\Model\Auth\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \MagedIn\LoginAsCustomer\Model\FrontendUrlBuilder $frontendUrlBuilder,
        \MagedIn\LoginAsCustomer\Api\SecretManagerInterface $secretManager,
        \MagedIn\LoginAsCustomer\Api\UrlParametersEncryptorInterface $urlParametersEncryptor
    ) {
        parent::__construct($context);
        $this->loginFactory = $loginFactory;
        $this->customerRepository = $customerRepository;
        $this->customerResourceFactory = $customerResourceFactory;
        $this->session = $session;
        $this->storeManager = $storeManager;
        $this->frontendUrlBuilder = $frontendUrlBuilder;
        $this->secretManager = $secretManager;
        $this->urlParametersEncryptor = $urlParametersEncryptor;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $customerId = $this->getCustomerId();

        if (!$this->validateCustomerId($customerId)) {
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
     * @return CustomerInterface|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function initCustomer(int $customerId) : ?CustomerInterface
    {
        /** @var CustomerInterface $customer */
        $customer = $this->customerRepository->getById($customerId);

        if (!$customer->getId()) {
            return null;
        }

        return $customer;
    }

    /**
     * @return int
     */
    private function getCustomerId() : int
    {
        $customerId = (int) $this->getRequest()->getParam(ParametersValidator::PARAM_CUSTOMER_ID);

        return $customerId;
    }

    /**
     * @param int $customerId
     *
     * @return bool
     */
    private function validateCustomerId(int $customerId) : bool
    {
        if (!$customerId) {
            return false;
        }

        /** @var \Magento\Customer\Model\ResourceModel\Customer $resource */
        $resource = $this->customerResourceFactory->create();

        if (!$resource->checkCustomerId($customerId)) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    private function getFrontendUrl(Data\LoginInterface $login) : string
    {
        $data = [
            ParametersValidator::PARAM_STORE_ID    => $login->getStoreId(),
            ParametersValidator::PARAM_CUSTOMER_ID => $login->getCustomerId(),
            ParametersValidator::PARAM_SECRET      => $login->getSecret(),
        ];

        $params = [
            ParametersValidator::PARAM_HASH => $this->urlParametersEncryptor->encrypt($data),
            '_nosid'         => true,
        ];

        /** @var \Magento\Store\Api\Data\StoreInterface $store */
        $store = $this->storeManager->getStore($login->getStoreId());
        $this->frontendUrlBuilder->setStore($store);

        return $this->frontendUrlBuilder->buildUrl('magedin_loginascustomer/customer/auth', $params);
    }
}
