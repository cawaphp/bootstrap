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

namespace Cawa\Bootstrap\Components;

use Behat\Transliterator\Transliterator;
use Cawa\Controller\ViewController;
use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;
use Cawa\Router\RouterFactory;

class TabContainer extends HtmlElement
{
    use RouterFactory;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct('<div>');
        $this->addClass('cawa-tabs');

        $this->header = (new HtmlContainer('<ul>'))
            ->addClass('nav nav-tabs')
            ->addAttribute('data-tabs', 'tabs')
        ;

        $this->body = (new HtmlContainer('<div>'))
            ->addClass('tab-content');
    }

    /**
     * @param array $routes
     * @param int $index
     * @param ViewController $content
     * @param bool $keepActiveLink
     *
     * @return $this|TabContainer
     */
    public static function fromRoute(
        array $routes,
        int $index,
        ViewController $content,
        bool $keepActiveLink = false
    ) : self {
        $container = new static();

        foreach ($routes as $currentIndex => $route) {
            $container->add($tab = (new Tab($route['name'])));

            if ($index == $currentIndex) {
                $tab->add($content)->setActive();
            }

            if (isset($route['routeName']) &&
                (!isset($route['disabled']) || $route['disabled'] == false) &&
                ($keepActiveLink || $index != $currentIndex)
            ) {
                $tab->setHref((string) self::uri($route['routeName'], $route['routeArgs'] ?? []));
            }

            if (isset($route['disabled']) && $route['disabled']) {
                $tab->setDisabled(true);
            }

            if (isset($route['renderable']) && !$route['renderable']) {
                $tab->setRenderable(false);
            }
        }

        return $container;
    }

    /**
     * @var HtmlElement
     */
    protected $header;

    /**
     * @return HtmlElement
     */
    public function getHeader() : HtmlElement
    {
        return $this->header;
    }

    /**
     * @var HtmlElement
     */
    protected $body;

    /**
     * @return bool
     */
    public function isPills() : bool
    {
        return $this->header->hasClass('nav-pills');
    }

    /**
     * @param bool $justified
     *
     * @return $this|self
     */
    public function setPills(bool $justified = true) : self
    {
        if ($justified) {
            $this->header->addClass('nav-pills');
            $this->header->removeClass('nav-tabs');
        } else {
            $this->header->removeClass('nav-pills');
            $this->header->addClass('nav-tabs');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isStacked() : bool
    {
        return $this->header->hasClass('nav-stacked');
    }

    /**
     * @param bool $stacked
     *
     * @return $this|self
     */
    public function setStacked(bool $stacked = true) : self
    {
        if ($stacked) {
            $this->header->addClass('nav-stacked');
        } else {
            $this->header->removeClass('nav-stacked');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isJustified() : bool
    {
        return $this->header->hasClass('nav-justified');
    }

    /**
     * @param bool $justified
     *
     * @return $this|self
     */
    public function setJustified(bool $justified = true) : self
    {
        if ($justified) {
            $this->header->addClass('nav-justified');
        } else {
            $this->header->removeClass('nav-justified');
        }

        return $this;
    }

    /**
     * @var bool
     */
    private $activateFirst = true;

    /**
     * @return bool
     */
    public function isActivateFirst() : bool
    {
        return $this->activateFirst;
    }

    /**
     * @param bool $activateFirst
     *
     * @return TabContainer
     */
    public function setActivateFirst(bool $activateFirst) : TabContainer
    {
        $this->activateFirst = $activateFirst;

        return $this;
    }

    /**
     * @param Tab|Tab[] ...$tab
     *
     * @return $this|self
     */
    public function add(Tab ...$tab) : self
    {
        $this->body->add(...$tab);

        return $this;
    }

    /**
     * @return Tab[]
     */
    public function getTabs() : array
    {
        return $this->body->getElements();
    }

    /**
     * Build all elements
     */
    protected function build()
    {
        $this->header->clear();

        $active = false;

        /** @var Tab $element */
        foreach ($this->body->getElements() as $element) {
            if (!$element->isRenderable()) {
                continue;
            }

            $active = $element->isActive() ? true : $active;

            if (!$element->getHref()) {
                $id = Transliterator::urlize($element->getTitle());
                $element->setHref('#' . $id);
            }
        }

        if ($this->activateFirst && $active == false && isset($this->body->getElements()[0])) {
            $this->body->getElements()[0]->setActive();
        }

        foreach ($this->body->getElements() as $element) {
            if ($element->isRenderable()) {
                $this->header->add($element->getHeader());
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->build();

        $this->setContent(
            $this->header->render() .
            $this->body->render()
        );

        return parent::render();
    }
}
