<?php

namespace Concrete\Package\C5jCountryAttribute\Attribute\Country;

use Concrete\Core\Attribute\DefaultController;
use Concrete\Core\Attribute\FontAwesomeIconFormatter;
use Concrete\Core\Attribute\SimpleTextExportableAttributeInterface;
use Concrete\Core\Error\ErrorList\ErrorList;
use Concrete\Core\Form\Service\Form;
use Punic\Territory;

class Controller extends DefaultController implements SimpleTextExportableAttributeInterface
{
    public $helpers = ['form'];

    public function form()
    {
        $value = null;
        if (is_object($this->attributeValue)) {
            $value = $this->app->make('helper/text')->entities($this->getAttributeValue()->getValue());
        }
        $this->set('value', $value);
    }

    public function search()
    {
        /** @var Form $form */
        $form = $this->app->make('helper/form');

        echo $form->selectCountry($this->field('value'), '', ['noCountryText' => t('Select Country')]);
    }

    public function getIconFormatter()
    {
        return new FontAwesomeIconFormatter('globe');
    }

    public function getDisplayValue()
    {
        return Territory::getName($this->attributeValue->getValue());
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Attribute\SimpleTextExportableAttributeInterface::getAttributeValueTextRepresentation()
     */
    public function getAttributeValueTextRepresentation()
    {
        $value = $this->getAttributeValueObject();
        if ($value === null) {
            $result = '';
        } else {
            $result = (string) $value->getValue();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Attribute\SimpleTextExportableAttributeInterface::updateAttributeValueFromTextRepresentation()
     */
    public function updateAttributeValueFromTextRepresentation($textRepresentation, ErrorList $warnings)
    {
        $textRepresentation = trim($textRepresentation);
        $value = $this->getAttributeValueObject();
        if ($value === null) {
            if ($textRepresentation !== '') {
                $value = new \Concrete\Core\Entity\Attribute\Value\Value\TextValue();
            }
        }
        if ($value !== null) {
            $value->setValue($textRepresentation);
        }

        return $value;
    }
}
