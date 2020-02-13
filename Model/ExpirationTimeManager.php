<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

/**
 * Class ExpirationTimeManager
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
class ExpirationTimeManager implements ExpirationTimeManagerInterface
{
    /**
     * @var int
     */
    const DEFAULT_EXPIRATION_TIME = 60;

    /**
     * @var int
     */
    const MIN_EXPIRATION_TIME = 30;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $dateTime;

    public function __construct(
        \MagedIn\LoginAsCustomer\Model\Config $config,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
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
        $seconds = (int) max($this->config->getSecretKeyExpirationTime(), self::MIN_EXPIRATION_TIME);

        if (!$seconds) {
            return self::DEFAULT_EXPIRATION_TIME;
        }

        return $seconds;
    }
}
