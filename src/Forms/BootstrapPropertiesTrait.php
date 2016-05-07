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

use Cawa\Bootstrap\Forms\Fields\Submit;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Html\Forms\Fields\Hidden;

trait BootstrapPropertiesTrait
{
    /**
     * @var int
     */
    private $gridSize;

    /**
     * @return int
     */
    public function getGridSize()
    {
        return $this->gridSize;
    }

    /**
     * @param int $gridSize
     *
     * @return $this
     */
    public function setGridSize(int $gridSize) : self
    {
        $this->gridSize = $gridSize;

        return $this;
    }

    /**
     * @var bool
     */
    private $inline = false;

    /**
     * @return bool
     */
    public function getInline() : bool
    {
        return $this->inline;
    }

    /**
     * @param bool $inline
     *
     * @return $this
     */
    public function setInline(bool $inline) : self
    {
        $this->inline = $inline;

        return $this;
    }

    /**
     * @var bool
     */
    private $horizontal = false;

    /**
     * @return bool
     */
    public function getHorizontal() : bool
    {
        return $this->horizontal;
    }

    /**
     * @param bool $horizontal
     *
     * @return $this
     */
    public function setHorizontal(bool $horizontal) : self
    {
        $this->horizontal = $horizontal;

        return $this;
    }

    /**
     * @var string
     */
    private $size;

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     *
     * @return $this
     */
    public function setSize(string $size) : self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @param AbstractField[] $elements
     */
    protected function applyContainerSize(array $elements)
    {
        if ($this->size) {
            /** @var AbstractField $element */
            foreach ($elements as $element) {
                if ($element instanceof Hidden) {
                    continue;
                }

                $this->applySize($element);
            }
        }
    }

    /**
     * @param AbstractField|BootstrapPropertiesTrait $element
     */
    protected function applySize($element)
    {
        if (!$element->getSize()) {
            return;
        }

        if ($this instanceof Submit) {
            $this->getField()->addClass($element->getSize() == Form::SIZE_LARGE ? 'btn-lg' : 'btn-sm');
        } else {
            if ($this->horizontal) {
                $this->addClass($element->getSize() == Form::SIZE_LARGE ? 'form-group-lg' : 'form-group-sm');
            } else {
                $this->getField()->addClass($element->getSize() == Form::SIZE_LARGE ? 'input-lg' : 'input-sm');
            }
        }
    }
}
