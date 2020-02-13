<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Controller\Customer;

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

    public function __construct(
        Context $context,
        UrlParametersEncryptorInterface $urlParametersEncryptor
    ) {
        parent::__construct($context);
        $this->urlParametersEncryptor = $urlParametersEncryptor;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $hash = (string) $this->getRequest()->getParam(Login::PARAM_HASH);
        $params = $this->urlParametersEncryptor->decrypt($hash);

        // TODO: Implement execute() method.
    }
}
