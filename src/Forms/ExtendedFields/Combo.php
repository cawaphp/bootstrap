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
use Cawa\Renderer\HtmlContainer;
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
        $this->getField()->addClass('cawa-fields-combo');
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
        $this->widgetOptions->addData("plugin", ["placeholder" => $name]);

        return parent::setPlaceholder($name);
    }

    /**
     * @param bool $searchBox
     *
     * @return $this
     */
    public function setSearchBox(bool $searchBox = false) : self
    {
        $this->widgetOptions->addData("searchBox", $searchBox);

        return $this;
    }

    /**
     * @param int $length
     *
     * @return $this
     */
    public function setMinimunFilterLength(int $length) : self
    {
        $this->widgetOptions->addData("plugin", ["minimumInputLength" => $length]);

        return $this;
    }

    /**
     * @param int $length
     *
     * @return $this
     */
    public function setMaximumFilterLength(int $length) : self
    {
        $this->widgetOptions->addData("plugin", ["maximumInputLength" => $length]);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setRemoteUrl(string $url) : self
    {
        $this->widgetOptions->addData("plugin", ["ajax" => ["url" => $url]]);

        return $this;
    }

    /**
     * @param bool $html
     *
     * @return $this
     */
    public function setRemoteHtml(bool $html = true) : self
    {
        $this->widgetOptions->addData("remoteHtml", $html);

        return $this;
    }

    /**
     * @param bool $tag
     *
     * @return $this
     */
    public function setTagTyping(bool $tag = true) : self
    {
        $this->widgetOptions->addData("plugin", ["tags" => $tag]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if ($this->isRequired() == false) {
            $this->widgetOptions->addData("plugin", ["allowClear" => true]);
        }

        if ($this->widgetOptions->count()) {
            $container = new HtmlContainer("<div>");
            $container->add($this->getField());
            $container->add($this->widgetOptions);
            $this->setField($container);
        }

        return parent::render();
    }
}