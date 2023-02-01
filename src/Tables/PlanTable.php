<?php

namespace TomatoPHP\TomatoSubscription\Tables;

use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;

class PlanTable extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return \TomatoPHP\TomatoSubscription\Models\Plan::query();
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table
            ->withGlobalSearch(label: trans('tomato-admin::global.search'),columns: ['id','name',])
            ->bulkAction(
                label: trans('tomato-admin::global.crud.delete'),
                each: fn (\TomatoPHP\TomatoSubscription\Models\Plan $model) => $model->delete(),
                after: fn () => Toast::danger(trans('tomato-subscription::global.plans.messages.deleted'))->autoDismiss(2),
                confirm: true
            )
            ->export()
            ->defaultSort('id')
            ->column(key: 'id',label: trans('tomato-subscription::global.plans.id'), sortable: true)
            ->column(key: 'name',label: trans('tomato-subscription::global.plans.name'), sortable: true)
            ->column(key: 'price',label: trans('tomato-subscription::global.plans.price'), sortable: true)
            ->column(key: 'invoice_interval',label: trans('tomato-subscription::global.plans.invoice_interval'), sortable: true)
            ->column(key: 'is_recurring',label: trans('tomato-subscription::global.plans.is_recurring'), sortable: true)
            ->column(key: 'is_active',label: trans('tomato-subscription::global.plans.is_active'), sortable: true)
            ->column(key: 'is_free',label: trans('tomato-subscription::global.plans.is_free'), sortable: true)
            ->column(key: 'is_default',label: trans('tomato-subscription::global.plans.is_default'), sortable: true)
            ->column(key: 'actions',label: trans('tomato-admin::global.crud.actions'))
            ->paginate(15);
    }
}
