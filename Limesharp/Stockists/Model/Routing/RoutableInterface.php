<?php
namespace Limesharp\Stockists\Model\Routing;

interface RoutableInterface
{
    /**
     * @param $urlKey
     * @param $storeId
     * @return int|null
     */
    public function checkUrlKey($urlKey, $storeId);
}
