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

use Cawa\App\HttpFactory;
use Cawa\Bootstrap\Components\Button;
use Cawa\Controller\ViewController;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;
use Cawa\Renderer\WidgetElement;
use DeepCopy\DeepCopy;

class MultipleGroup extends Group
{
    use HttpFactory;

    /**
     * @param string $label
     */
    public function __construct($label)
    {
        parent::__construct($label);

        /** @var HtmlElement $element */
        foreach ($this->elements as $i => $element) {
            if ($element->getTag() == '<div>' && $element->hasClass('row')) {
                $this->newContainer = WidgetElement::create(
                    HtmlContainer::create('<div>')
                        ->addClass('cawa-fields-multiple-group')
                        ->add($this->getInputGroup($element))
                )
                ;

                $this->elements[$i] = $this->newContainer;
            }
        }
    }

    /**
     * @param Form $form
     */
    public function onAdd(Form $form)
    {
        if ($form->isSubmit()) {
            $submitData = [];
            $nameIndex = [];
            foreach ($this->fields as $i => $field) {
                $name = substr($field->getName(), 0, -2);
                if (!in_array($name, $nameIndex)) {
                    $nameIndex[] = $name;

                    $userInput = $this->request()->getArg($name);
                    if ($this->container->first() instanceof Group) {
                        foreach ($this->request()->getArg($name) as $index => $value) {
                            $submitData[$index][$i] = $value;
                        };
                    } else {
                        $submitData = $userInput;
                    }
                }
            }

            $this->setValues($submitData);
        }
    }

    /**
     * @var AbstractField[]
     */
    private $fields = [];

    /**
     * @return AbstractField[]
     */
    public function getFields() : array
    {
        return $this->fields;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function setValues(array $values) : self
    {
        foreach ($values as $index => $value) {
            if ($index > $this->row) {
                $deepcopy = new DeepCopy();
                $input = $deepcopy->copy($this->container->first());

                $this->addRow();
                $this->add($input);
            }

            $input = $this->container->first();
            if (is_array($value)) {
                if (!$input instanceof Group) {
                    throw new \InvalidArgumentException(sprintf("Unexpexted '%s' with array value", get_class($input)));
                }
                /* @var Group $input */
                foreach ($value as $pos => $current) {
                    $input->getFields()[$pos]->setValue($current);
                }
            } else {
                /* @var AbstractField $input */
                $input->setValue($value);
            }
        }

        return $this;
    }

    /**
     * @param \Cawa\Controller\ViewController[] ...$elements
     */
    private function addHook(ViewController ...$elements)
    {
        foreach ($elements as $element) {
            if ($element instanceof Group) {
                foreach ($element->getFields() as $current) {
                    $this->fields[] = $current;
                }
            } else {
                $this->fields[] = $element;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(ViewController ...$elements)
    {
        $this->addHook(...$elements);

        return parent::add(...$elements);
    }

    /**
     * {@inheritdoc}
     */
    public function addFirst(ViewController ...$elements)
    {
        $this->addHook(...$elements);

        return parent::addFirst(...$elements);
    }

    /**
     * @var int
     */
    private $row = 0;

    /**
     * @return void
     */
    private function addRow()
    {
        $this->row++;
        $this->applyContainerSize();

        $this->container = HtmlContainer::create('<div>')
            ->addClass('row');
        $this->newContainer->getElement()->add($this->getInputGroup($this->container));
    }

    /**
     * @param $element
     *
     * @return HtmlContainer
     */
    private function getInputGroup($element) : HtmlContainer
    {
        return HtmlContainer::create('<div>')
            ->addClass('input-group')
            ->add($element)
            ->add(
                HtmlContainer::create('<div>')->addClass('input-group-btn')
                    ->add(
                        Button::create('<i class="glyphicon glyphicon-plus"></i>')
                            ->addAttribute('data-action', '+')
                    )
                    ->add(
                        Button::create('<i class="glyphicon glyphicon-minus"></i>')
                            ->addAttribute('data-action', '-')
                    )
            );
    }

    /**
     * @var HtmlContainer
     */
    private $newContainer;

    /**
     * @return WidgetElement
     */
    public function getField()
    {
        return $this->newContainer;
    }

    /**
     * @param HtmlContainer|null $field
     *
     * @return $this
     */
    protected function setField(HtmlContainer $field = null) : parent
    {
        $index = $this->getIndex($this->newContainer);
        $this->container = $field;

        if (is_null($index)) {
            array_unshift($this->elements, $field);
        } else {
            $this->elements[$index] = $field;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $deepcopy = new DeepCopy();
        $clone = $deepcopy->copy($this);
        $fullRender = $clone->renderBootstrapProperties();

        $this->newContainer->getOptions()->addData('clone', $fullRender);

        return parent::render();
    }
}