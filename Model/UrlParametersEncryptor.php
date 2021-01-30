<?php
/**
 * MagedIn Technology
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category  MagedIn
 * @copyright Copyright (c) 2021 MagedIn Technology.
 *
 * @author    MagedIn Support <support@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Serialize\SerializerInterface;

class UrlParametersEncryptor implements UrlParametersEncryptorInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    public function __construct(
        SerializerInterface $serializer,
        EncryptorInterface $encryptor
    ) {
        $this->serializer = $serializer;
        $this->encryptor = $encryptor;
    }

    /**
     * @inheritDoc
     */
    public function encrypt(array $params) : string
    {
        $json = $this->serializer->serialize($params);
        $hash = $this->encryptor->encrypt($json);
        $hash = base64_encode($hash);

        return (string) $hash;
    }

    /**
     * @inheritDoc
     */
    public function decrypt(string $hash) : ?array
    {
        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        $hash = base64_decode($hash);
        // phpcs:ignore Magento2.Security.LanguageConstruct.ExitUsage
        $json = $this->encryptor->decrypt($hash);
        $params = $this->serializer->unserialize($json);
        return (array) $params;
    }
}
