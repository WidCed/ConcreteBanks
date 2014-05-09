<?php
namespace ConcreteBanks\Infrastructure\Builders;
use ConcreteEntities\Infrastructure\Builders\AbstractEntityBuilder;
use Banks\Domain\Banks\Builders\BankBuilder;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use ObjectLoaders\Domain\ObjectLoaders\Adapters\ObjectLoaderAdapter;
use Strings\Domain\Strings\String;
use Entities\Domain\Entities\Builders\Exceptions\CannotBuildEntityException;

final class ConcreteBankBuilder extends AbstractEntityBuilder implements BankBuilder {
    
    private $name;
    public function __construct(BooleanAdapter $booleanAdapter, ObjectLoaderAdapter $objectLoaderAdapter) {
        parent::__construct($booleanAdapter, $objectLoaderAdapter, 'ConcreteBanks\Infrastructure\Objects\ConcreteBank');
    }
    
    public function create() {
        parent::create();
        $this->name = null;
        return $this;
    }
    
    public function withName(String $name) {
        $this->name = $name;
        return $this;
    }
    
    protected function getParamsData() {
        
        $paramsData = array($this->uuid, $this->name, $this->createdOn, $this->booleanAdapter);
        
        if (!empty($this->lastUpdatedOn)) {
            $paramsData[] = $this->lastUpdatedOn;
        }
        
        return $paramsData;
    }
    
    public function now() {
        
        if (empty($this->name)) {
            throw new CannotBuildEntityException('The name is mandatory in order to build a Bank object.');
        }
        
        return parent::now();
        
    }
}
