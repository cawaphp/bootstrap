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

namespace Cawa\Bootstrap\Forms\ExtendedFields;

use Cawa\Bootstrap\Forms\Fields\Select;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Renderer\Container;
use Cawa\Renderer\WidgetOption;

class Combo extends Select
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null, array $options = [])
    {
        $this->widgetOptions = new WidgetOption();
        parent::__construct($name, $label, $options);
        $this->getField()->addClass('cawa-fields-combo hidden');
    }

    /**
     * @var WidgetOption
     */
    private $widgetOptions;

    /**
     * @param string|null $name
     *
     * @return $this
     */
    public function setPlaceholder(string $name = null) : parent
    {
        $this->widgetOptions->addData('plugin', ['placeholder' => $name]);

        return parent::setPlaceholder($name);
    }

    /**
     * @param bool $searchBox
     *
     * @return $this
     */
    public function setSearchBox(bool $searchBox = false) : self
    {
        $this->widgetOptions->addData('searchBox', $searchBox);

        return $this;
    }

    /**
     * @param int $length
     *
     * @return $this
     */
    public function setMinimunFilterLength(int $length) : self
    {
        $this->widgetOptions->addData('plugin', ['minimumInputLength' => $length]);

        return $this;
    }

    /**
     * @param int $length
     *
     * @return $this
     */
    public function setMaximumFilterLength(int $length) : self
    {
        $this->widgetOptions->addData('plugin', ['maximumInputLength' => $length]);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setRemoteUrl(string $url) : self
    {
        $this->widgetOptions->addData('plugin', ['ajax' => ['url' => $url]]);

        return $this;
    }

    /**
     * @param bool $close
     *
     * @return $this
     */
    public function setCloseOnSelect(bool $close) : self
    {
        $this->widgetOptions->addData('plugin', ['closeOnSelect' => $close]);

        return $this;
    }

    /**
     * @param bool $html
     *
     * @return $this
     */
    public function setRemoteHtml(bool $html = true) : self
    {
        $this->widgetOptions->addData('remoteHtml', $html);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value) : AbstractField
    {
        $dynamicValue = false;
        if (isset($this->widgetOptions->getData()['plugin']['tags'])) {
            $dynamicValue = true;
        } elseif (isset($this->widgetOptions->getData()['plugin']['ajax'])) {
            $dynamicValue = true;
        }

        if ($dynamicValue && !isset($this->options[$value])) {
            if ($value) {
                if (!is_array($value)) {
                    $value = [$value];
                }

                foreach ($value as $option) {
                    $this->addOption((string) $option, (string) $option);
                }
            }
        }

        return parent::setValue($value);
    }

    /**
     * @param bool $tag
     *
     * @return $this
     */
    public function setTagTyping(bool $tag = true) : self
    {
        $this->widgetOptions->addData('plugin', ['tags' => $tag]);
        $this->checkValue = !$tag;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function layout() : Container
    {
        if ($this->isRequired() == false) {
            $this->widgetOptions->addData('plugin', ['allowClear' => true]);
        }

        $container = parent::layout();
        if ($this->widgetOptions->count()) {
            $instance = $this->getFieldContainer($container);
            $instance->add($this->widgetOptions);
        }

        return $container;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->optionsElements['']->setRenderable(false);

        return parent::render();
    }
}
