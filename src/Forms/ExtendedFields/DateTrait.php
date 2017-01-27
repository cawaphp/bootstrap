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

use Cawa\Renderer\Container;
use Cawa\Renderer\WidgetOption;

/**
 * @mixin Date|DateTime
 */
trait DateTrait
{
    /**
     * @var array
     */
    private $widgetOptions = [];

    /**
     * @param DateTime $field
     *
     * @return $this|self
     */
    public function setLinkedStartDate(DateTime $field) : self
    {
        if (!$field->getId()) {
            $field->generateId();
        }

        $this->widgetOptions['linkedMin'] = '#' . $field->getId();

        return $this;
    }

    /**
     * @param array $weekdays
     *
     * @return $this|self
     */
    public function setDisabledWeekDay(array $weekdays = []) : self
    {
        $this->widgetOptions = array_merge_recursive($this->widgetOptions, [
            'plugin' => [
                'disabledWeekdays' => $weekdays
            ]
        ]);

        return $this;
    }

    /**
     * @param int $minute
     *
     * @return $this|self
     */
    public function setMinuteStep(int $minute) : self
    {
        $this->widgetOptions = array_merge_recursive($this->widgetOptions, [
            'plugin' => [
                'step' => $minute
            ]
        ]);

        return $this;
    }

    /**
     * @param bool $înline
     *
     * @return $this|self
     */
    public function setInlineDisplay(bool $înline = true) : self
    {
        $this->widgetOptions = array_merge_recursive($this->widgetOptions, [
            'plugin' => [
                'inline' => $înline
            ]
        ]);

        if ($înline) {
            $this->getField()->addClass('hidden');
        } else {
            $this->getField()->removeClass('hidden');
        }

        return $this;
    }

    /**
     * @param array|\Cawa\Date\Date[] $dates
     *
     * @return DateTrait
     */
    public function setAllowDates(array $dates = []) : self
    {
        $this->widgetOptions = array_merge_recursive($this->widgetOptions, [
            'allowDates' => $dates
        ]);

        return $this;
    }

    /**
     * @param array|\Cawa\Date\Date[] $dates
     *
     * @return DateTrait
     */
    public function setHighlightedDates(array $dates = []) : self
    {
        $this->widgetOptions = array_merge_recursive($this->widgetOptions, [
            'highlightedDates' => $dates
        ]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function layout() : Container
    {
        $container = parent::layout();
        $instance = $this->getFieldContainer($container);
        $instance->add(new WidgetOption($this->widgetOptions));

        return $container;
    }
}
