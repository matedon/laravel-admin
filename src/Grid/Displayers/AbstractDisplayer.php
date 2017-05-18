<?php

namespace MAteDon\Admin\Grid\Displayers;

use MAteDon\Admin\Grid;
use MAteDon\Admin\Grid\Column;

abstract class AbstractDisplayer
{
    /**
     * @var Grid
     */
    protected $grid;

    /**
     * @var Column
     */
    protected $column;

    /**
     * @var \stdClass
     */
    public $row;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * Variable to store JavaScript dataset.
     * jQuery.data();
     *
     * @var array
     */
    protected $dataSet = [];

    /**
     * Create a new displayer instance.
     *
     * @param mixed $value
     * @param Grid $grid
     * @param Column $column
     * @param \stdClass $row
     */
    public function __construct($value, Grid $grid, Column $column, $row)
    {
        $this->value = $value;
        $this->grid = $grid;
        $this->column = $column;
        $this->row = $row;
    }

    /**
     * Get key of current row.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->row->{$this->grid->getKeyName()};
    }

    /**
     * Get url path of current resource.
     *
     * @return string
     */
    public function getResource()
    {
        return $this->grid->resource();
    }

    /**
     * @param array $dataSet
     */
    public function setDataSet($dataSet)
    {
        $this->dataSet = $dataSet;
    }

    /**
     * @return array
     */
    public function getDataSetJson()
    {
        return json_encode($this->dataSet);
    }

    /**
     * Get translation.
     *
     * @param string $text
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function trans($text)
    {
        return trans("admin::lang.$text");
    }

    /**
     * Display method.
     *
     * @return mixed
     */
    abstract public function display();
}
