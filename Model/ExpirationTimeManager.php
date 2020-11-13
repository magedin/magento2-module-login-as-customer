<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Class ExpirationTimeManager
 *
 * This class is responsible for managing the expiration time.
 */
class ExpirationTimeManager implements ExpirationTimeManagerInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var DateTime
     */
    private $dateTime;

    public function __construct(
        Config $config,
        DateTime $dateTime
    ) {
        $this->config = $config;
        $this->dateTime = $dateTime;
    }

    /**
     * @return string
     */
    public function get() : string
    {
        $input    = strtotime("+{$this->getExpirationTimeSeconds()} seconds");
        $datetime = $this->dateTime->date('Y-m-d H:i:s', $input);
        return $datetime;
    }

    /**
     * @return int
     */
    private function getExpirationTimeSeconds() : int
    {
        /**
         * Time can't be less than MIN_EXPIRATION_TIME and nor max than MAX_EXPIRATION_TIME.
         */
        $seconds = (int) max($this->config->getSecretKeyExpirationTime(), self::MIN_EXPIRATION_TIME);
        $seconds = (int) min($seconds, self::MAX_EXPIRATION_TIME);

        if (!$seconds) {
            return self::DEFAULT_EXPIRATION_TIME;
        }

        return $seconds;
    }
}
