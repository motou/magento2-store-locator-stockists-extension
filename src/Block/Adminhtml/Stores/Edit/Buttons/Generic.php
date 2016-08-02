<?php
/**
 * Limesharp_Stockists extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category  Limesharp
 * @package   Limesharp_Stockists
 * @copyright 2016 Claudiu Creanga
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @author    Claudiu Creanga
 */
namespace Limesharp\Stockists\Block\Adminhtml\Stores\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
use Limesharp\Stockists\Api\StockistRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Generic
{
    /**
     * @var Context
     */
    public $context;

    /**
     * @var StockistRepositoryInterface
     */
    public $stockistRepository;

    /**
     * @param Context $context
     * @param StockistRepositoryInterface $stockistRepository
     */
    public function __construct(
        Context $context,
        StockistRepositoryInterface $stockistRepository
    ) {
        $this->context = $context;
        $this->stockistRepository = $stockistRepository;
    }

    /**
     * Return Stockist page ID
     *
     * @return int|null
     */
    public function getStockistId()
    {
        try {
            return $this->stockistRepository->getById(
                $this->context->getRequest()->getParam('stockist_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
