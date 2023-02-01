<?php

namespace TomatoPHP\TomatoSubscription\Tables;

use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;

class PlanSubscriptionTable extends AbstractTable
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
        return \TomatoPHP\TomatoSubscription\Models\PlanSubscription::query();
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
            ->withGlobalSearch(label: trans('tomato-admin::global.search'),columns: ['id',])
            ->bulkAction(
                label: trans('tomato-admin::global.crud.delete'),
                each: fn (\TomatoPHP\TomatoSubscription\Models\PlanSubscription $model) => $model->delete(),
                after: fn () => Toast::danger(trans('tomato-subscription::global.subscription.messages.deleted'))->autoDismiss(2),
                confirm: true
            )
            ->export()
            ->defaultSort('id')
            ->column(key: 'id',label: trans('tomato-subscription::global.subscription.id'), sortable: true)
            ->column(key: 'subscriber.name',label: trans('tomato-subscription::global.subscription.subscriber'), sortable: true)
            ->column(key: 'plan.name',label: trans('tomato-subscription::global.subscription.plan_id'), sortable: true)
            ->column(key: 'status',label: trans('tomato-subscription::global.subscription.status'), sortable: true)
            ->column(key: 'is_current', label: trans('tomato-subscription::global.subscription.is_current'),sortable: true)
            ->column(key: 'actions',label: trans('tomato-admin::global.crud.actions'))
            ->paginate(15);
    }
}
