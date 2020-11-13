<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */
declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Controller;

use Magento\Framework\App\ResponseInterface;

/**
 * Class CustomerRedirectorInterface
 */
interface CustomerRedirectorInterface
{
    /**
     * @param array $arguments
     *
     * @return ResponseInterface
     */
    public function redirectOnSuccess(array $arguments = []) : ResponseInterface;

    /**
     * @param array $arguments
     *
     * @return ResponseInterface
     */
    public function redirectOnFail(array $arguments = []) : ResponseInterface;
}
