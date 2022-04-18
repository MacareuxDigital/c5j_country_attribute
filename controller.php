<?php
namespace Concrete\Package\C5jCountryAttribute;

use Concrete\Core\Attribute\Category\CategoryService;
use Concrete\Core\Attribute\TypeFactory;
use Concrete\Core\Package\Package;

class Controller extends Package
{
    protected $pkgHandle = 'c5j_country_attribute';
    protected $pkgVersion = '0.9';
    protected $appVersionRequired = '8.5.4';

    /**
     * @inheritDoc
     */
    public function getPackageName()
    {
        return t('Macareux Country Attribute');
    }

    /**
     * @inheritDoc
     */
    public function getPackageDescription()
    {
        return t('Add an attribute type to select country.');
    }

    /**
     * @inheritDoc
     */
    public function install()
    {
        $pkg = parent::install();
        /** @var TypeFactory $factory */
        $factory = $this->app->make(TypeFactory::class);
        $type = $factory->getByHandle('country');
        if (!is_object($type)) {
            $type = $factory->add('country', 'Country', $pkg);
            /** @var CategoryService $service */
            $service = $this->app->make(CategoryService::class);
            $category = $service->getByHandle('user');
            if ($category) {
                $category->getController()->associateAttributeKeyType($type);
            }
            $collectionCategory = $service->getByHandle('collection');
            if ($collectionCategory) {
                $collectionCategory->getController()->associateAttributeKeyType($type);
            }
            $fileCategory = $service->getByHandle('file');
            if ($fileCategory) {
                $fileCategory->getController()->associateAttributeKeyType($type);
            }
            $eventCategory = $service->getByHandle('event');
            if ($eventCategory) {
                $eventCategory->getController()->associateAttributeKeyType($type);
            }
            $expressCategory = $service->getByHandle('express');
            if ($expressCategory) {
                $expressCategory->getController()->associateAttributeKeyType($type);
            }
        }

        return $pkg;
    }
}