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

namespace Cawa\Bootstrap\Forms\ExtendedFields;

use Cawa\Bootstrap\Forms\Fields\FieldTrait;
use Cawa\Bootstrap\Forms\Form;
use Cawa\Bootstrap\Properties\ButtonInterface;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Html\Forms\FieldsProperties\MultipleTrait;
use Cawa\Renderer\Container;
use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;

class ButtonGroup extends AbstractField implements ButtonInterface
{
    use FieldTrait {
        FieldTrait::layout as private fieldTraitLayout;
    }
    use MultipleTrait;

    /**
     * @param string $name
     * @param string $label
     * @param array $values
     */
    public function __construct(string $name, string $label = null, array $values = [])
    {
        parent::__construct('<input />', $name, $label);
        $this->getField()->addAttribute('type', 'hidden');
        $this->getField()->setRenderable(false);

        $this->addClass('form-group cawa-fields-button-group');

        $this->values = $values;
    }

    /**
     * @var array
     */
    private $values;

    /**
     * @var array
     */
    private $disabledValues = [];

    /**
     * @return array
     */
    public function getDisabledValues()
    {
        return $this->disabledValues;
    }

    /**
     * @param array $disabledValues
     *
     * @return self|$this
     */
    public function setDisabledValues(array $disabledValues) : self
    {
        $this->disabledValues = $disabledValues;

        return $this;
    }

    /**
     * @var string
     */
    private $displayType = self::TYPE_DEFAULT;

    /**
     * @param string $type
     *
     * @return $this|self
     */
    public function setDisplayType(string $type) : self
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getConstants() as $key => $value) {
            if (strpos($key, 'TYPE_') !== false) {
                $this->getField()->removeClass($value);
            }
        }

        $this->displayType = $type;

        return $this;
    }

    /**
     * @return HtmlContainer
     */
    private function getGroup() : HtmlContainer
    {
        $container = (new HtmlContainer('<div>'))
            ->addAttributes([
                'class' => 'btn-group',
                'data-toggle' => 'buttons',
            ]);

        foreach ($this->values as $key => $value) {
            $container->add($label = (new HtmlContainer('<label>'))
                ->addClass('btn ' . $this->displayType)
                ->addClass(in_array($key, $this->disabledValues) ? 'disabled' : '')
                ->add($input = (new HtmlElement('<input>'))
                    ->addAttributes([
                        'name' => $this->getName(),
                        'autocomplete' => 'off',
                        'value' => $key,
                        'type' => $this->isMultiple() ? 'checkbox' : 'radio',
                    ])
                    ->addClass(in_array($key, $this->disabledValues) ? 'disabled' : '')
                    ->setContent($value)
                )
            );

            if ($this->getFieldSize() == Form::SIZE_LARGE) {
                $label->addClass(self::SIZE_LARGE);
            }

            if ($this->getFieldSize() == Form::SIZE_SMALL) {
                $label->addClass(self::SIZE_SMALL);
            }

            if ($this->getValue() == $key) {
                $label->addClass('active');
                $input->addAttribute('checked', 'checked');
            }
        }

        return $container;
    }

    /**
     * {@inheritdoc}
     */
    public function layout() : Container
    {
        $container = $this->fieldTraitLayout();

        $add = (new HtmlContainer('<div>'))
            ->addClass('form-control-static')
            ->add($this->getGroup());

        if (!$this->getGridSize()) {
            $container->add($add);
        } else {
            foreach ($container->getElements() as $element) {
                if ($element->getTag() == '<div>') {
                    $element->add($this->getGroup());
                }
            }
        }

        return $container;
    }
}
