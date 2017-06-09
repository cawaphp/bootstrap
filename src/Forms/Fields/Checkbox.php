<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Cawa\Bootstrap\Forms\Fields;

use Cawa\Renderer\Container;

class Checkbox extends \Cawa\Html\Forms\Fields\Checkbox
{
    use FieldTrait {
        FieldTrait::layout as private fieldTraitLayout;
    }
    use CheckableTrait {
        CheckableTrait::layout as private checkableTraitLayout;
    }

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
    protected function layout() : Container
    {
        if (!$this->getGridSize()) {
            return $this->fieldTraitLayout();
        } else {
            return $this->checkableTraitLayout();
        }
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

        return parent::render();
    }
}
