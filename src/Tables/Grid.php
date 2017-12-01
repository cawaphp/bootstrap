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

namespace Cawa\Bootstrap\Tables;

use Cawa\App\HttpFactory;
use Cawa\Bootstrap\Components\Dropdown;
use Cawa\Bootstrap\Components\Navbar;
use Cawa\Bootstrap\Components\Pagination;
use Cawa\Bootstrap\Forms\Fields\Checkbox;
use Cawa\Bootstrap\Forms\Fields\Submit;
use Cawa\Bootstrap\Forms\Form;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Html\Forms\Fields\Radio;
use Cawa\Html\Link;
use Cawa\Intl\TranslatorFactory;
use Cawa\Net\Uri;
use Cawa\Renderer\HtmlContainer;
use DeepCopy\DeepCopy;

class Grid extends HtmlContainer
{
    use HttpFactory;
    use TranslatorFactory;

    const QUERY_PAGESIZE = 'size';
    const OPTIONS_ROWSPERPAGE = 'rowsperpage';

    /**
     * @param string $stateId
     */
    public function __construct(string $stateId = null)
    {
        $this->stateId = $stateId;

        $this->table = new Table();

        // default callback to get query param
        $this->argsCallback = function ($item, $arg = null) {
            $query = $this->stateId ? $this->stateId . '_' : '';
            $default = null;

            if ($item instanceof Pagination) {
                $query .= Pagination::QUERY_PAGE;
            } elseif ($item instanceof Column) {
                $query .= Table::QUERY_SORT;
                $default = $this->table->getDefaultSort();
            } elseif (is_string($item)) {
                $query .= $item;
            }

            if ($arg) {
                return self::request()->getUri()->addQuery($query, (string) $arg)->get();
            } else {
                return self::request()->getUri()->getQuery($query) ?? $default;
            }
        };

        parent::__construct('<div>');
        $this->addClass('cawa-grid');

        $this->addClass('grid-table');
        self::translator()->addFile(__DIR__ . '/../../lang/global', 'bootstrap');

        $this->navbar = (new Navbar())
            ->setInverse();

        $this->add($this->navbar);

        $this->options = new Dropdown(
            '<i class="fa fa-adjust"></i> ' . self::trans('bootstrap.grid/options')
        );

        // refresh
        $this->options->add(new Link(
            '<i class="glyphicon glyphicon-refresh"></i> ' . self::trans('bootstrap.grid/refresh'),
            self::request()->getUri()->get()
        ));

        $ul = new HtmlContainer('<ul>');
        $ul->add($this->options->toNavbar());

        $this->navbar->add($ul);

        $this->table->setArgsCallback($this->argsCallback);
        $this->add($this->table);
    }

    /**
     * @var string
     */
    protected $stateId;

    /**
     * @var callable
     */
    private $argsCallback;

    /**
     * @var array
     */
    private $defaults = [
        self::QUERY_PAGESIZE => 25,
        self::OPTIONS_ROWSPERPAGE => [25, 50, 75, 100],
    ];

    /**
     * @param string $key
     * @param $value
     *
     * @return $this|self
     */
    public function setDefault(string $key, $value) : self
    {
        $this->defaults[$key] = $value;

        return $this;
    }

    //region Options elements

    /**
     * @return HtmlContainer
     */
    private function getRowsPerPageDropdown() : HtmlContainer
    {
        $subMenu = (new HtmlContainer('<ul>'))->addClass('dropdown-menu');
        foreach ($this->defaults[self::OPTIONS_ROWSPERPAGE] as $count) {
            $href = call_user_func($this->argsCallback, self::QUERY_PAGESIZE, $count);

            $li = (new HtmlContainer('<li>'))->add(new Link((string) $count, $href));
            if ($this->getPageSize() == $count) {
                $li->addClass('active');
            }

            $subMenu->add($li);
        }

        $rowsperpageLi = (new HtmlContainer('<li>'))
            ->addClass('dropdown-submenu')
            ->add(new Link(
                '<i class="glyphicon glyphicon-plus"></i> ' . self::trans('bootstrap.grid/perpage')
            ))
            ->add($subMenu)
        ;

        return $rowsperpageLi;
    }

    /**
     * @return HtmlContainer
     */
    private function getColumnDropdown() : HtmlContainer
    {
        $columnsVisible = [];
        foreach ($this->getTable()->getColumns() as $column) {
            if ($column->isVisible()) {
                $columnsVisible[] = $column->getId();
            }
        }

        $subMenu = (new HtmlContainer('<ul>'))->addClass('dropdown-menu');
        foreach ($this->getTable()->getColumns() as $column) {
            if (!$column->isHideable() || !$column->isRenderable()) {
                continue;
            }

            if ($column->isVisible()) {
                $checkIcon = 'fa fa-check-square-o';
                $argsCallback = implode('|', array_diff($columnsVisible, [$column->getId()]));
            } else {
                $checkIcon = 'fa fa-square-o';
                $argsCallback = implode('|', array_merge($columnsVisible, [$column->getId()]));
            }

            $href = call_user_func($this->argsCallback, Table::QUERY_COLUMNS_VISIBLE, $argsCallback);

            $finalContent = '<i class="' . $checkIcon . '"></i> ' .
                ($column->getIcon() ? '<i class="' . $column->getIcon() . '"></i> ' : '') .
                $column->getContent();

            $li = (new HtmlContainer('<li>'))->add(
                new Link($finalContent, $href)
            );

            $subMenu->add($li);
        }

        $columsLi = (new HtmlContainer('<li>'))
            ->addClass('dropdown-submenu')
            ->add(new Link('<i class="fa fa-columns"></i> ' . self::trans('bootstrap.grid/columns')))
            ->add($subMenu)
        ;

        return $columsLi;
    }

    /**
     * @var Navbar
     */
    private $navbar;

    /**
     * @return Navbar
     */
    public function getNavbar() : Navbar
    {
        return $this->navbar;
    }

    /**
     * @var Dropdown
     */
    protected $options;

    //endregion

    //region Table

    /**
     * @var Table
     */
    private $table;

    /**
     * @return Table
     */
    public function getTable() : Table
    {
        return $this->table;
    }

    //endregion

    //region Data

    /**
     * @var int
     */
    private $rowCount;

    /**
     * @return int
     */
    public function getRowCount() : int
    {
        return $this->rowCount;
    }

    /**
     * @param int $rowCount
     *
     * @return $this|self
     */
    public function setRowCount(int $rowCount) : self
    {
        $this->rowCount = $rowCount;

        return $this;
    }

    /**
     * @var callable|string|array
     */
    private $dataCallable;

    /**
     * @param callable|string|array $data
     *
     * @return $this|self
     */
    public function setDataCallable($data) : self
    {
        $this->dataCallable = $data;

        return $this;
    }

    //endregion

    //region Current user input

    /**
     * @param string $name
     * @param string $type
     * @param mixed $default
     *
     * @return null|string
     */
    public function getArgs(string $name, string $type, $default)
    {
        $var = ($this->stateId ? $this->stateId . '_' : '') . $name;

        return self::request()->getQuery($var, $type, $default);
    }

    /**
     * @return array
     */
    public function getSort()
    {
        $sortString = call_user_func($this->argsCallback, Table::QUERY_SORT);
        if ($sortString) {
            return Column::getSort($sortString);
        }

        $sort = $this->table->getDefaultSort();
        if (is_null($sort)) {
            return null;
        }

        return Column::getSort($this->table->getDefaultSort());
    }

    /**
     * @return int
     */
    public function getPage() : int
    {
        return (int) call_user_func($this->argsCallback, Pagination::QUERY_PAGE);
    }

    /**
     * @return int
     */
    public function getPageSize() : int
    {
        return (int) call_user_func($this->argsCallback, self::QUERY_PAGESIZE) ?: 25;
    }

    //endregion

    //region Filters

    /**
     * @var Form
     */
    private $filtersForm;

    /**
     * @return AbstractField[]
     */
    public function getFilters() : array
    {
        return $this->filtersForm ? $this->filtersForm->elements : [];
    }

    /**
     * @param $filter
     *
     * @return $this|self
     */
    public function addFilter(AbstractField $filter) : self
    {
        if (!$this->filtersForm) {
            $this->filtersForm = new Form();
            $this->filtersForm->setMethod('GET')
                ->setName($this->stateId ? $this->stateId : 'grid')
                ->setAction(self::request()->getUri()->get());

            $this->navbar->add($this->filtersForm);
        }

        if ($this->stateId) {
            $filter->setName($this->stateId . '_' . $filter->getName());
        }

        $this->filtersForm->add($filter);

        $this->filtersForm->setAction(
            Uri::parse($this->filtersForm->getAction())->removeQuery($filter->getName())->get()
        );

        if ($filter->getLabel() && !$filter instanceof Radio && !$filter instanceof Checkbox) {
            $filter->getLabel()->addClass('sr-only');
        }

        return $this;
    }

    //endregion

    //region Render

    /**
     * @return string
     */
    public function render()
    {
        if ($this->dataCallable) {
            $this->getTable()->setData(call_user_func($this->dataCallable, $this));
        }

        $data = $this->getTable()->getData();
        $this->getTable()->setData([]);

        /* @var Grid $clone */
        $deepcopy = new DeepCopy();
        $clone = $deepcopy->copy($this);

        $clone->getTable()->setData($data);

        return $clone->renderClone();
    }

    /**
     * @return string
     */
    private function renderClone() : string
    {
        // add columns viksiblity dropdown
        $this->options->add($this->getColumnDropdown());

        if ($this->filtersForm) {
            $this->filtersForm->add(new Submit(self::trans('bootstrap.grid/filter')));
        }

        // add pagination
        if ($this->rowCount) {
            $this->options->add($this->getRowsPerPageDropdown());

            $pagination = new Pagination((int) ceil($this->rowCount / $this->getPageSize()), $this->argsCallback);
            $this->navbar->add($pagination, false);
        }

        return parent::render();
    }

    //endregion
}
