<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Helper\Test\Unit\Helper;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Training\Seller\Helper\Url as HelperUrl;

/**
 * Url Helper test
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class UrlTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->objectManager   = new ObjectManager($this);
    }

    /**
     * Test the getSellersUrl method
     */
    public function testSellerUrlsSuccess()
    {
        $helper = $this->getUrlHelper();

        $resultUrl = $helper->getSellersUrl();

        $this->assertEquals('/sellers.html', $resultUrl);
    }

    /**
     * Test the getSellerUrl method
     */
    public function testSellerUrlSuccess()
    {
        $helper = $this->getUrlHelper();

        $resultUrl = $helper->getSellerUrl('test');

        $this->assertEquals('/seller/test.html', $resultUrl);
    }


    /**
     * Get the helper to test
     *
     * @param string $askedUrl
     *
     * @return HelperUrl
     */
    protected function getUrlHelper()
    {
        $urlBuilder = $this
            ->getMockBuilder(\Magento\Framework\Url::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDirectUrl'])
            ->getMock();
        
        $urlBuilder
            ->expects($this->once())
            ->method('getDirectUrl')
            ->will($this->returnCallback([$this, 'mockGetDirectUrl']));
        
        $context = $this
            ->getMockBuilder(\Magento\Framework\App\Helper\Context::class)
            ->disableOriginalConstructor()
            ->setMethods(['getUrlBuilder'])
            ->getMock();

        $context
            ->expects($this->any())
            ->method('getUrlBuilder')
            ->will($this->returnValue($urlBuilder));
        
        /** @var HelperUrl $helper */
        $helper = $this->objectManager->getObject(
            HelperUrl::class,
            [
                'context' => $context,
            ]
        );

        return $helper;
    }

    /**
     * Build url by direct url and parameters
     *
     * @param string $url
     * @param array $params
     *
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function mockGetDirectUrl($url, $params = [])
    {
        return '/'.$url;
    }
}
