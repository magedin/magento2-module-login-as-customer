<?php

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
