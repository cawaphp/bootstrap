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

class Checkbox extends \Cawa\Html\Forms\Fields\Checkbox
{
    use TraitField;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label, string $submitValue = null)
    {
        parent::__construct($name, $label, $submitValue);
        $this->addClass('checkbox');
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if ($this->getInline()) {
            $this->getLabel()->addClass('checkbox-inline')
                ->removeClass('checkbox');
        }

        $return = $this->renderWrap();

        if ($this->getInline()) {
            $this->getLabel()->removeClass('checkbox-inline')
                ->addClass('checkbox');
        }

        return $return;
    }

    /**
     * @return string
     */
    protected function wrap()
    {
        $this->addClass('col-sm-offset-' . $this->getGridSize());
        $render = parent::render();

        return $render;
    }
}
