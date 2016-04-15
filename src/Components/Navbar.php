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

namespace Cawa\Bootstrap\Components;

use Cawa\Intl\TranslatorFactory;
use Cawa\Renderer\Container;
use Cawa\Renderer\HtmlElement;
use Cawa\Renderer\Phtml;
use Cawa\Controller\ViewData;
use Cawa\Bootstrap\Forms\Form;

class Navbar extends HtmlElement
{
    use TranslatorFactory;
    use ViewData;
    use Phtml {
        Phtml::render as private phtmlRender;
    }

    /**
     *
     */
    public function __construct()
    {
        parent::__construct('<nav>');
        $this->addClass(['navbar', 'navbar-default']);

        $this->elements = new Container();

        $this->translator()->addFile(__DIR__ . '/../../lang/global', 'bootstrap');
    }

    /**
     * @var Container
     */
    private $elements;

    /**
     * @param HtmlElement $element
     * @param bool $left
     *
     * @return $this
     */
    public function add(HtmlElement $element, bool $left = true) : self
    {
        if ($element instanceof Button) {
            $element->addClass('navbar-btn');
        } elseif ($element instanceof Form) {
            $element->addClass('navbar-form');
            $element->setInline();
        } elseif ($element instanceof HtmlElement && $element->getTag() == '<p>') {
            $element->addClass('navbar-text');
        } elseif ($element instanceof HtmlElement && $element->getTag() == '<ul>') {
            $element->addClass(['nav', 'navbar-nav']);
        }

        $element->addClass($left ? 'navbar-left' : 'navbar-right');

        $this->elements->add($element);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->data['id'] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function setId(string $value) : parent
    {
        $this->data['id'] = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isInverse() : bool
    {
        return $this->hasClass('navbar-inverse');
    }

    /**
     * @param bool $inverse
     *
     * @return $this
     */
    public function setInverse(bool $inverse = true)
    {
        if ($inverse) {
            $this->addClass('navbar-inverse');
            $this->removeClass('navbar-default');
        } else {
            $this->removeClass('navbar-inverse');
            $this->addClass('navbar-default');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isFixedToTop() : bool
    {
        return $this->hasClass('navbar-fixed-top');
    }

    /**
     * @param bool $fixedToTop
     *
     * @return $this
     */
    public function setFixedToTop(bool $fixedToTop = true)
    {
        if ($fixedToTop) {
            $this->addClass('navbar-fixed-top');
            $this->removeClass('navbar-fixed-bottom');
            $this->removeClass('navbar-static-top');
        } else {
            $this->removeClass('navbar-fixed-top');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isStaticToTop() : bool
    {
        return $this->hasClass('navbar-static-top');
    }

    /**
     * @param bool $StaticToTop
     *
     * @return $this
     */
    public function setStaticToTop(bool $StaticToTop = true)
    {
        if ($StaticToTop) {
            $this->addClass('navbar-static-top');
            $this->removeClass('navbar-fixed-top');
            $this->removeClass('navbar-fixed-bottom');
        } else {
            $this->removeClass('navbar-static-top');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isFixedToBottom() : bool
    {
        return $this->hasClass('navbar-fixed-Bottom');
    }

    /**
     * @param bool $fixedToBottom
     *
     * @return $this
     */
    public function setFixedToBottom(bool $fixedToBottom = true)
    {
        if ($fixedToBottom) {
            $this->addClass('navbar-fixed-bottom');
            $this->removeClass('navbar-fixed-top');
            $this->removeClass('navbar-static-top');
        } else {
            $this->removeClass('navbar-fixed-bottom');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if (!isset($this->data['id'])) {
            $this->generateId();
        }

        $this->data['content'] = $this->elements->render();

        $phtml = $this->phtmlRender();

        if ($this->isStaticToTop()) {
            $phtml = HtmlElement::create('<div>')
                ->addClass('container')
                ->setContent($phtml)
                ->render();
        }

        $this->setContent($phtml);

        $return = parent::render();

        return $return;
    }
}
