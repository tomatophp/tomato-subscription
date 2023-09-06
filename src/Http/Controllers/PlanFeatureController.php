<?php

namespace TomatoPHP\TomatoSubscription\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use TomatoPHP\TomatoAdmin\Facade\Tomato;
use TomatoPHP\TomatoSubscription\Http\Requests\PlanFeature\PlanFeatureStoreRequest;
use TomatoPHP\TomatoSubscription\Http\Requests\PlanFeature\PlanFeatureUpdateRequest;
use TomatoPHP\TomatoSubscription\Models\PlanFeature;
use TomatoPHP\TomatoSubscription\Tables\PlanFeatureTable;


class PlanFeatureController extends Controller
{
    public string $model;

    public function __construct()
    {
        $this->model = PlanFeature::class;
    }


    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View|JsonResponse
    {
        return Tomato::index(
            request: $request,
            model: $this->model,
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
            'request' => $request,
            "model" => PlanFeature::where('is_active', 1)->get()->toArray()
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
    public function store(PlanFeatureStoreRequest $request): RedirectResponse|JsonResponse
    {
        $response = Tomato::store(
            request: $request,
            model: PlanFeature::class,
            message: trans('tomato-subscription::global.features.messages.created'),
            redirect: 'admin.plan-features.index',
        );

        if ($response instanceof JsonResponse) {
            return $response;
        }

        return $response->redirect;
    }

    /**
     * @param PlanFeature $model
     * @return View
     */
    public function show(PlanFeature $model): View|JsonResponse
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
    public function update(PlanFeatureUpdateRequest $request, PlanFeature $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::update(
            request: $request,
            model: $model,
            message: trans('tomato-subscription::global.features.messages.updated'),
            redirect: 'admin.plan-features.index',
        );

        if ($response instanceof JsonResponse) {
            return $response;
        }

        return $response->redirect;
    }

    /**
     * @param PlanFeature $model
     * @return RedirectResponse
     */
    public function destroy(PlanFeature $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::destroy(
            model: $model,
            message: trans('tomato-subscription::global.features.messages.deleted'),
            redirect: 'admin.plan-features.index',
        );

        if ($response instanceof JsonResponse) {
            return $response;
        }

        return $response->redirect;
    }
}
