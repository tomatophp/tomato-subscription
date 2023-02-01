<?php

namespace TomatoPHP\TomatoSubscription\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use TomatoPHP\TomatoSubscription\Http\Requests\PlanSubscription\PlanSubscriptionStoreRequest;
use TomatoPHP\TomatoSubscription\Http\Requests\PlanSubscription\PlanSubscriptionUpdateRequest;
use TomatoPHP\TomatoSubscription\Models\Plan;
use TomatoPHP\TomatoSubscription\Models\PlanSubscription;
use ProtoneMedia\Splade\Facades\Toast;
use TomatoPHP\TomatoPHP\Services\Tomato;
use TomatoPHP\TomatoSubscription\Tables\PlanSubscriptionTable;

class PlanSubscriptionController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return Tomato::index(
            request: $request,
            view: 'tomato-subscription::plan_subscription.index',
            table: PlanSubscriptionTable::class,
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function api(Request $request): JsonResponse
    {
        return Tomato::json(
            request: $request,
            model: PlanSubscription::class,
        );
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return Tomato::create(
            view: 'tomato-subscription::plan_subscription.create',
        );
    }

    /**
     * @param PlanSubscriptionStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PlanSubscriptionStoreRequest $request): RedirectResponse
    {
        foreach(config('tomato-subscription.types') as $key=>$item){
            if($key===(int)$request->get('model_type')){
                $request->merge([
                   "model_type"  => $item['id']
                ]);
            }
        }
        $check = PlanSubscription::where('model_type', $request->get('model_type'))
            ->where('model_id', $request->get('model_id'))->first();

        if($check){
            Toast::danger(trans('tomato-subscription::global.subscription.messages.not'))->autoDismiss(2);
            return back();
        }

        $plan = Plan::find($request->get('plan_id'));
        if($plan->invoice_period === 'day'){
            $request->merge([
                "starts_at"  => Carbon::now(),
                "ends_at"  => Carbon::now()->addDays($plan->invoice_interval),
            ]);
        }
        else if($plan->invoice_period === 'month'){
            $request->merge([
                "starts_at"  => Carbon::now(),
                "ends_at"  => Carbon::now()->addMonth($plan->invoice_interval),
            ]);
        }
        else if($plan->invoice_period === 'year'){
            $request->merge([
                "starts_at"  => Carbon::now(),
                "ends_at"  => Carbon::now()->addYear($plan->invoice_interval),
            ]);
        }

        $response = Tomato::store(
            request: $request,
            model: PlanSubscription::class,
            message: trans('tomato-subscription::global.subscription.messages.created'),
            redirect: 'admin.plan-subscription.index',
        );

        return $response['redirect'];
    }

    /**
     * @param PlanSubscription $model
     * @return View
     */
    public function show(PlanSubscription $model): View
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-subscription::plan_subscription.show',
        );
    }

    /**
     * @param PlanSubscription $model
     * @return View
     */
    public function edit(PlanSubscription $model): View
    {
        foreach(config('tomato-subscription.types') as $key=>$item){
            if($item['id']===$model->model_type){
                $model->model_type = $key;
            }
        }
        $model->plan;
        return Tomato::get(
            model: $model,
            view: 'tomato-subscription::plan_subscription.edit',
        );
    }

    /**
     * @param PlanSubscriptionUpdateRequest $request
     * @param PlanSubscription $model
     * @return RedirectResponse
     */
    public function update(PlanSubscriptionUpdateRequest $request, PlanSubscription $model): RedirectResponse
    {
        foreach(config('tomato-subscription.types') as $key=>$item){
            if($key===(int)$request->get('model_type')){
                $request->merge([
                    "model_type"  => $item['id']
                ]);
            }
        }

        if((int)$request->get('plan_id') !== $model->plan_id){
            $check = PlanSubscription::where('model_type', $request->get('model_type'))
                ->where('model_id', $request->get('model_id'))->first();

            if($check){
                Toast::danger(trans('tomato-subscription::global.subscription.messages.not'))->autoDismiss(2);
                return back();
            }

            $plan = Plan::find($request->get('plan_id'));
            if($plan->invoice_period === 'day'){
                $request->merge([
                    "starts_at"  => Carbon::now(),
                    "ends_at"  => Carbon::now()->addDays($plan->invoice_interval),
                ]);
            }
            else if($plan->invoice_period === 'month'){
                $request->merge([
                    "starts_at"  => Carbon::now(),
                    "ends_at"  => Carbon::now()->addMonth($plan->invoice_interval),
                ]);
            }
            else if($plan->invoice_period === 'year'){
                $request->merge([
                    "starts_at"  => Carbon::now(),
                    "ends_at"  => Carbon::now()->addYear($plan->invoice_interval),
                ]);
            }
        }

        $response = Tomato::update(
            request: $request,
            model: $model,
            message: trans('tomato-subscription::global.subscription.messages.updated'),
            redirect: 'admin.plan-subscription.index',
        );

        return $response['redirect'];
    }

    /**
     * @param PlanSubscription $model
     * @return RedirectResponse
     */
    public function destroy(PlanSubscription $model): RedirectResponse
    {
        return Tomato::destroy(
            model: $model,
            message: trans('tomato-subscription::global.subscription.messages.deleted'),
            redirect: 'admin.plan-subscription.index',
        );
    }
}
