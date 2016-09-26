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

class DateTime extends \Cawa\Bootstrap\Forms\Fields\DateTime
{
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
}
