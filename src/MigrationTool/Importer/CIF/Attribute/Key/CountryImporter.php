<?php

namespace C5j\C5jCountryAttribute\MigrationTool\Importer\CIF\Attribute\Key;

use C5j\C5jCountryAttribute\MigrationTool\Entity\Import\AttributeKey\CountryAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key\ImporterInterface;

defined('C5_EXECUTE') or die('Access Denied.');

class CountryImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new CountryAttributeKey();
    }

    /**
     * @param AttributeKey $key
     * @param \SimpleXMLElement $element
     */
    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        return false;
    }
}
