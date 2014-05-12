<?php
namespace ConcreteBanks\Tests\Helpers;
use ConcreteFunctionalTestHelpers\Tests\Helpers\ConcreteDependencyInjectionFunctionalTestHelper;

final class StaticBankHelper {
    
    private static $objectsData;
    private static $uuidObjectsData;
    private static $stringObjectsData;
    private static $dateTimeObjectsData;
    private static $booleanObjectsData;
    private static $object = null;
    
    public static function isSetUp() {
        return !empty(self::$object);
    }
    
    public static function setUp(
        ConcreteDependencyInjectionFunctionalTestHelper $depdendencyInjectionFunctionalTestHelper,
        $jsonFilePathElement,
        $uuidJsonFilePathElement,
        $stringJsonFilePathElement,
        $dateTimeFilePathElement,
        $booleanFilePathElement
    ) {
        
        if (self::isSetUp()) {
            return;
        }
        
        self::$objectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($jsonFilePathElement);
        self::$uuidObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($uuidJsonFilePathElement);
        self::$stringObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($stringJsonFilePathElement);
        self::$dateTimeObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($dateTimeFilePathElement);
        self::$booleanObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($booleanFilePathElement);
        
        self::$object = self::build();
    }
    
    public static function getObject() {
        return self::$object;
    }
    
    public static function getObjectWithSubObjects() {
        return array(self::$object);
    }
    
    private static function build() {
        
        $uuidElement = 'ca3497a0-b00b-11e3-a5e2-0800200c9a66';
        $nameElement = 'This is a name';
        $createdOnTimestampElement = time() - (24 * 60 * 60);
        $lastUpdatedOnTimestampElement = time();
        
        $uuid = self::$uuidObjectsData['adapter']->convertElementToUuid($uuidElement);
        $name = self::$stringObjectsData['adapter']->convertElementToPrimitive($nameElement);
        $createdOn = self::$dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($createdOnTimestampElement);
        $lastUpdatedOn = self::$dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($lastUpdatedOnTimestampElement);
        
        return self::$objectsData['builderfactory']->create()
                                                    ->create()
                                                    ->withUuid($uuid)
                                                    ->withName($name)
                                                    ->createdOn($createdOn)
                                                    ->lastUpdatedOn($lastUpdatedOn)
                                                    ->now();
    }
    
}