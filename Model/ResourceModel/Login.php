<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Login
 *
 * @package MagedIn\LoginAsCustomer\Model\ResourceModel
 */
class Login extends AbstractDb
{
    /**
     * @var string
     */
    const TABLE = 'magedin_login_as_customer';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(self::TABLE, 'id');
    }
}
