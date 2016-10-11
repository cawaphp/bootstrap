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

/**
 * @mixin Date|DateTime
 */
trait DateTrait
{
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

        $this->getField()->addAttribute('data-linked-min', '#' . $field->getId());

        return $this;
    }

    /**
     * @param array $weekdays
     *
     * @return $this|self
     */
    public function setDisabledWeekDay(array $weekdays = []) : self
    {
        if (sizeof($weekdays) == 0) {
            $this->getField()->removeAttribute('data-disabled-weekdays');
        } else {
            $this->getField()->addAttribute('data-disabled-weekdays', json_encode($weekdays));
        }

        return $this;
    }

    /**
     * @param string $selector
     *
     * @return $this|self
     */
    public function setMinimunDate(string $selector) : self
    {
        $this->getField()->addAttribute('data-min-selector', $selector);

        return $this;
    }

    /**
     * @param int $minute
     *
     * @return $this|self
     */
    public function setMinuteStep(int $minute) : self
    {
        $this->getField()->addAttribute('data-minute-step', (string) $minute);

        return $this;
    }
}
