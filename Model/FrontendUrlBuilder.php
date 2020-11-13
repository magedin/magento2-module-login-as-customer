<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Store\Api\Data\StoreInterface;

/**
 * Class FrontendUrl
 */
class FrontendUrlBuilder
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $url;

    public function __construct(
        \Magento\Framework\UrlInterface $url
    ) {
        $this->url = $url;
    }

    /**
     * @param StoreInterface $store
     */
    public function setStore(StoreInterface $store)
    {
        $this->url->setScope($store);
    }

    /**
     * @param   string|null $routePath
     * @param   array|null $routeParams
     *
     * @return string
     */
    public function buildUrl($routePath = null, $routeParams = null)
    {
        return $this->url->getUrl($routePath, $routeParams);
    }
}
