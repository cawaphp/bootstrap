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

namespace Cawa\Bootstrap\Components;

use Cawa\Bootstrap\Tables\Grid;
use Cawa\Bootstrap\Tables\Table;
use Cawa\Controller\ViewController;
use Cawa\Renderer\Container;
use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;

class Panel extends HtmlContainer
{
    const TYPE_DEFAULT = 'panel-default';
    const TYPE_PRIMARY = 'panel-primary';
    const TYPE_SUCCESS = 'panel-success';
    const TYPE_INFO = 'panel-info';
    const TYPE_WARNING = 'panel-warning';
    const TYPE_DANGER = 'panel-danger';

    /**
     * @param string $title
     * @param string $content
     * @param string $type
     */
    public function __construct(string $title = null, string $content = null, string $type = self::TYPE_DEFAULT)
    {
        parent::__construct('<div>', $content);
        $this->addClass(['panel', $type]);
        $this->container = new Container();
        $this->title = $title;
    }

    /**
     * @var string
     */
    private $title;

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this|self
     */
    public function setTitle(string $title) : self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @var string
     */
    private $footer;

    /**
     * @return string
     */
    public function getFooter() : string
    {
        return $this->footer;
    }

    /**
     * @param string $footer
     *
     * @return $this|self
     */
    public function setFooter(string $footer) : self
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * @var Container
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function add(ViewController ...$elements)
    {
        $this->container->add(...$elements);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addFirst(ViewController ...$elements)
    {
        $this->container->addFirst(...$elements);

        return $this;
    }

    /**
     * @var ButtonGroup
     */
    private $buttonGroup;

    public function addButton(Button $button)
    {
        if (!$this->buttonGroup) {
            $this->buttonGroup = (new ButtonGroup(ButtonGroup::SIZE_SMALL))
                ->addClass('pull-right');
        }

        $this->buttonGroup->add($button);

        return $this;
    }

    /**
     * @return HtmlContainer
     */
    protected function renderHeader() : HtmlContainer
    {
        $header = (new HtmlContainer('<div>'))
            ->addClass('panel-heading');

        if ($this->title || $this->buttonGroup) {
            if ($this->buttonGroup) {
                $header->add($this->buttonGroup);
            }

            if ($this->title) {
                $header->add((new HtmlElement('<h3>', $this->title))->addClass('panel-title'));
            }
        }

        return $header;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $header = $this->renderHeader();
        if (sizeof($header->getElements())) {
            parent::add($header);
        }

        if ($this->content) {
            parent::add((new HtmlElement('<div>', $this->content))
                ->addClass('panel-body'));
        } else {
            $container = new Container();
            foreach ($this->container->getElements() as $element) {
                $body = true;
                if ($element instanceof Table || $element instanceof Grid || $element instanceof ListGroup) {
                    $body = false;
                } elseif ($body && $element instanceof HtmlElement && $element->getTag() == '<table>') {
                    $body = false;
                }

                if (!$body) {
                    if (sizeof($container->getElements()) > 0) {
                        parent::add((new HtmlContainer('<div>'))
                            ->addClass('panel-body')
                            ->add($container));
                        $container = new Container();
                    }

                    parent::add($element);
                } else {
                    $container->add($element);
                }
            }

            if (sizeof($container->getElements()) > 0) {
                parent::add((new HtmlContainer('<div>'))
                    ->addClass('panel-body')
                    ->add($container));
            }
        }

        if ($this->footer) {
            parent::add((new HtmlElement('<div>', $this->footer))
                ->addClass('panel-footer'));
        }

        return parent::render();
    }
}
