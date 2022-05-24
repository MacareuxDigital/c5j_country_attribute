<?php

namespace Concrete\Package\C5jCountryAttribute;

use Concrete\Core\Attribute\Category\CategoryService;
use Concrete\Core\Attribute\TypeFactory;
use Concrete\Core\Package\Package;
use Concrete\Core\Package\PackageService;

class Controller extends Package
{
    protected $pkgHandle = 'c5j_country_attribute';

    protected $pkgVersion = '0.9.1';

    protected $appVersionRequired = '8.5.4';

    /**
     * {@inheritdoc}
     */
    public function getPackageName()
    {
        return t('Macareux Country Attribute');
    }

    /**
     * {@inheritdoc}
     */
    public function getPackageDescription()
    {
        return t('Add an attribute type to select country.');
    }

    /**
     * {@inheritdoc}
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

    /**
     * {@inheritdoc}
     */
    public function getPackageAutoloaderRegistries()
    {
        $registries = parent::getPackageAutoloaderRegistries();
        if ($this->isMigrationToolInstalled()) {
            $registries['src/MigrationTool'] = '\C5j\C5jCountryAttribute\MigrationTool';
        }

        return $registries;
    }

    public function on_after_packages_start()
    {
        if ($this->isMigrationToolInstalled()) {
            $key_manager = $this->app->make('migration/manager/import/attribute/key');
            $key_manager->extend('country', function () {
                return new \C5j\C5jCountryAttribute\MigrationTool\Importer\CIF\Attribute\Key\CountryImporter();
            });

            $value_manager = $this->app->make('migration/manager/import/attribute/value');
            $value_manager->extend('country', function () {
                return new \PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value\StandardImporter();
            });
        }
    }

    private function isMigrationToolInstalled(): bool
    {
        /** @var PackageService $packageService */
        $packageService = $this->app->make(PackageService::class);
        $migrationToolPackage = $packageService->getByHandle('migration_tool');
        if ($migrationToolPackage && $migrationToolPackage->isPackageInstalled()) {
            return true;
        }

        return false;
    }
}
