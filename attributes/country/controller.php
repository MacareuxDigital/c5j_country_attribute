<?php
namespace Concrete\Package\C5jCountryAttribute\Attribute\Country;

use Concrete\Core\Attribute\DefaultController;
use Concrete\Core\Attribute\FontAwesomeIconFormatter;
use Punic\Territory;

class Controller extends DefaultController
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

    public function getIconFormatter()
    {
        return new FontAwesomeIconFormatter('globe');
    }

    public function getDisplayValue()
    {
        return Territory::getName($this->attributeValue->getValue());
    }
}