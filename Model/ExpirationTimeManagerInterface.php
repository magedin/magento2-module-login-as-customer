<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

/**
 * Class ExpirationTimeManagerInterface
 */
interface ExpirationTimeManagerInterface
{
    /**
     * @var int
     */
    const DEFAULT_EXPIRATION_TIME = 60;

    /**
     * Min time = 30 seconds.
     * @var int
     */
    const MIN_EXPIRATION_TIME = 30;

    /**
     * Max time = 1 hour.
     * @var int
     */
    const MAX_EXPIRATION_TIME = 3600;

    /**
     * @return string
     */
    public function get() : string;
}
