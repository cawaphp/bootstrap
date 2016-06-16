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

use Cawa\Renderer\HtmlElement;

class Fieldset extends \Cawa\Html\Forms\Fieldset
{
    use BootstrapPropertiesTrait {
        BootstrapPropertiesTrait::setSize as private setSizeTrait;
        BootstrapPropertiesTrait::setHorizontal as private setHorizontalTrait;
        BootstrapPropertiesTrait::setInline as private setInlineTrait;
        BootstrapPropertiesTrait::setGridSize as private setGridSizeTrait;
    }

    /**
     * @param int $gridSize
     *
     * @return $this
     */
    public function setGridSize(int $gridSize) : self
    {
        $this->setGridSizeTrait($gridSize);
        $this->applyToElements('setGridSize', func_get_args());

        return $this;
    }

    /**
     * @param bool $inline
     *
     * @return $this
     */
    public function setInline(bool $inline) : self
    {
        $this->setInlineTrait($inline);
        $this->applyToElements('setInline', func_get_args());

        return $this;
    }

    /**
     * @param bool $horizontal
     *
     * @return $this
     */
    public function setHorizontal(bool $horizontal) : self
    {
        $this->setHorizontalTrait($horizontal);
        $this->applyToElements('setHorizontal', func_get_args());

        return $this;
    }

    /**
     * * {@inheritdoc}
     */
    public function setSize(string $size) : self
    {
        $this->setSizeTrait($size);
        $this->applyToElements('setSize', func_get_args());

        return $this;
    }

    /**
     * @param string $method
     * @param array $args
     */
    private function applyToElements(string $method, $args)
    {
        foreach ($this->elements as $element) {
            if (method_exists($element, $method)) {
                call_user_func_array([$element, $method], $args);
            }
        }
    }

    public function render()
    {
        if ($this->getGridSize()) {
            /** @var HtmlElement $legend */
            $legend = $this->elements[0];

            if ($legend->getTag() == '<fieldset>') {
                $legend->addClass('col-sm-' . (12 - $this->getGridSize()) . ' col-sm-offset-' . $this->getGridSize());
            }
        }

        return parent::render();
    }
}
