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

use Cawa\Renderer\Container;
use Cawa\Renderer\WidgetOption;

class File extends \Cawa\Bootstrap\Forms\Fields\File
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null)
    {
        parent::__construct($name, $label);
        $this->getField()->addClass('cawa-fields-file');
    }

    /**
     * {@inheritdoc}
     */
    public function setRequired(bool $required = true)
    {
        if ($required == true) {
            $this->widgetOptions['plugin']['showRemove'] = false;
        } else {
            unset($this->widgetOptions['plugin']['showRemove']);
        }

        return parent::setRequired($required);
    }

    /**
     * @return bool
     */
    public function isMultiple() : bool
    {
        return $this->getField()->hasAttribute('multiple');
    }

    /**
     * @param bool $multiple
     *
     * @return $this|self
     */
    public function setMultiple(bool $multiple = true)
    {
        if ($multiple) {
            $this->getField()->addAttribute('multiple', 'multiple');
        } else {
            $this->getField()->removeAttribute('multiple');
        }

        return $this;
    }

    /**
     * @var array
     */
    protected $widgetOptions = [];

    /**
     * @param array $extensions
     *
     * @return $this|self
     */
    public function setAllowedExtensions(array $extensions) : self
    {
        $this->widgetOptions['plugin']['allowedFileExtensions'] = $extensions;
        unset($this->widgetOptions['plugin']['allowedFileTypes']);

        return $this;
    }

    /**
     * @param array|string $url
     *
     * @return $this|self
     */
    public function setUrl($url) : self
    {
        if (is_string($url)) {
            $url = [$url];
        }

        $this->widgetOptions['files'] = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function layout() : Container
    {
        $container = parent::layout();
        if ($this->widgetOptions) {
            $instance = $this->getFieldContainer($container);
            $instance->add(new WidgetOption($this->widgetOptions));
        }

        return $container;
    }
}
