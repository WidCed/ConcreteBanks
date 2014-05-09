<?php
namespace ConcreteBanks\Tests\Tests\Unit\Builders;
use ConcreteBanks\Infrastructure\Builders\ConcreteBankBuilder;
use DateTimes\Tests\Helpers\DateTimeHelper;
use Strings\Tests\Helpers\StringHelper;
use Primitives\Tests\Helpers\PrimitiveHelper;
use ObjectLoaders\Tests\Helpers\ObjectLoaderAdapterHelper;
use ObjectLoaders\Tests\Helpers\ObjectLoaderHelper;
use Entities\Domain\Entities\Builders\Exceptions\CannotBuildEntityException;

final class ConcreteBankBuilderTest extends \PHPUnit_Framework_TestCase {
    
    private $bankMock;
    private $objectLoaderAdapterMock;
    private $objectLoaderMock;
    private $uuidMock;
    private $integerMock;
    private $stringMock;
    private $dateTimeMock;
    private $booleanAdapterMock;
    private $classNameElement;
    private $createdOnTimestampElement;
    private $lastUpdatedOnTimestampElement;
    private $bankElement;
    private $builder;
    private $objectLoaderAdapterHelper;
    private $objectLoaderHelper;
    private $dateTimeHelper;
    private $stringHelper;
    private $integerHelper;
    public function setUp() {
        
        $this->objectLoaderAdapterMock = $this->getMock('ObjectLoaders\Domain\ObjectLoaders\Adapters\ObjectLoaderAdapter');
        $this->objectLoaderMock = $this->getMock('ObjectLoaders\Domain\ObjectLoaders\ObjectLoader');
        $this->uuidMock = $this->getMock('Uuids\Domain\Uuids\Uuid');
        $this->integerMock = $this->getMock('Integers\Domain\Integers\Integer');
        $this->stringMock = $this->getMock('Strings\Domain\Strings\String');
        $this->dateTimeMock = $this->getMock('DateTimes\Domain\DateTimes\DateTime');
        $this->booleanAdapterMock = $this->getMock('Booleans\Domain\Booleans\Adapters\BooleanAdapter');
        $this->bankMock = $this->getMock('Banks\Domain\Banks\Bank');
        
        $this->classNameElement = 'ConcreteBanks\Infrastructure\Objects\ConcreteBank';
        $this->createdOnTimestampElement = time() - (24 * 60 * 60);
        $this->lastUpdatedOnTimestampElement = time();
        $this->nameElement = 'This is a name';
        
        $this->builder = new ConcreteBankBuilder($this->booleanAdapterMock, $this->objectLoaderAdapterMock);
        
        $this->objectLoaderAdapterHelper = new ObjectLoaderAdapterHelper($this, $this->objectLoaderAdapterMock);
        $this->objectLoaderHelper = new ObjectLoaderHelper($this, $this->objectLoaderMock);
        $this->dateTimeHelper = new DateTimeHelper($this, $this->dateTimeMock);
        $this->stringHelper = new StringHelper($this, $this->stringMock);
        $this->integerHelper = new PrimitiveHelper($this, $this->integerMock);
        
    }
    
    public function tearDown() {
        
    }
    
    public function testBuild_Success() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_Success($this->bankMock, array($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock));
        $this->stringHelper->expectsGet_multiple_Success(array($this->nameElement));
        
        $bank = $this->builder->create()
                                ->withUuid($this->uuidMock)
                                ->withName($this->stringMock)
                                ->createdOn($this->dateTimeMock)
                                ->now();
        
        $this->assertEquals($this->bankMock, $bank);
        
    }
    
    public function testBuild_throwsCannotInstantiateObjectException_throwsCannotBuildEntityException() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_throwsCannotInstantiateObjectException(array($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock));
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withName($this->stringMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_throwsCannotConvertClassNameElementToObjectLoaderException_throwsCannotBuildEntityException() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_throwsCannotConvertClassNameElementToObjectLoaderException($this->classNameElement);
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withName($this->stringMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_withoutName_throwsCannotBuildEntityException() {
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_withLastUpdatedOn_Success() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_Success($this->bankMock, array($this->uuidMock, $this->stringMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock));
        $this->stringHelper->expectsGet_multiple_Success(array($this->nameElement));
        
        $bank = $this->builder->create()
                                ->withUuid($this->uuidMock)
                                ->withName($this->stringMock)
                                ->createdOn($this->dateTimeMock)
                                ->lastUpdatedOn($this->dateTimeMock)
                                ->now();
        
        $this->assertEquals($this->bankMock, $bank);
        
    }
    
}