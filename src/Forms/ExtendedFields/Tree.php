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

use Cawa\Bootstrap\Forms\Fields\Text;
use Cawa\Html\Forms\FieldsProperties\MultipleValueInterface;
use Cawa\Renderer\Container;
use Cawa\Renderer\HtmlElement;
use Cawa\Renderer\WidgetOption;

class Tree extends Text implements MultipleValueInterface
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null)
    {
        parent::__construct($name, $label);
        $this->getField()->addClass('cawa-fields-tree hidden');
    }

    /**
     * @var array|TreeItem[]
     */
    private $data;

    /**
     * @param array|TreeItem[] $data
     *
     * @return $this|self
     */
    public function setData($data) : self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value) : parent
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        foreach ($value as $current) {
            $this->findItem($this->data, $current);
        }

        return $this;
    }

    /**
     * @param array|TreeItem[] $data
     * @param string $value
     */
    private function findItem(array $data, string $value)
    {
        foreach ($data as $current) {
            if ($current->getId() == $value) {
                $current->setSelected(true);
            }

            if ($current->getChildren()) {
                $this->findItem($current->getChildren(), $value);
            }
        }
    }

    /**
     * @var array
     */
    private $widgetOptions = [];

    /**
     * @return string
     */
    public function render()
    {
        $this->widgetOptions['plugin']['core']['data'] = $this->data;

        return parent::render();
    }

    /**
     * {@inheritdoc}
     */
    public function layout() : Container
    {
        $container = parent::layout();
        $instance = $this->getFieldContainer($container);
        $instance->add(new WidgetOption($this->widgetOptions));
        $instance->add((new HtmlElement('<div>'))->addClass('tree'));

        return $container;
    }
}
