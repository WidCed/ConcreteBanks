<?php
namespace ConcreteBanks\Tests\Tests\Functional;
use ConcreteFunctionalTestHelpers\Tests\Helpers\ConcreteDependencyInjectionFunctionalTestHelper;
use ConcreteBanks\Tests\Helpers\StaticBankHelper;

final class ConcreteBankTest extends \PHPUnit_Framework_TestCase {
    
    private $objectsData;
    public function setUp() {
        
        $dependencyInjectionFunctionTestHelper = new ConcreteDependencyInjectionFunctionalTestHelper(__DIR__.'/../../../../vendor');
        
        $jsonFilePathElement = realpath(__DIR__.'/../../../../dependencyinjection.json');
        $uuidJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteuuids/dependencyinjection.json');
        $stringJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretestrings/dependencyinjection.json');
        $dateTimeFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretedatetimes/dependencyinjection.json');
        $booleanFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretebooleans/dependencyinjection.json');
        
        StaticBankHelper::setUp(
            $dependencyInjectionFunctionTestHelper, 
            $jsonFilePathElement, 
            $uuidJsonFilePathElement, 
            $stringJsonFilePathElement, 
            $dateTimeFilePathElement, 
            $booleanFilePathElement
        );
        
        $this->objectsData = $dependencyInjectionFunctionTestHelper->getMultipleFileDependencyInjectionApplication()->execute($jsonFilePathElement);
        $this->objectsData['irestful.concreteobjectmetadatacompilerapplications.application']->compile();
    }
    
    public function tearDown() {
        
    }
    
    public function testConvertBank_toHashMap_toBank_Success() {
        
        $bank = StaticBankHelper::getObject();
        
        //convert the object into hashmap:
        $hashMap = $this->objectsData['irestful.concreteentities.adapter']->convertEntityToHashMap($bank);
        $this->assertTrue($hashMap instanceof \HashMaps\Domain\HashMaps\HashMap);
        
        //convert hashmap back to a Bank object:
        $convertedBank = $this->objectsData['irestful.concreteentities.adapter']->convertHashMapToEntity($hashMap);
        $this->assertEquals($bank, $convertedBank);
        
    }
    
}