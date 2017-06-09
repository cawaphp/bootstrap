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

namespace Cawa\Bootstrap\Forms;

use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Html\Forms\Group;
use DeepCopy\DeepCopy;

class Form extends \Cawa\Html\Forms\Form
{
    use BootstrapPropertiesTrait;

    /**
     * @see http://getbootstrap.com/css/#forms-example
     */
    const TYPE_BASIC = 'BASIC';

    /**
     * @see http://getbootstrap.com/css/#forms-horizontal
     */
    const TYPE_HORIZONTAL = 'HORIZONTAL';

    /**
     * @see http://getbootstrap.com/css/#forms-inline
     */
    const TYPE_INLINE = 'INLINE';

    /**
     * @see http://getbootstrap.com/css/#forms-control-sizes
     */
    const SIZE_SMALL = 'SMALL';
    const SIZE_LARGE = 'LARGE';

    /**
     * @var string
     */
    private $type = self::TYPE_BASIC;

    /**
     * @return bool
     */
    public function isBasic() : bool
    {
        return $this->type == self::TYPE_BASIC;
    }

    /**
     * @return $this|self
     */
    public function setBasic() : self
    {
        $this->type = self::TYPE_BASIC;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHorizontal() : bool
    {
        return $this->type == self::TYPE_HORIZONTAL;
    }

    /**
     * {@inheritdoc}
     */
    public function setHorizontal(int $size = 2) : self
    {
        $this->type = self::TYPE_HORIZONTAL;
        $this->setGridSize($size);

        return $this;
    }

    /**
     * @return bool
     */
    public function isInline() : bool
    {
        return $this->type == self::TYPE_INLINE;
    }

    /**
     * @return $this|self
     */
    public function setInline() : self
    {
        $this->type = self::TYPE_INLINE;

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        /* @var \Cawa\Bootstrap\Forms\Form $clone */
        $deepcopy = new DeepCopy();
        $clone = $deepcopy->copy($this);

        return $clone->renderClone();
    }

    /**
     * @return string
     */
    private function renderClone()
    {
        return parent::render();
    }

    /**
     * @return array
     */
    public function renderOuter() : array
    {
        /* @var \Cawa\Bootstrap\Forms\Form $clone */
        $deepcopy = new DeepCopy();
        $clone = $deepcopy->copy($this);

        return $clone->renderOuterClone();
    }

    /**
     * @return array
     */
    private function renderOuterClone() : array
    {
        return parent::renderOuter();
    }

    /**
     * {@inheritdoc}
     */
    public function export() : array
    {
        /* @var \Cawa\Bootstrap\Forms\Form $clone */
        $deepcopy = new DeepCopy();
        $clone = $deepcopy->copy($this);

        $clone->alterBeforeRender();

        return $clone->exportClone();
    }

    /**
     * @return array
     */
    private function exportClone() : array
    {
        return parent::export();
    }

    /**
     *
     */
    protected function alterBeforeRender()
    {
        parent::alterBeforeRender();

        // size
        if ($this->fieldSize) {
            foreach ($this->elements as $i => $element) {
                if (method_exists($element, 'setFieldSize')) {
                    $element->setFieldSize($this->fieldSize);
                }
            }
        }

        // transform child
        switch ($this->type) {
            case self::TYPE_INLINE:
                $this->addClass('form-inline');

                foreach ($this->elements as $i => $element) {
                    if (method_exists($element, 'setInline')) {
                        $element->setInline(true);
                    }
                }

                break;

            case self::TYPE_HORIZONTAL:
                $this->addClass('form-horizontal');

                foreach ($this->elements as $i => $element) {
                    if (method_exists($element, 'setGridSize')) {
                        $element->setGridSize($this->getGridSize());
                    }

                    if (method_exists($element, 'setHorizontal')) {
                        $element->setHorizontal(true);
                    }
                }
        }
    }

    /**
     * @param AbstractField|Group|Fieldset $element
     */
    private function addErrorClass($element)
    {
        if ($element instanceof Group || $element instanceof Fieldset) {
            foreach ($element->getFields() as $field) {
                if ($element instanceof Group || $element instanceof Fieldset) {
                    $this->addErrorClass($field);
                } elseif ($field->isRequired()) {
                    $field->addClass('has-error');
                }
            }
        } elseif ($element->isRequired()) {
            $element->addClass('has-error');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function populateValue($element) : bool
    {
        $return = parent::populateValue($element);

        if (!$return && $this->isSubmit()) {
            $this->addErrorClass($element);
        }

        return $return;
    }
}
