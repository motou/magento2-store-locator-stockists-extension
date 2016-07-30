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

namespace Limesharp\Stockists\Test\Unit\Controller\Index;

class IndexTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        // Create dependency mocks
        $page = $this->getMockBuilder('Magento\Framework\View\Result\Page')
            ->disableOriginalConstructor()
            ->getMock();
        $resultFactory = $this->getMockBuilder('Magento\Framework\View\Result\PageFactory')
            ->disableOriginalConstructor()
            ->getMock();

        // Set up SUT
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $model = $objectManager->getObject('Limesharp\Stockists\Controller\Index\Index',
            ['resultPageFactory' => $resultFactory]
        );

        // Expectations of test
        $resultFactory->expects($this->once())->method('create')->willReturn($page);
        $this->assertSame($page, $model->execute());
    }
}
