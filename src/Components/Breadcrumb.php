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

use Cawa\Html\Link;
use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;

class Breadcrumb extends HtmlContainer
{
    /**
     * @param array $links
     */
    public function __construct(array $links = [])
    {
        parent::__construct('<ol>');
        $this->addClass("breadcrumb");

        $last = null;
        foreach ($links as $uri => $link) {
            if (!$uri) {
                $last = $link;
            } else {
                $this->add(
                    HtmlContainer::create('<li>')
                        ->add(
                            Link::create($link, $uri)
                        )
                );
            }
        }

        if ($last) {
            $this->add(
                HtmlElement::create('<li>', $last)
                    ->addClass("active")
            );
        }

    }
}
