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

use Cawa\App\HttpFactory;
use Cawa\Html\Link;
use Cawa\Renderer\Container;
use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;

class Breadcrumb extends Container
{
    use HttpFactory;

    /**
     * @var HtmlContainer
     */
    private $ol;

    /**
     * @var HtmlElement
     */
    private $schema;

    /**
     * @param array $links
     */
    public function __construct(array $links = [])
    {
        $this->setOl($links)
            ->setSchema($links);
    }

    /**
     * @param array $links
     *
     * @return $this|self
     */
    private function setOl(array $links = []) : self
    {
        $this->ol = new HtmlContainer('<ol>');
        $this->ol->addClass('breadcrumb');

        $last = null;
        foreach ($links as $uri => $link) {
            if (!$uri) {
                $last = $link;
            } else {
                $this->ol->add(
                    (new HtmlContainer('<li>'))
                        ->add(
                            new Link($link, $uri)
                        )
                );
            }
        }

        if ($last) {
            $this->ol->add(
                (new HtmlElement('<li>', $last))
                    ->addClass('active')
            );
        }

        $this->add($this->ol);

        return $this;
    }


    /**
     * @param array $links
     *
     * @return $this|self
     */
    private function setSchema(array $links = []) : self
    {
        $this->schema = new HtmlContainer('<script>');
        $this->schema->addAttribute('type', 'application/ld+json');

        $content = [
            '@context' => "http://schema.org",
            '@type' => 'BreadcrumbList',
            'itemListElement' => [],
        ];

        $uri = clone self::request()->getUri();
        $count = 1;
        foreach ($links as $url => $link) {
            $content['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $count,
                'item' => [
                    '@id' => $uri->setPath($url)->get(false),
                    'name' => $link,
                ],
            ];
            $count++;
        }

        $this->schema->setContent(json_encode($content));
        $this->add($this->schema);

        return $this;
    }

}
