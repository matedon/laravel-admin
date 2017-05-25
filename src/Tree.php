<?php

namespace MAteDon\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;

class Tree implements Renderable
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var string
     */
    protected $elementId = 'tree-';

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var \Closure
     */
    protected $queryCallback;

    /**
     * View of tree to render.
     *
     * @var string
     */
    protected $view = [
        'tree'   => 'admin::menu.tree',
        'branch' => 'admin::menu.branch',
    ];

    /**
     * @var \Closure
     */
    protected $callback;

    /**
     * @var null
     */
    protected $branchCallback = null;

    /**
     * @var bool
     */
    public $useCreate = true;

    /**
     * @var array
     */
    protected $nestableOptions = [];

    /**
     * Menu constructor.
     *
     * @param Model|null $model
     */
    public function __construct(Model $model = null, \Closure $callback = null)
    {
        $this->model = $model;

        $this->path = app('request')->getPathInfo();
        $this->elementId .= uniqid();

        if ($callback instanceof \Closure) {
            call_user_func($callback, $this);
        }

        $this->initBranchCallback();
    }

    /**
     * Initialize branch callback.
     *
     * @return void
     */
    protected function initBranchCallback()
    {
        if (is_null($this->branchCallback)) {
            $this->branchCallback = function ($branch) {
                $key = $branch[$this->model->getKeyName()];
                $title = $branch[$this->model->getTitleColumn()];

                return "$key - $title";
            };
        }
    }

    /**
     * Set branch callback.
     *
     * @param \Closure $branchCallback
     *
     * @return $this
     */
    public function branch(\Closure $branchCallback)
    {
        $this->branchCallback = $branchCallback;

        return $this;
    }

    /**
     * Set query callback this tree.
     *
     * @return Model
     */
    public function query(\Closure $callback)
    {
        $this->queryCallback = $callback;

        return $this;
    }

    /**
     * Set nestable options.
     *
     * @param array $options
     *
     * @return $this
     */
    public function nestable($options = [])
    {
        $this->nestableOptions = array_merge($this->nestableOptions, $options);

        return $this;
    }

    /**
     * Disable create.
     *
     * @return void
     */
    public function disableCreate()
    {
        $this->useCreate = false;
    }

    /**
     * Save tree order from a input.
     *
     * @param string $serialize
     *
     * @return bool
     */
    public function saveOrder($serialize)
    {
        $tree = json_decode($serialize, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        $this->model->saveOrder($tree);

        return true;
    }

    /**
     * Set view of tree.
     *
     * @param string $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * Return all items of the tree.
     *
     * @param array $items
     */
    public function getItems()
    {
        return $this->model->withQuery($this->queryCallback)->toTree();
    }

    /**
     * Variables in tree template.
     *
     * @return array
     */
    public function variables()
    {
        $variables = [
            'id'        => $this->elementId,
            'items'     => $this->getItems(),
            'useCreate' => $this->useCreate,
            'dataSet'   => json_encode([
                'path'     => $this->path,
                'messages' => [
                    'confirm' => trans('admin::lang.delete_confirm'),
                    'save'    => trans('admin::lang.save_succeeded'),
                    'refresh' => trans('admin::lang.refresh_succeeded'),
                    'delete'  => trans('admin::lang.delete_succeeded'),
                ]
            ])
        ];
        if (!empty($this->nestableOptions)) {
            $variables['dataSet']['nestable'] = $this->nestableOptions;
        }
        return $variables;
    }

    /**
     * Render a tree.
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function render()
    {
        view()->share([
            'path'           => $this->path,
            'keyName'        => $this->model->getKeyName(),
            'branchView'     => $this->view['branch'],
            'branchCallback' => $this->branchCallback,
        ]);

        return view($this->view['tree'], $this->variables())->render();
    }

    /**
     * Get the string contents of the grid view.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
