<?php
namespace ConcreteBanks\Infrastructure\Objects;
use ConcreteEntities\Infrastructure\Objects\AbstractEntity;
use Banks\Domain\Banks\Bank;
use Uuids\Domain\Uuids\Uuid;
use Strings\Domain\Strings\String;
use DateTimes\Domain\DateTimes\DateTime;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use Entities\Domain\Entities\Exceptions\CannotCreateEntityException;
use ConcreteClassAnnotationObjects\Infrastructure\Objects\ConcreteContainer;
use ConcreteMethodAnnotationObjects\Infrastructure\Objects\ConcreteKeyname;
use ConcreteMethodAnnotationObjects\Infrastructure\Objects\ConcreteTransform;

/**
 * @ConcreteContainer("bank") 
 */
final class ConcreteBank extends AbstractEntity implements Bank {
    
    private $name;
    public function __construct(Uuid $uuid, String $name, DateTime $createdOn, BooleanAdapter $booleanAdapter, DateTime $lastUpdatedOn = null) {
        
        if ($name->get() == '') {
            throw new CannotCreateEntityException('The name must be a non-empty String object.');
        }
        
        parent::__construct($uuid, $createdOn, $booleanAdapter, $lastUpdatedOn);
        $this->name = $name;
        
    }
    
    /**
     * @ConcreteKeyname(name="name", argument="name")
     * @ConcreteTransform(reference="irestful.concretestrings.adapter", method="convertElementToPrimitive")
     **/
    public function getName() {
        return $this->name;
    }
}