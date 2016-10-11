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

use Cawa\Controller\ViewController;
use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;

class ListGroup extends HtmlContainer
{
    /**
     * @param string $tag
     */
    public function __construct($tag = '<ul>')
    {
        parent::__construct($tag);
        $this->addClass('list-group');
    }

    /**
     * @param HtmlElement $element
     *
     * @return HtmlElement
     */
    private function beforeAdd(HtmlElement $element)
    {
        $element->addClass('list-group-item');

        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public function add(ViewController ...$elements)
    {
        foreach ($elements as $element) {
            /* @noinspection PhpParamsInspection */
            parent::add($this->beforeAdd($element));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addFirst(ViewController ...$elements)
    {
        foreach ($elements as $element) {
            /* @noinspection PhpParamsInspection */
            parent::add($this->beforeAdd($element));
        }

        return $this;
    }
}
