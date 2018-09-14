<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Training\Seller\Model\Seller as ModelSeller;

/**
 * Seller Model test
 */
class SellerTest extends TestCase
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
     * Get the seller model
     *
     * @return ModelSeller
     */
    protected function getSellerModel()
    {
        /** @var ModelSeller $model */
        $model = $this->objectManager->getObject(ModelSeller::class);

        return $model;
    }

    /**
     * Test the name methods
     */
    public function testName()
    {
        $value = 'test';
        
        $model = $this->getSellerModel();

        $model->setName($value);

        $this->assertEquals($value, $model->getName());
    }

    /**
     * Test the identifier methods
     */
    public function testIdentifier()
    {
        $value = 'test';
        
        $model = $this->getSellerModel();

        $model->setIdentifier($value);

        $this->assertEquals($value, $model->getIdentifier());
    }

    /**
     * Test the created_at methods
     */
    public function testCreatedAt()
    {
        $value = date('Y-m-d H:i:s');
        
        $model = $this->getSellerModel();

        $model->setCreatedAt($value);

        $this->assertEquals($value, $model->getCreatedAt());
    }

    /**
     * Test the updated_at methods
     */
    public function testUpdatedAt()
    {
        $value = date('Y-m-d H:i:s');

        $model = $this->getSellerModel();

        $model->setUpdatedAt($value);

        $this->assertEquals($value, $model->getUpdatedAt());
    }

    /**
     * Test the description methods
     */
    public function testDescription()
    {
        $value = 'test';

        $model = $this->getSellerModel();

        $this->assertNull($model->getDescription());

        $model->setDescription($value);

        $this->assertEquals($value, $model->getDescription());
    }

    /**
     * Test the seller_id methods
     */
    public function testSellerId()
    {
        $value = '1 ';

        $model = $this->getSellerModel();

        $model->setSellerId($value);

        $this->assertSame((int) $value, $model->getSellerId());
    }

    /**
     * Test the identity method
     */
    public function testIdentity()
    {
        $sellerId = 1;
        $identifier = 'test';

        $model = $this->getSellerModel();
        $model->setSellerId($sellerId);
        $model->setIdentifier($identifier);

        $expected = [$model::CACHE_TAG.'_'.$sellerId, $model::CACHE_TAG.'_'.$identifier];

        $this->assertEquals($expected, $model->getIdentities());
    }

    /**
     * Test the populate method
     *
     * @expectedException \PHPUnit\Framework\Error\Notice
     */
    public function testPopulateErrorIdentifier()
    {
        $values = [];

        $model = $this->getSellerModel();
        $model->populateFromArray($values);
    }

    /**
     * Test the populate method
     *
     * @expectedException \PHPUnit\Framework\Error\Notice
     */
    public function testPopulateErrorName()
    {
        $values = [
            'identifier' => 'test',
        ];

        $model = $this->getSellerModel();
        $model->populateFromArray($values);
    }

    /**
     * Test the populate method
     */
    public function testPopulateSuccess()
    {
        $model = $this->getSellerModel();

        $values = [
            'identifier'  => 'test_identifier',
            'name'        => 'test_name',
        ];

        $model->populateFromArray($values);

        $this->assertEquals($values['identifier'], $model->getIdentifier());
        $this->assertEquals($values['name'], $model->getName());
        $this->assertNull($model->getDescription());


        $values = [
            'identifier'  => 'test_identifier',
            'name'        => 'test_name',
            'description' => 'test_description',
        ];

        $model->populateFromArray($values);

        $this->assertEquals($values['identifier'], $model->getIdentifier());
        $this->assertEquals($values['name'], $model->getName());
        $this->assertEquals($values['description'], $model->getDescription());
    }
}
