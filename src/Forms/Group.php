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

namespace Cawa\Bootstrap\Forms;

use Cawa\Bootstrap\Forms\Fields\FieldTrait;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Html\Forms\Fields\Hidden;

class Group extends \Cawa\Html\Forms\Group
{
    use FieldTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $label = null)
    {
        parent::__construct($label);
        $this->addClass('form-group');
        $this->container->addClass('row');
    }

    /**
     * @return void
     */
    protected function applyContainerSize()
    {
        $count = 0;
        /** @var AbstractField $element */
        foreach ($this->container->elements as $element) {
            if (!$element instanceof Hidden) {
                $count ++;
            }
        }

        if ($count > 1) {
            foreach ($this->container->elements as $element) {
                $element->addClass('col-sm-' . floor(12 / $count));
            }
        }

        if ($this->size) {
            /** @var AbstractField $element */
            foreach ($this->container->elements as $element) {
                if ($element instanceof Hidden) {
                    continue;
                }

                $this->applySize($element);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function renderBootstrapProperties()
    {
        $this->applyContainerSize();

        if ($this->getGridSize()) {
            $render = $this->wrap();
        } else {
            $render = parent::render();
        }

        return $render;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->renderBootstrapProperties();
    }
}
