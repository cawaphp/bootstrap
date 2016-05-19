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

class Tab extends HtmlContainer
{
    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        parent::__construct('<div>');
        $this->addClass('tab-pane');
        $this->title = $title;
    }

    /**
     * @var string
     */
    private $title;

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title) : self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @var string
     */
    private $icon;

    /**
     * @return string
     */
    public function getIcon() : string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon(string $icon) : self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->hasClass('active');
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active = true) : self
    {
        if ($active) {
            $this->addClass('active');
        } else {
            $this->removeClass('active');
        }

        return $this;
    }

    /**
     * @var bool
     */
    private $disabled = false;

    /**
     * @return bool
     */
    public function isDisabled() : bool
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     *
     * @return $this
     */
    public function setDisabled(bool $disabled) : self
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * @var string
     */
    private $href;

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $href
     *
     * @return $this
     */
    public function setHref(string $href) : self
    {
        $this->href = $href;

        if (substr($this->href, 0, 1) == '#') {
            $this->setId(substr($this->href, 1));
        }

        return $this;
    }

    /**
     * @return HtmlContainer
     */
    public function getHeader() : HtmlContainer
    {
        $title = ($this->icon ? HtmlElement::create('<i>')->addClass($this->icon)->render() . ' ' : '') .
            $this->title;

        $link = HtmlContainer::create('<a>', $title);
        if ($this->href) {
            $link->addAttribute('href', $this->href);
        }

        if (substr($this->href, 0, 1) == '#') {
            $link->addAttribute('data-toggle', 'tab');
        }

        $li = HtmlContainer::create('<li>')
            ->addAttribute('role', 'presentation')
            ->add($link)
        ;

        if ($this->isActive()) {
            $li->addClass('active');
        }

        if ($this->isDisabled()) {
            $li->addClass('disabled');
        }

        return $li;
    }
}