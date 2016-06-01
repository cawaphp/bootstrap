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

use Cawa\Bootstrap\Forms\BootstrapPropertiesTrait;
use Cawa\Bootstrap\Forms\Form;
use Cawa\Bootstrap\Forms\LabelIcon;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;

/**
 * @mixin AbstractField
 */
trait FieldTrait
{
    use BootstrapPropertiesTrait;

    /**
     * {@inheritdoc}
     */
    public function setLabel($label) : parent
    {
        // IconGroup class in order to handle Label replace by icon, don't work with inline form
        if ($label instanceof LabelIcon) {
            $this->addClass('input-group');
        } else {
            $this->removeClass('input-group');
        }

        return parent::setLabel($label);
    }

    /**
     * @var HtmlElement
     */
    private $helpText;

    /**
     * @return HtmlElement|null
     */
    public function getHelpText()
    {
        return $this->helpText;
    }

    /**
     * @param HtmlElement|string $helpText
     *
     * @return $this
     */
    public function setHelpText($helpText) : self
    {
        $index = $this->getIndex($this->helpText);

        if (!$helpText instanceof HtmlElement) {
            $helpText = new HtmlElement('<span>', $helpText);
        }
        $helpText->addClass('help-block');

        // @see http://getbootstrap.com/css/#forms-help-text
        if ($this->getField()) {
            if (!$helpText->getId()) {
                $helpText->generateId();
            }

            $this->getField()->addAttribute('aria-describedby', $helpText->getId());
        }

        $this->helpText = $helpText;

        if (is_null($index)) {
            $this->add($helpText);
        } else {
            $this->elements[$index] = $helpText;
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function renderBootstrapProperties()
    {
        $this->applySize($this);

        if ($this->getGridSize()) {
            $render = $this->wrap();
        } else {
            $render = parent::render();
        }

        return $render;
    }

    /**
     * @return string
     */
    protected function wrap() : string
    {
        // field wrap
        $fieldWrapper = new HtmlContainer('<div>');
        $fieldWrapper->addClass('col-sm-' . (12 - $this->getGridSize()))
            ->add($this->getField());

        if (!$this->getLabel()) {
            $fieldWrapper->addClass('col-sm-offset-' . $this->getGridSize());
        }

        $this->setField($fieldWrapper);

        // label wrap
        if ($this->getLabel()) {
            $label = $this->getLabel();
            $labelWrapper = clone $label;

            $labelWrapper
                ->addClass('col-sm-' . $this->getGridSize())
                ->addClass('control-label')
            ;
            $this->setLabel($labelWrapper);
        }

        // help wrap
        if ($this->helpText) {
            $fieldWrapper->add($this->helpText);
            $index = $this->getIndex($this->helpText);
            unset($this->elements[$index]);
        }

        return parent::render();
    }
}
