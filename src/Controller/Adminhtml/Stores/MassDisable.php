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
namespace Limesharp\Stockists\Controller\Adminhtml\Stores;

use Limesharp\Stockists\Model\Stores;

class MassDisable extends MassAction
{
    /**
     * @var bool
     */
    public $status = false;

    /**
     * @param Stores $stockist
     * @return $this
     */
    public function massAction(Stores $stockist)
    {
        $stockist->setStatus($this->status);
        $this->stockistRepository->save($stockist);
        return $this;
    }
}
