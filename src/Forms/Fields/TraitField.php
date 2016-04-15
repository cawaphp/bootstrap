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

use Cawa\App\Controller\Renderer\HtmlContainer;
use Cawa\App\Controller\Renderer\HtmlElement;
use Cawa\Bootstrap\Forms\LabelIcon;
use Cawa\Bootstrap\Forms\TraitBootstrapProperties;
use Cawa\Html\Forms\Fields\AbstractField;

/**
 * @mixin AbstractField
 */
trait TraitField
{
    use TraitBootstrapProperties;

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
        $index = null;
        foreach ($this->elements as $i => $element) {
            if ($element === $this->helpText) {
                $index = $i;
            }
        }

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
    protected function renderWrap()
    {
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
        $field = $this->getField();
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
            $helpText = $this->helpText;
            $helpWrapper = new HtmlContainer('<div>');
            $helpWrapper
                ->addClass(['col-sm-' . (12 - $this->getGridSize()), 'col-sm-offset-' . $this->getGridSize()])
                ->add($this->getHelpText())
            ;

            $this->setHelpText($helpWrapper);
        }

        /* @noinspection Php[...]Inspection */
        $render = parent::render();

        // restore default value

        $this->setField($field);

        if (isset($label)) {
            $this->setLabel($label);
        }

        if (isset($helpText)) {
            $this->setHelpText($helpText);
        }

        return $render;
    }
}
