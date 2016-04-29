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
use Cawa\Html\Forms\Fields\Submit;

class Group extends \Cawa\Html\Forms\Group
{
    use FieldTrait;

    /**
     * @inheritdoc
     */
    public function __construct(string $label = null)
    {
        parent::__construct($label);
        $this->addClass('form-group');
        $this->container->addClass("row");
    }

    /**
     * @inheritdoc
     */
    protected function renderBootstrapProperties()
    {
        if ($this->size) {

            /** @var AbstractField $element */
            foreach ($this->container->elements as $element) {
                if ($element instanceof Hidden) {
                    continue;
                }

                if ($element instanceof Submit) {
                    $element->addClass($this->size == Form::SIZE_LARGE ? "btn-lg" : "btn-sm");
                } else {
                    if ($this->horizontal) {
                        $this->addClass($this->size == Form::SIZE_LARGE ? "form-group-lg" : "form-group-sm");
                    } else {
                        $element->getField()->addClass($this->size == Form::SIZE_LARGE ? "input-lg" : "input-sm");
                    }
                }
            }
        }

        if ($this->getGridSize()) {
            $render = $this->wrap();
        } else {
            $render = parent::render();
        }

        return $render;
    }

    /**
     * @inheritdoc
     */
    public function render()
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
                $element->addClass("col-sm-" . floor(12 / $count));
            }
        }

        return $this->renderBootstrapProperties();
    }
}
