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
use Cawa\Net\Uri;

class Pagination extends HtmlElement
{
    const QUERY_PAGE = 'page';

    const SIZE_LARGE = 'pagination-lg';
    const SIZE_SMALL = 'pagination-sm';

    /**
     * @param int $page
     * @param $callback $argsCallback
     */
    public function __construct(int $page, callable $argsCallback = null)
    {
        parent::__construct('<nav>');

        $this->page = $page;

        if ($argsCallback) {
            $this->argsCallback = $argsCallback;
        } else {
            $this->argsCallback = function (self $caller, int $page = null) {
                if ($page) {
                    return Uri::parse()->addQuery(self::QUERY_PAGE, (string) $page)->get();
                } else {
                    return (int) Uri::parse()->getQuery(self::QUERY_PAGE);
                }
            };
        }

        $this->current = call_user_func($this->argsCallback, $this) ?? 1;

        $this->ul = new HtmlContainer('<ul>');
        $this->ul->addClass('pagination');
    }

    /**
     * @var HtmlContainer
     */
    private $ul;

    /**
     * @param string $size
     *
     * @return $this
     */
    public function setSize(string $size) : self
    {
        $this->ul->addClass($size);

        return $this;
    }

    /**
     * @var callable
     */
    private $argsCallback;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $current = 1;

    /**
     * @param int $page
     * @param string $display
     *
     * @return HtmlElement
     */
    private function getLi(int $page, string $display = null) : HtmlElement
    {
        $li = new HtmlElement('<li>');
        $url = call_user_func($this->argsCallback, $this, $page);
        if ($page == $this->current) {
            $li->addClass($display ? 'disabled' : 'active');
        }

        if ($this->current == $page) {
            $li->setContent('<span href="' . $url . '">' . ($display ?: $page) . '</span>');
        } else {
            $li->setContent('<a href="' . $url . '">' . ($display ?: $page) . '</a>');
        }

        return $li;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->ul->clear();

        $this->ul->add($this->getLi(max(1, $this->current-1), '&laquo;')->addClass('prev'));

        for ($i=1; $i<=$this->page; $i++) {
            $this->ul->add($this->getLi($i));
        }

        $this->ul->add($this->getLi(min($this->page, $this->current+1), '&raquo;')->addClass('next'));

        $this->setContent($this->ul->render());

        return parent::render();
    }
}
