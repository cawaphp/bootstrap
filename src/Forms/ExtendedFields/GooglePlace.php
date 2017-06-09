<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Cawa\Bootstrap\Forms\ExtendedFields;

use Cawa\Bootstrap\Forms\Fields\Text;
use Cawa\Bootstrap\Forms\Fieldset;
use Cawa\Core\DI;
use Cawa\GoogleMaps\Models\GeocoderResult;
use Cawa\Html\Forms\Fields\Hidden;
use Cawa\Renderer\HtmlContainer;

class GooglePlace extends Fieldset
{
    /**
     * nstructs the Place Autocomplete service to return only geocoding results, rather than business results.
     * Generally, you use this request to disambiguate results where the location specified may be indeterminate.
     */
    const TYPE_GEOCODE = 'geocode';

    /**
     * instructs the Place Autocomplete service to return only geocoding results with a precise address.
     * Generally, you use this request when you know the user will be looking for a fully specified address.
     */
    const TYPE_ADDRESS = 'address';

    /**
     * instructs the Place Autocomplete service to return only business results.
     */
    const TYPE_ESTABLISHMENT = 'establishment';

    /**
     * instructs the Places service to return any result matching the following types:
     * - locality
     * - sublocality
     * - postal_code
     * - country
     * - administrative_area_level_1
     * - administrative_area_level_2.
     */
    const TYPE_REGIONS = 'regions';

    /**
     * instructs the Places service to return results that match locality or administrative_area_level_3.
     */
    const TYPE_CITIES = 'cities';

    /**
     * @param string $name
     * @param string|null $label
     */
    public function __construct(string $name, string $label = null)
    {
        parent::__construct();

        $this->main = (new Text($name . '[text]', $label));
        $this->hidden = (new Hidden($name . '[data]'));

        $this->add($this->main)
            ->add($this->hidden)
        ;

        $this->main->getField()->addClass('cawa-fields-googleplace')
            ->addAttribute('data-key', DI::config()->get('googleMaps/apikey'))
        ;
    }

    /**
     * @return HtmlContainer
     */
    public function getField() : HtmlContainer
    {
        return $this->main->getField();
    }

    /**
     * @param string|null $name
     *
     * @return $this|self
     */
    public function setPlaceholder(string $name = null) : self
    {
        $this->main->setPlaceholder($name);

        return $this;
    }

    /**
     * @param bool $required
     *
     * @return $this|self
     */
    public function setRequired(bool $required = true)
    {
        $this->main->setRequired($required);

        return $this;
    }

    /**
     * @param GeocoderResult|null $geocode
     *
     * @return $this|self
     */
    public function setValue(GeocoderResult $geocode = null) : self
    {
        if ($geocode) {
            $this->main->setValue($geocode->getFormattedAddress());
            $this->hidden->setValue(json_encode($geocode));
        }

        return $this;
    }

    /**
     * @var Text
     */
    private $main;

    /**
     * @var Hidden
     */
    private $hidden;

    /**
     * @param bool $geolocate
     *
     * @return $this|self
     */
    public function setGeolocate(bool $geolocate) : self
    {
        $this->main->getField()->addAttribute('data-geolocate', $geolocate ? 'true' : 'false');

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this|self
     */
    public function setType(string $type) : self
    {
        $this->main->getField()->addAttribute('data-type', $type);

        return $this;
    }

    /**
     * @param string[] $types
     *
     * @return $this|self
     */
    public function setTypes(array $types) : self
    {
        $this->main->getField()->addAttribute('data-types', json_encode($types));

        return $this;
    }

    /**
     * @param string $country
     *
     * @return $this|self
     */
    public function setCountry(string $country) : self
    {
        $this->main->getField()->addAttribute('data-country', $country);

        return $this;
    }

    /**
     * @param bool $strict
     *
     * @return $this|self
     */
    public function setStrictBounds(bool $strict = true) : self
    {
        $this->main->getField()->addAttribute('data-strict-bounds', $strict ? 'true' : 'false');

        return $this;
    }
}
