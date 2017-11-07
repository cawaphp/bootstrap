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

use Cawa\Bootstrap\Forms\Fields\Textarea;
use Cawa\Renderer\Container;
use Cawa\Renderer\WidgetOption;
use Symfony\Component\DomCrawler\Crawler;

class Ckeditor extends Textarea
{
    /**
     * @var WidgetOption
     */
    private $widgetOptions;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null)
    {
        $this->widgetOptions = new WidgetOption();

        parent::__construct($name, $label);
        $this->getField()->addClass('cawa-fields-ckeditor');
    }

    const ENTER_P = 1;
    const ENTER_BR = 2;
    const ENTER_DIV = 3;

    /**
     * @param int $mode
     *
     * @return $this|self|parent
     */
    public function setEnterMode(int $mode = null) : parent
    {
        $this->widgetOptions->addData('plugin', ['enterMode' => $mode]);

        return $this;
    }

    /**
     * @param bool $enable
     *
     * @return $this|self|parent
     */
    public function setImage(bool $enable) : parent
    {
        $this->widgetOptions->addData('image', ['enabled' => $enable]);

        return $this;
    }

    /**
     * @param array $css
     * @param bool $keepOriginal
     *
     * @return $this|self
     */
    public function setCss(array $css, bool $keepOriginal = true) : self
    {
        $this->widgetOptions->addData('plugin', ['contentsCss' => $css]);
        $this->widgetOptions->addData('originalCss', $keepOriginal);

        return $this;
    }

    /**
     * @var array
     */
    private $valueHandler = [];

    /**
     * @param callable $imageHandler
     *
     * @return $this|self
     */
    public function addValueHandler(callable $imageHandler) : self
    {
        $this->valueHandler[] = $imageHandler;

        return $this;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function transformValue($value)
    {
        if (sizeof($this->valueHandler) == 0) {
            return $value;
        }

        // https://www.hieule.info/programming/symfony-dom-crawler-component-utf-8-html
        $crawler = new Crawler();
        $crawler->addHtmlContent($value);

        /** @var \DOMElement $image */
        foreach ($crawler->filterXPath('//img') as $image) {
            foreach ($this->valueHandler as $handler) {
                $changed = $handler($image);
                if (!is_null($changed)) {
                    $image->parentNode->replaceChild($changed, $image);
                }
            }
        }

        return $crawler->filterXPath('//body')->html();
    }

    /**
     * {@inheritdoc}
     */
    public function layout() : Container
    {
        $container = parent::layout();
        if ($this->widgetOptions->count()) {
            $instance = $this->getFieldContainer($container);
            $instance->add($this->widgetOptions);
        }

        return $container;
    }
}
