<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */
declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model\Validator;

use Magento\Customer\Model\ResourceModel\Customer;

/**
 * Class CustomerIdValidator
 *
 * Customer identifier validator model class.
 */
class CustomerIdValidator
{
    /**
     * @var Customer
     */
    private $customerResource;

    public function __construct(
        Customer $customerResource
    ) {
        $this->customerResource = $customerResource;
    }

    /**
     * @param int $customerId
     *
     * @return bool
     */
    public function validate(int $customerId) : bool
    {
        if (!$customerId) {
            return false;
        }

        if (!$this->customerResource->checkCustomerId($customerId)) {
            return false;
        }

        return true;
    }
}
