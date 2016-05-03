<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types=1);

namespace Cawa\Bootstrap\Forms\ExtendedFields;

use Cawa\Bootstrap\Forms\Fields\Text;
use Cawa\Core\DI;
use Cawa\Html\Forms\Fields\Hidden;
use Cawa\Renderer\WidgetOption;

class GooglePlace extends Text
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null)
    {
        parent::__construct($name . '[text]', $label);
        $this->getField()->addClass('cawa-fields-googleplace');

        $this->widgetOption = new WidgetOption(['key' => DI::config()->get('googlemaps/apikey')]);

        $this
            ->add($this->widgetOption)
            ->add(Hidden::create($name . '[number]'))
            ->add(Hidden::create($name . '[street]'))
            ->add(Hidden::create($name . '[zipcode]'))
            ->add(Hidden::create($name . '[state]'))
            ->add(Hidden::create($name . '[country]'))
            ->add(Hidden::create($name . '[lat]'))
            ->add(Hidden::create($name . '[long]'))

        ;
    }

    /**
     * @var WidgetOption
     */
    private $widgetOption;

    /**
     * @param bool $geolocate
     *
     * @return $this
     */
    public function setGeolocate(bool $geolocate) : self
    {
        $this->widgetOption->addData('geolocate', $geolocate);

        return $this;
    }
}
