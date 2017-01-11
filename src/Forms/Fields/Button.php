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

namespace Cawa\Bootstrap\Forms\Fields;

class Button extends \Cawa\Html\Forms\Fields\Button
{
    use FieldTrait {
        FieldTrait::layout as private fieldTraitLayout;
    }

    const TYPE_DEFAULT = 'btn-default';
    const TYPE_PRIMARY = 'btn-primary';
    const TYPE_SUCCESS = 'btn-success';
    const TYPE_INFO = 'btn-info';
    const TYPE_WARNING = 'btn-warning';
    const TYPE_DANGER = 'btn-danger';

    /**
     * {@inheritdoc}
     */
    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->getField()->addClass(['btn', 'btn-primary']);
        $this->addClass('form-group');
    }

    /**
     * @param string $type
     *
     * @return $this|self
     */
    public function setDisplayType(string $type) : self
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getConstants() as $key => $value) {
            if (strpos($key, 'TYPE_') !== false) {
                $this->getField()->removeClass($value);
            }
        }

        $this->getField()->addClass($type);

        return $this;
    }
}
