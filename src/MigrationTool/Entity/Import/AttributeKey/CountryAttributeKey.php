<?php

namespace C5j\C5jCountryAttribute\MigrationTool\Entity\Import\AttributeKey;

use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportCountryAttributeKeys")
 */
class CountryAttributeKey extends AttributeKey
{
    public function getType()
    {
        return 'country';
    }
}
