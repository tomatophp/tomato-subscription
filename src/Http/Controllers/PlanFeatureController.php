<?php

namespace TomatoPHP\TomatoSubscription\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use TomatoPHP\TomatoSubscription\Http\Requests\PlanFeature\PlanFeatureStoreRequest;
use TomatoPHP\TomatoSubscription\Http\Requests\PlanFeature\PlanFeatureUpdateRequest;
use TomatoPHP\TomatoSubscription\Models\PlanFeature;
use TomatoPHP\TomatoPHP\Services\Tomato;
use TomatoPHP\TomatoSubscription\Tables\PlanFeatureTable;

class PlanFeatureController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return Tomato::index(
            request: $request,
            view: 'tomato-subscription::plan_features.index',
            table: PlanFeatureTable::class,
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function api(Request $request): JsonResponse
    {
        return response()->json([
            "model"=> PlanFeature::where('is_active', 1)->get()->toArray()
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return Tomato::create(
            view: 'tomato-subscription::plan_features.create',
        );
    }

    /**
     * @param PlanFeatureStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PlanFeatureStoreRequest $request): RedirectResponse
    {
        $response = Tomato::store(
            request: $request,
            model: PlanFeature::class,
            message: trans('tomato-subscription::global.features.messages.created'),
            redirect: 'admin.plan-features.index',
        );

        return $response['redirect'];
    }

    /**
     * @param PlanFeature $model
     * @return View
     */
    public function show(PlanFeature $model): View
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-subscription::plan_features.show',
        );
    }

    /**
     * @param PlanFeature $model
     * @return View
     */
    public function edit(PlanFeature $model): View
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-subscription::plan_features.edit',
        );
    }

    /**
     * @param PlanFeatureUpdateRequest $request
     * @param PlanFeature $model
     * @return RedirectResponse
     */
    public function update(PlanFeatureUpdateRequest $request, PlanFeature $model): RedirectResponse
    {
        $response = Tomato::update(
            request: $request,
            model: $model,
            message: trans('tomato-subscription::global.features.messages.updated'),
            redirect: 'admin.plan-features.index',
        );

        return $response['redirect'];
    }

    /**
     * @param PlanFeature $model
     * @return RedirectResponse
     */
    public function destroy(PlanFeature $model): RedirectResponse
    {
        return Tomato::destroy(
            model: $model,
            message: trans('tomato-subscription::global.features.messages.deleted'),
            redirect: 'admin.plan-features.index',
        );
    }
}
