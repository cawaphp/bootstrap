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
use Cawa\Html\Forms\Fields\Hidden;

class Group extends \Cawa\Html\Forms\Group
{
    use FieldTrait {
        FieldTrait::applyContainerSize as protected applyContainerSizeTrait;
        FieldTrait::setSize as private setSizeTrait;
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
     * @return Group
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
     * * {@inheritdoc}
     */
    public function setSize(string $size) : self
    {
        $this->setSizeTrait($size);

        foreach ($this->container->elements as $element) {
            if (method_exists($element, 'setSize')) {
                $element->setSize($this->size);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function applyContainerSize(array $elements)
    {
        if (!$this->isMultiline()) {
            $count = 0;
            foreach ($elements as $element) {
                if (!$element instanceof Hidden) {
                    $count++;
                }
            }

            if ($count > 1) {
                foreach ($elements as $element) {
                    $element->addClass('col-sm-' . floor(12 / $count))
                        ->removeClass('form-group');
                }
            }
        }

        $this->applyContainerSizeTrait($elements);
    }
}
