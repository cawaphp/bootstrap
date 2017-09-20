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

use Cawa\Bootstrap\Components\Button;
use Cawa\Bootstrap\Components\Dropdown;
use Cawa\Bootstrap\Forms\BootstrapPropertiesTrait;
use Cawa\Bootstrap\Forms\Fieldset;
use Cawa\Bootstrap\Forms\Group;
use Cawa\Bootstrap\Forms\LabelIcon;
use Cawa\Bootstrap\Forms\MultipleGroup;
use Cawa\Controller\ViewController;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Renderer\Container;
use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;
use Cawa\Renderer\WidgetElement;

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
     * @return $this|self
     */
    public function setHelpText($helpText) : self
    {
        if (!$helpText instanceof HtmlElement) {
            $helpText = new HtmlElement('<span>', $helpText);
        }
        $helpText->addClass('help-block');

        // @see http://getbootstrap.com/css/#forms-help-text
        if (!$this instanceof Group && $this->getField()) {
            if (!$helpText->getId()) {
                $helpText->generateId();
            }

            $this->getField()->addAttribute('aria-describedby', $helpText->getId());
        }

        $this->helpText = $helpText;

        return $this;
    }

    /**
     * @var array
     */
    private $inputGroups = [];

    /**
     * @return array
     */
    public function getInputGroups() : array
    {
        return $this->inputGroups;
    }

    /**
     * @param Button|Dropdown|Checkbox|Radio|string $item
     * @param bool $left
     *
     * @return $this|self
     */
    public function addInputGroup($item, bool $left = true) : self
    {
        if ($item instanceof Button || $item instanceof Dropdown) {
            $this->inputGroups[$left][] = (new HtmlContainer('<span>'))
                ->addClass('input-group-btn')
                ->add($item);
        } elseif ($item instanceof Checkbox || $item instanceof Radio) {
            $this->inputGroups[$left][] = (new HtmlContainer('<span>'))
                ->addClass('input-group-addon')
                ->add($item->getField());
        } else {
            $this->inputGroups[$left][] = (new HtmlElement('<span>', $item))
                ->addClass('input-group-addon');
        }

        return $this;
    }

    /**
     * @param Container|HtmlContainer $container
     *
     * @return ViewController|Container|HtmlContainer
     */
    protected function getFieldContainer($container)
    {
        foreach ($container->getElements() as $element) {
            if ($element === $this->getField()) {
                return $container;
            }

            if ($element instanceof HtmlContainer || $element instanceof Container) {
                $return = $this->getFieldContainer($element);
                if ($return) {
                    return $return;
                }
            }
        }
    }

    /**
     * @return HtmlContainer|Container
     */
    private function layoutInputGroup()
    {
        $inputGroupWrapper = (new HtmlContainer('<div>'))
            ->addClass('input-group');

        if (isset($this->inputGroups[true])) {
            foreach ($this->inputGroups[true] as $inputGroup) {
                $inputGroupWrapper->add($inputGroup);
            }
        }

        $inputGroupWrapper->add($this->getField());

        if (isset($this->inputGroups[false])) {
            foreach ($this->inputGroups[false] as $inputGroup) {
                $inputGroupWrapper->add($inputGroup);
            }
        }

        if (!$this->getGridSize()) {
            $fieldWrapper = new Container();
            if ($this->getLabel()) {
                $fieldWrapper->add($this->getLabel());
            }
            $fieldWrapper->add($inputGroupWrapper);

            return $fieldWrapper;
        } else {
            $fieldWrapper = new HtmlContainer('<div>');
            $fieldWrapper->add($inputGroupWrapper);

            return $fieldWrapper;
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
            if ($this instanceof Group) {
                $fieldWrapper = $this->getContainer();
            } else {
                if (sizeof($this->inputGroups)) {
                    $fieldWrapper = $this->layoutInputGroup();
                } else {
                    $fieldWrapper = new HtmlContainer('<div>');
                    $fieldWrapper->add($this->getField());
                }
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

                if ($this instanceof Group) {
                    $this->helpText->addClass('col-md-12');
                }

                if ($fieldWrapper instanceof WidgetElement) {
                    $fieldWrapper->getElement()->add($this->helpText);
                } else {
                    $fieldWrapper->add($this->helpText);
                }
            }

            $container->add($fieldWrapper);

            return $container;
        } else {
            if (sizeof($this->inputGroups)) {
                $container = new Container();
                $container->add($this->layoutInputGroup());
            } else {
                $container = parent::layout();
            }

            if ($this->helpText) {
                $container->add($this->helpText);
            }

            return $container;
        }
    }
}
