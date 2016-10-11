<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Cawa\Bootstrap\Forms\ExtendedFields;

use Cawa\Bootstrap\Forms\Fields\Select;
use Cawa\Bootstrap\Forms\Fields\Text;
use Cawa\Bootstrap\Forms\Group;
use Cawa\GoogleMaps\Models\AddressComponent;
use Cawa\GoogleMaps\Models\GeocoderResult;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Html\Forms\Fields\Hidden;
use Cawa\Intl\TranslatorFactory;
use Punic\Misc;
use Punic\Territory;

class GooglePlacePrefill extends GooglePlace
{
    use TranslatorFactory;

    /**
     * @var AbstractField[]
     */
    private $fields = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null)
    {
        parent::__construct($name, $label);

        self::translator()->addFile(__DIR__ . '/../../../lang/global', 'bootstrap');

        $this
            ->add((new Group(self::trans('bootstrap.googlePlace/street')))
                ->add($this->fields['number'] = (new Text($name . '[number]'))
                    ->setPlaceholder(self::trans('bootstrap.googlePlace/number')))
                ->add($this->fields['street'] = (new Text($name . '[street]'))
                    ->setPlaceholder(self::trans('bootstrap.googlePlace/street'))))
            ->add((new Group(Misc::joinUnits([
                    self::trans('bootstrap.googlePlace/zipcode'),
                    self::trans('bootstrap.googlePlace/city')
                ])))
                ->add($this->fields['zipcode'] = (new Text($name . '[zipcode]'))
                    ->setPlaceholder(self::trans('bootstrap.googlePlace/zipcode')))
                ->add($this->fields['city'] = (new Text($name . '[city]'))
                    ->setPlaceholder(self::trans('bootstrap.googlePlace/city'))))
            ->add($this->fields['state'] = new Text(
                $name . '[state]',
                self::trans('bootstrap.googlePlace/state')
            ))
            ->add($this->fields['country'] = new Select(
                $name . '[country]',
                self::trans('bootstrap.googlePlace/country'),
                Territory::getCountries()
            ))
            ->add($this->fields['lat'] = (new Hidden($name . '[lat]')))
            ->add($this->fields['long'] = (new Hidden($name . '[long]')))
        ;
    }

    /**
     * @param GeocoderResult|null $geocode
     *
     * @return $this|self|parent
     */
    public function setValue(GeocoderResult $geocode = null) : parent
    {
        parent::setValue($geocode);

        if ($geocode) {
            $this->fields['lat']->setValue((string) $geocode->getGeometry()->getLocation()->getLatitude());
            $this->fields['long']->setValue((string) $geocode->getGeometry()->getLocation()->getLongitude());
            $this->fields['number']->setValue(
                $geocode->getAddressComponent(AddressComponent::TYPE_STREET_NUMBER)->getLongName()
            );
            $this->fields['street']->setValue(
                $geocode->getAddressComponent(AddressComponent::TYPE_ROUTE)->getLongName()
            );
            $this->fields['zipcode']->setValue(
                $geocode->getAddressComponent(AddressComponent::TYPE_POSTAL_CODE)->getLongName()
            );
            $this->fields['city']->setValue(
                $geocode->getAddressComponent(AddressComponent::TYPE_LOCALITY)->getLongName()
            );
            $this->fields['state']->setValue(
                $geocode->getAddressComponent(AddressComponent::TYPE_ADMINISTRATIVE_AREA_LEVEL_1)->getLongName()
            );
            $this->fields['country']->setValue(
                $geocode->getAddressComponent(AddressComponent::TYPE_COUNTRY)->getShortName()
            );
        }

        return $this;
    }
}
