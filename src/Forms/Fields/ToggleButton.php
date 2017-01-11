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

use Cawa\Html\Forms\Fields\Button;
use Cawa\Renderer\Container;

class ToggleButton extends Button
{
    use FieldTrait {
        FieldTrait::layout as private fieldTraitLayout;
    }

    const DISPLAYTYPE_DEFAULT = 'btn-default';
    const DISPLAYTYPE_PRIMARY = 'btn-primary';
    const DISPLAYTYPE_SUCCESS = 'btn-success';
    const DISPLAYTYPE_INFO = 'btn-info';
    const DISPLAYTYPE_WARNING = 'btn-warning';
    const DISPLAYTYPE_DANGER = 'btn-danger';

    /**
     * {@inheritdoc}
     */
    public function __construct(string $content, string $label = null)
    {
        parent::__construct($content, $label);
        $this->getField()->addClass(['btn', 'btn-primary']);
        $this->getField()->addAttributes([
            'data-toggle' => 'button',
            'aria-pressed' => 'false',
            'autocomplete' => 'off',
        ]);

        $this->addClass('form-group');
    }

    /**
     * @param string $type
     *
     * @return $this|ToggleButton
     */
    public function setDisplayType(string $type) : self
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getConstants() as $key => $value) {
            if (strpos($key, 'DISPLAYTYPE_') !== false) {
                $this->getField()->removeClass($value);
            }
        }

        $this->getField()->addClass($type);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function layout() : Container
    {
        return self::fieldTraitLayout();
    }
}
