<?php

namespace TomatoPHP\TomatoSubscription\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use TomatoPHP\TomatoPHP\Services\Tomato;
use TomatoPHP\TomatoSubscription\Http\Requests\Plan\PlanStoreRequest;
use TomatoPHP\TomatoSubscription\Http\Requests\Plan\PlanUpdateRequest;
use TomatoPHP\TomatoSubscription\Models\Plan;
use TomatoPHP\TomatoSubscription\Tables\PlanTable;

class PlanController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return Tomato::index(
            request: $request,
            view: 'tomato-subscription::plans.index',
            table: PlanTable::class,
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
            model: Plan::class,
        );
    }


    /**
     * @param Request $request
     * @param $type
     * @return JsonResponse
     */
    public function type(Request $request, $type): JsonResponse
    {
        foreach(config('tomato-subscription.types') as $key=>$item){
            if($key===(int)$type){
                return response()->json([
                    "model" => $item['id']::all()
                ]);
            }
        }

        return response()->json([
            "model" => []
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return Tomato::create(
            view: 'tomato-subscription::plans.create',
        );
    }

    /**
     * @param PlanStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PlanStoreRequest $request): RedirectResponse
    {
        $response = Tomato::store(
            request: $request,
            model: Plan::class,
            message: trans('tomato-subscription::global.plans.messages.created'),
            redirect: 'admin.plans.index',
        );

        return $response['redirect'];
    }

    /**
     * @param Plan $model
     * @return View
     */
    public function show(Plan $model): View
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-subscription::plans.show',
        );
    }

    /**
     * @param Plan $model
     * @return View
     */
    public function edit(Plan $model): View
    {
        $model->features = $model->features->map(static fn($item) => [
            "feature" => $item->id,
            "value" => $item->value
        ]);
        return Tomato::get(

            model: $model,
            view: 'tomato-subscription::plans.edit',
        );
    }

    /**
     * @param PlanUpdateRequest $request
     * @param Plan $model
     * @return RedirectResponse
     */
    public function update(PlanUpdateRequest $request, Plan $model): RedirectResponse
    {
        $response = Tomato::update(
            request: $request,
            model: $model,
            message: trans('tomato-subscription::global.plans.messages.updated'),
            redirect: 'admin.plans.index',
        );

        $featureArray = [];
        if($request->has('features') && count($request->get('features'))){
            foreach($request->get('features') as $feature){
                $featureArray[$feature['feature']] = ["value"=> $feature['value']];
            }
        }


        $response['record']->features()->sync($featureArray);


        return $response['redirect'];
    }

    /**
     * @param Plan $model
     * @return RedirectResponse
     */
    public function destroy(Plan $model): RedirectResponse
    {
        return Tomato::destroy(
            model: $model,
            message: trans('tomato-subscription::global.plans.messages.deleted'),
            redirect: 'admin.plans.index',
        );
    }
}
