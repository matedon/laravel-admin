<?php

namespace MAteDon\Admin\Controllers;

use MAteDon\Admin\Auth\Database\Menu;
use MAteDon\Admin\Auth\Database\Role;
use MAteDon\Admin\Facades\Admin;
use MAteDon\Admin\Form;
use MAteDon\Admin\Layout\Column;
use MAteDon\Admin\Layout\Content;
use MAteDon\Admin\Layout\Row;
use MAteDon\Admin\Tree;
use MAteDon\Admin\Widgets\Box;
use Illuminate\Routing\Controller;

class MenuController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header(trans('admin::lang.menu'));
            $content->description(trans('admin::lang.list'));

            $content->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \MAteDon\Admin\Widgets\Form();
                    $form->action(admin_url('auth/menu'));

                    $form
                        ->select('parent_id', trans('admin::lang.parent_id'))
                        ->options(Menu::selectOptions());
                    $form
                        ->text('title', trans('admin::lang.title'))
                        ->rules('required');
                    $form
                        ->icon('icon', trans('admin::lang.icon'))
                        ->default('fa-bars')->rules('required')
                        ->help($this->iconHelp());
                    $form
                        ->text('uri', trans('admin::lang.uri'));
                    $form
                        ->multipleSelect('roles', trans('admin::lang.roles'))
                        ->options(Role::all()->pluck('name', 'id'));

                    $column->append((new Box(trans('admin::lang.new'), $form))->style('success'));
                });
            });
        });
    }

    /**
     * Redirect to edit page.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return redirect()->action(
            '\MAteDon\Admin\Controllers\MenuController@edit', ['id' => $id]
        );
    }

    /**
     * @return \MAteDon\Admin\Tree
     */
    protected function treeView()
    {
        return Menu::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                return view('admin::menu.line', [
                    'branch' => $branch
                ])->render();
            });
        });
    }

    /**
     * Edit interface.
     *
     * @param string $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header(trans('admin::lang.menu'));
            $content->description(trans('admin::lang.edit'));

            $content->row($this->form()->edit($id));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        return Menu::form(function (Form $form) {
            $form->id('id', 'ID');

            $form
                ->select('parent_id', trans('admin::lang.parent_id'))
                ->options(Menu::selectOptions());
            $form
                ->text('title', trans('admin::lang.title'))
                ->rules('required');
            $form
                ->icon('icon', trans('admin::lang.icon'))
                ->default('fa-bars')
                ->rules('required')
                ->help($this->iconHelp());
            $form
                ->text('uri', trans('admin::lang.uri'));
            $form
                ->multipleSelect('roles', trans('admin::lang.roles'))
                ->options(Role::all()->pluck('name', 'id'));

            $form->timestamp('created_at', trans('admin::lang.created_at'));
            $form->timestamp('updated_at', trans('admin::lang.updated_at'));
        });
    }

    /**
     * Help message for icon field.
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
    }
}
