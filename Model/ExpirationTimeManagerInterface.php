<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

/**
 * Class ExpirationTimeManagerInterface
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
interface ExpirationTimeManagerInterface
{
    /**
     * @return string
     */
    public function get() : string;
}
