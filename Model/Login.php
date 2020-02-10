<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Login
 *
 * @method $this setCustomerId(int $customerId)
 * @method int   getCustomerId()
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
class Login extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'login_as_customer';

    /**
     * @var string
     */
    protected $_eventObject = 'login';

    protected function _construct()
    {
        $this->_init(ResourceModel\Login::class);
    }
}
