<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */
declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Controller;

use MagedIn\LoginAsCustomer\Model\Config\Source\CustomerRedirectOptions;
use Magento\Framework\App\ResponseInterface;

/**
 * Class CustomerRedirector
 *
 * @package MagedIn\LoginAsCustomer\Controller
 */
class CustomerRedirector implements CustomerRedirectorInterface
{
    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    private $redirect;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var \MagedIn\LoginAsCustomer\Model\Config
     */
    private $config;

    public function __construct(
        ResponseInterface $response,
        \MagedIn\LoginAsCustomer\Model\Config $config,
        \Magento\Framework\App\Response\RedirectInterface $redirect
    ) {
        $this->redirect = $redirect;
        $this->config = $config;
        $this->response = $response;
    }

    /**
     * @param array $arguments
     *
     * @return ResponseInterface
     */
    public function redirectOnSuccess(array $arguments = []) : ResponseInterface
    {
        $urlPath = $this->config->getRedirectAfterLogin();

        if (empty($urlPath)) {
            $urlPath = CustomerRedirectOptions::URL_PATH_CUSTOMER_ACCOUNT;
        }

        return $this->redirect($urlPath, $arguments);
    }

    /**
     * @param array $arguments
     *
     * @return ResponseInterface
     */
    public function redirectOnFail(array $arguments = []) : ResponseInterface
    {
        return $this->redirectToLogin($arguments);
    }

    /**
     * @param array $arguments
     *
     * @return ResponseInterface
     */
    private function redirectToLogin(array $arguments = []) : ResponseInterface
    {
        return $this->redirect(CustomerRedirectOptions::URL_PATH_CUSTOMER_LOGIN, $arguments);
    }

    /**
     * @param string $path
     * @param array  $arguments
     *
     * @return ResponseInterface
     */
    private function redirect(string $path, $arguments = []) : ResponseInterface
    {
        $this->redirect->redirect($this->response, $path, $arguments);
        return $this->response;
    }
}
