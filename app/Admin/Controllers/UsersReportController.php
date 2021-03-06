<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\UsersReport;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Artisan;

class UsersReportController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        Artisan::call('users:report');
        return Grid::make(new UsersReport(), function (Grid $grid) {
            $grid->model()->Addtime($grid->getRequestInput('addtime'));
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('deposit')->sortable();
            $grid->column('withdrawal')->sortable();
            $grid->column('bottom_pour')->sortable();
            $grid->column('bonus')->sortable();
            $grid->column('yingkui')->display(function(){
                return $this->bottom_pour - $this->bonus;
            });
            $grid->column('rebates')->sortable();
            $grid->column('activity')->sortable();
            $grid->column('addtime');
            $grid->disableActions();
            $grid->export();
            $grid->disableCreateButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('user_id');
                $filter->equal('addtime')->date();
            });
        });

    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new UsersReport(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('deposit');
            $show->field('withdrawal');
            $show->field('bottom_pour');
            $show->field('bonus');
            $show->field('rebates');
            $show->field('activity');
            $show->field('addtime');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new UsersReport(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('deposit');
            $form->text('withdrawal');
            $form->text('bonus');
            $form->text('bottom_pour');
            $form->text('rebates');
            $form->text('activity');
            $form->text('addtime');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
