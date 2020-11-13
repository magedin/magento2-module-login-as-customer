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
 * Class UrlParametersEncryptorInterface
 */
interface UrlParametersEncryptorInterface
{
    /**
     * @param array $parameters
     *
     * @return string|null
     */
    public function encrypt(array $parameters) : ?string;

    /**
     * @param string $hash
     *
     * @return array|null
     */
    public function decrypt(string $hash) : ?array;
}
