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

use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Renderer\Container;
use Cawa\Renderer\HtmlContainer;

/**
 * @mixin AbstractField
 */
trait CheckableTrait
{
    /**
     * {@inheritdoc}
     */
    protected function layout() : Container
    {
        $parent = parent::layout()->first();

        $wrapper = (new HtmlContainer('<div>'))
            ->addClass('form-group')
            ->add($container = (new HtmlContainer('<div>'))
                ->addClass('col-sm-' . (12-$this->getGridSize()) . ' col-sm-offset-' . $this->getGridSize())
                ->add($parent));

        if ($this->getHelpText()) {
            $container->add($this->getHelpText());
        }

        return (new Container())->add($wrapper);
    }
}
