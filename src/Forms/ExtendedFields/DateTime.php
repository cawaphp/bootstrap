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

class DateTime extends \Cawa\Bootstrap\Forms\Fields\DateTime
{
    use DateTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null)
    {
        parent::__construct($name, $label);
        $this->getField()->addClass('cawa-fields-datetime');
        $this->addClass('cawa-fields-datetime-group');
    }

    /**
     * @param \Cawa\Date\DateTime $date
     *
     * @return $this|self
     */
    public function setMinimunDate(\Cawa\Date\DateTime $date) : self
    {
        $this->widgetOptions = array_merge_recursive($this->widgetOptions, [
            'minDate' => $date->format('Y-m-d\TH:i:s'),
        ]);

        return $this;
    }

    /**
     * @param int $step
     *
     * @return $this|self
     */
    public function setStep(int $step) : self
    {
        $this->widgetOptions = array_merge_recursive($this->widgetOptions, [
            'plugin' => [
                'step' => $step,
            ]
        ]);

        return $this;
    }
}
