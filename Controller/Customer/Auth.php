<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Controller\Customer;

use MagedIn\LoginAsCustomer\Controller\Adminhtml\Customer\Login;
use Magento\Framework\App\Action\Action;

/**
 * Class Auth
 *
 * @package MagedIn\LoginAsCustomer\Controller\Customer
 */
class Auth extends Action
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $customerId = (int) $this->getRequest()->getParam(Login::PARAM_CUSTOMER_ID);
        $secret     = $this->getRequest()->getParam(Login::PARAM_SECRET);



        // TODO: Implement execute() method.
    }
}
