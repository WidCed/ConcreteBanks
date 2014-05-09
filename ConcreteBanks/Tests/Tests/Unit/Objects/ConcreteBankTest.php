<?php
namespace ConcreteBanks\Tests\Tests\Unit\Objects;
use ConcreteBanks\Infrastructure\Objects\ConcreteBank;
use DateTimes\Tests\Helpers\DateTimeHelper;
use Strings\Tests\Helpers\StringHelper;
use Primitives\Tests\Helpers\PrimitiveHelper;
use Entities\Domain\Entities\Exceptions\CannotCreateEntityException;

final class ConcreteBankTest extends \PHPUnit_Framework_TestCase {
    
    private $uuidMock;
    private $integerMock;
    private $stringMock;
    private $dateTimeMock;
    private $booleanAdapterMock;
    private $createdOnTimestampElement;
    private $lastUpdatedOnTimestampElement;
    private $nameElement;
    private $emptyNameElement;
    private $dateTimeHelper;
    private $stringHelper;
    private $integerHelper;
    public function setUp() {
        
        $this->uuidMock = $this->getMock('Uuids\Domain\Uuids\Uuid');
        $this->integerMock = $this->getMock('Integers\Domain\Integers\Integer');
        $this->stringMock = $this->getMock('Strings\Domain\Strings\String');
        $this->dateTimeMock = $this->getMock('DateTimes\Domain\DateTimes\DateTime');
        $this->booleanAdapterMock = $this->getMock('Booleans\Domain\Booleans\Adapters\BooleanAdapter');
        
        $this->createdOnTimestampElement = time() - (24 * 60 * 60);
        $this->lastUpdatedOnTimestampElement = time();
        $this->nameElement = 'This is a name';
        $this->emptyNameElement = '';
        
        $this->dateTimeHelper = new DateTimeHelper($this, $this->dateTimeMock);
        $this->stringHelper = new StringHelper($this, $this->stringMock);
        $this->integerHelper = new PrimitiveHelper($this, $this->integerMock);
        
    }
    
    public function tearDown() {
        
    }
    
    public function testCreate_Success() {
        
        $this->stringHelper->expectsGet_multiple_Success(array($this->nameElement));
        
        $bank = new ConcreteBank($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock);
        
        $this->assertEquals($this->uuidMock, $bank->getUuid());
        $this->assertEquals($this->stringMock, $bank->getName());
        $this->assertEquals($this->dateTimeMock, $bank->createdOn());
        $this->assertNull($bank->lastUpdatedOn());
        
        $this->assertTrue($bank instanceof \Banks\Domain\Banks\Bank);
        $this->assertTrue($bank instanceof \ConcreteEntities\Infrastructure\Objects\AbstractEntity);
        
    }
    
    public function testCreate_withEmptyNameElement_Success() {
        
        $this->stringHelper->expectsGet_Success($this->emptyNameElement);
        
        $asserted = false;
        try {
        
            new ConcreteBank($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock);
            
        } catch (CannotCreateEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testCreate_withLastUpdatedOn_Success() {
        
        $this->dateTimeHelper->expectsGetTimestamp_multiple_Success(array($this->integerMock, $this->integerMock));
        $this->integerHelper->expectsGet_multiple_Success(array($this->createdOnTimestampElement, $this->lastUpdatedOnTimestampElement));
        $this->stringHelper->expectsGet_multiple_Success(array($this->nameElement));
        
        $bank = new ConcreteBank($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock);
        
        $this->assertEquals($this->uuidMock, $bank->getUuid());
        $this->assertEquals($this->stringMock, $bank->getName());
        $this->assertEquals($this->dateTimeMock, $bank->createdOn());
        $this->assertEquals($this->dateTimeMock, $bank->lastUpdatedOn());
        
    }
}