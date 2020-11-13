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
 * Class UrlParametersEncryptor
 */
class UrlParametersEncryptor implements UrlParametersEncryptorInterface
{
    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    private $serializer;

    /**
     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    private $encryptor;

    public function __construct(
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor
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
        $hash = base64_decode($hash);
        $json = $this->encryptor->decrypt($hash);
        $params = $this->serializer->unserialize($json);
        return (array) $params;
    }
}
