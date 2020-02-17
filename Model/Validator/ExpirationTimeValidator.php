<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model\Validator;

/**
 * Class ExpirationTimeValidator
 *
 * @package MagedIn\LoginAsCustomer\Model\Validator
 */
class ExpirationTimeValidator
{
    /**
     * @param string $time
     *
     * @return bool
     */
    public function validate(string $time) : bool
    {
        $expiresAt = strtotime($time);
        $now = strtotime('now');
        $difference = $expiresAt - $now;

        if ($difference < 0) {
            return false;
        }

        return true;
    }
}
