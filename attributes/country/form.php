<?php
defined('C5_EXECUTE') or die("Access Denied.");

/** @var \Concrete\Core\Form\Service\Form $form */
$value = $value ?? null;

echo $form->selectCountry($this->field('value'), $value);
