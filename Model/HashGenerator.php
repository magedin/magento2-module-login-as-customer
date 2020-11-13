<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Framework\Math\Random;

class HashGenerator implements HashGeneratorInterface
{
    /**
     * @var Random
     */
    private $generator;

    public function __construct(
        Random $generator
    ) {
        $this->generator = $generator;
    }

    /**
     * @inheritDoc
     */
    public function generateHash($length, $chars = null) : string
    {
        return $this->generator->getRandomString($length, $chars);
    }
}
