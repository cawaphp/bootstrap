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
use Cawa\Bootstrap\Forms\Fieldset;
use Cawa\Bootstrap\Forms\Form;
use Cawa\Bootstrap\Forms\Group;
use Cawa\Bootstrap\Forms\LabelIcon;
use Cawa\Bootstrap\Forms\MultipleGroup;
use Cawa\Controller\ViewController;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Renderer\Container;
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

        return $this;
    }

    /**
     * @param Container $container
     *
     * @return Container|HtmlContainer|ViewController
     */
    protected function getFieldContainer(Container $container) : ViewController
    {
        foreach ($container->getElements() as $element) {
            if ($element === $this->getField()) {
                return $container;
            }

            if ($element instanceof HtmlContainer) {
                foreach ($element->getElements() as $sub) {
                    if ($sub === $this->getField()) {
                        return $element;
                    }
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function layout() : Container
    {
        if ($this instanceof Group || $this instanceof Fieldset) {
            $this->applyContainerSize($this->container->elements);
        } else {
            $this->applySize($this);
        }

        if ($this->getGridSize()) {
            $container = new Container();

            // label
            if ($this->getLabel()) {
                $this->getLabel()->addClass('col-sm-' . $this->getGridSize())
                    ->addClass('control-label');
                $container->add($this->getLabel());
            }

            // field
            if ($this instanceof  Group) {
                $fieldWrapper = $this->getContainer();
            } else {
                $fieldWrapper = new HtmlContainer('<div>');
                $fieldWrapper->add($this->getField());
            }

            if ($this instanceof MultipleGroup) {
                $fieldWrapper->getElement()->addClass('col-sm-' . (12 - $this->getGridSize()));
            } else {
                $fieldWrapper->addClass('col-sm-' . (12 - $this->getGridSize()));
            }

            // label
            if (!$this->getLabel()) {
                $fieldWrapper->addClass('col-sm-offset-' . $this->getGridSize());
            }

            // help wrap
            if ($this->helpText) {
                $fieldWrapper->add($this->helpText);
            }

            $container->add($fieldWrapper);

            return $container;
        } else {
            $container = parent::layout();
            if ($this->helpText) {
                $container->add($this->helpText);
            }

            return $container;
        }
    }
}
