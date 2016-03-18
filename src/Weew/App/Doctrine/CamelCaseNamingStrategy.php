<?php

namespace Weew\App\Doctrine;

use Doctrine\ORM\Mapping\DefaultNamingStrategy;

class CamelCaseNamingStrategy extends DefaultNamingStrategy {
    /**
     * {@inheritdoc}
     */
    public function embeddedFieldToColumnName($propertyName, $embeddedColumnName, $className = null, $embeddedClassName = null) {
        return $propertyName . ucfirst($embeddedColumnName);
    }

    /**
     * {@inheritdoc}
     */
    public function referenceColumnName() {
        return 'id';
    }

    /**
     * {@inheritdoc}
     */
    public function joinColumnName($propertyName, $className = null) {
        return $propertyName . ucfirst($this->referenceColumnName());
    }

    /**
     * {@inheritdoc}
     */
    public function joinTableName($sourceEntity, $targetEntity, $propertyName = null) {
        return strtolower($this->classToTableName($sourceEntity) . ucfirst($this->classToTableName($targetEntity)));
    }

    /**
     * {@inheritdoc}
     */
    public function joinKeyColumnName($entityName, $referencedColumnName = null) {
        return strtolower($this->classToTableName($entityName) . ucfirst(($referencedColumnName ?: $this->referenceColumnName())));
    }
}
