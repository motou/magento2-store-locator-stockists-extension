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
 
namespace Limesharp\Stockists\Model;

class Template
{
	
    public function toOptionArray(): array
    {
        return array(
            array(
                'value' => 'full_width_sidebar',
                'label' => 'Full Width with Sidebar Options',
            ),
            array(
                'value' => 'full_width_top',
                'label' => 'Full Width with Top Options',
            ),
            array(
                'value' => 'page_width_sidebar',
                'label' => 'Page Width with Sidebar Options',
            ),
            array(
                'value' => 'page_width_top',
                'label' => 'Page Width with Top Options',
            )
        );
    }
    
}