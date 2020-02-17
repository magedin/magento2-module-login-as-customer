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
 * Class HashGeneratorInterface
 *
 * @package MagedIn\LoginAsCustomer\Api
 */
interface HashGeneratorInterface
{
    /**
     * Get random string.
     *
     * @param int $length
     * @param null|string $chars
     *
     * @return string
     */
    public function generateHash($length, $chars = null);
}
