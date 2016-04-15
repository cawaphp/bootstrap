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

use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;
use Cawa\Controller\ViewController;

class Dropdown extends ViewController
{
    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->container = new HtmlContainer('<div>');
        $this->container->addClass('dropdown');

        $this->button = new Button($title);
        $this->button->addClass('dropdown-toggle');
        $this->button->addAttributes([
            'data-toggle' => 'dropdown',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false',
        ]);
        $this->container->add($this->button);

        $this->ul = new HtmlContainer('<ul>');
        $this->ul->addClass('dropdown-menu');
        $this->container->add($this->ul);

        parent::__construct();
    }

    /**
     * @var Button
     */
    private $container;

    /**
     * @var Button
     */
    private $button;

    /**
     * @var Button
     */
    private $ul;

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->button->getContent();
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title) : self
    {
        $this->button->setContent($title);

        return $this;
    }

    /**
     * @param string|HtmlElement $element
     *
     * @return $this
     */
    public function add($element) : self
    {
        if (is_string($element) && $element == '---') {
            $element = HtmlElement::create('<li>')
                ->addAttribute('role', 'separator')
                ->addClass('divider');
        } elseif (is_string($element)) {
            $element = HtmlElement::create('<li>')
                ->setContent($element)
                ->addClass('dropdown-header');
        } else {
            $element = HtmlContainer::create('<li>')
                ->add($element);
        }

        $this->ul->add($element);

        return $this;
    }

    /**
     * @return $this
     */
    public function toNavbar() : self
    {
        $this->container->setTag('<li>');
        $this->button->setTag(Button::TAG_A);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $title = $this->getTitle();
        $this->setTitle($title . ' <span class="caret"></span>');

        $return = $this->container->render();

        $this->setTitle($title);

        return $return;
    }
}
