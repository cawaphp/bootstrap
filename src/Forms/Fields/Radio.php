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

namespace Cawa\Bootstrap\Forms\Fields;

class Radio extends \Cawa\Html\Forms\Fields\Radio
{
    use FieldTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label, string $submitValue = null)
    {
        parent::__construct($name, $label, $submitValue);
        $this->addClass('radio');
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if ($this->getInline()) {
            $this->getLabel()->addClass('radio-inline')
                ->removeClass('radio');
        }

        $return = $this->renderWrap();

        if ($this->getInline()) {
            $this->getLabel()->removeClass('radio-inline')
                ->addClass('radio');
        }

        return $return;
    }

    protected function wrap()
    {
        $this->addClass('col-sm-offset-' . $this->getGridSize());
        $render = parent::render();

        return $render;
    }
}
