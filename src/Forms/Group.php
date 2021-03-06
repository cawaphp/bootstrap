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

use Cawa\Bootstrap\Forms\Fields\FieldTrait;
use Cawa\Html\Forms\Fields\Hidden;

class Group extends \Cawa\Html\Forms\Group
{
    use FieldTrait {
        FieldTrait::applyContainerSize as protected applyContainerSizeTrait;
        FieldTrait::setFieldSize as private setSizeTrait;
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(string $label = null)
    {
        parent::__construct($label);
        $this->addClass('form-group cawa-fields-group');
        $this->container->addClass('row');
    }

    /**
     * @return bool
     */
    public function isMultiline() : bool
    {
        return $this->container->hasClass('group-multiline');
    }

    /**
     * @param bool $multiline
     *
     * @return $this|self
     */
    public function setMultiline(bool $multiline = true) : self
    {
        if ($multiline) {
            $this->container->addClass('group-multiline');
        } else {
            $this->container->removeClass('group-multiline');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setFieldSize(string $size) : self
    {
        $this->setSizeTrait($size);

        foreach ($this->container->elements as $element) {
            if (method_exists($element, 'setFieldSize')) {
                $element->setFieldSize($this->fieldSize);
            }
        }

        return $this;
    }

    /**
     * @var string
     */
    private $colClass = 'md';

    /**
     * @return string
     */
    public function getColClass() : string
    {
        return $this->colClass;
    }

    /**
     * @param string $colClass
     *
     * @return Group
     */
    public function setColClass(string $colClass = null) : Group
    {
        $this->colClass = $colClass;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function applyContainerSize(array $elements)
    {
        if (!$this->isMultiline() && $this->colClass) {
            $count = 0;
            foreach ($elements as $element) {
                if (!$element instanceof Hidden) {
                    $count++;
                }
            }

            if ($count > 1) {
                foreach ($elements as $element) {
                    $element->addClass('col-' . $this->colClass . '-' . floor(12 / $count))
                        ->removeClass('form-group');
                }
            }
        }

        $this->applyContainerSizeTrait($elements);
    }
}
