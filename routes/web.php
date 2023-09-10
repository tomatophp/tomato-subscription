<?php

use Illuminate\Support\Facades\Route;
use TomatoPHP\TomatoSubscription\Http\Controllers\PlanController;
use TomatoPHP\TomatoSubscription\Http\Controllers\PlanFeatureController;
use TomatoPHP\TomatoSubscription\Http\Controllers\PlanSubscriptionController;

Route::middleware([
    'web',
    'splade',
    'verified'
])
    ->name('admin.')
    ->group(static function () {
    Route::get('admin/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('admin/plans/api', [PlanController::class, 'api'])->name('plans.api');
    Route::get('admin/plans/{type}/api', [PlanController::class, 'type'])->name('plans.type');
    Route::get('admin/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('admin/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::get('admin/plans/{model}', [PlanController::class, 'show'])->name('plans.show');
    Route::get('admin/plans/{model}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::post('admin/plans/{model}', [PlanController::class, 'update'])->name('plans.update');
    Route::delete('admin/plans/{model}', [PlanController::class, 'destroy'])->name('plans.destroy');
});

Route::middleware(['web', 'splade', 'verified'])->name('admin.')->group(function () {
    Route::get('admin/plan-features', [PlanFeatureController::class, 'index'])->name('plan-features.index');
    Route::get('admin/plan-features/api', [PlanFeatureController::class, 'api'])->name('plan-features.api');
    Route::get('admin/plan-features/create', [PlanFeatureController::class, 'create'])->name('plan-features.create');
    Route::post('admin/plan-features', [PlanFeatureController::class, 'store'])->name('plan-features.store');
    Route::get('admin/plan-features/{model}', [PlanFeatureController::class, 'show'])->name('plan-features.show');
    Route::get('admin/plan-features/{model}/edit', [PlanFeatureController::class, 'edit'])->name('plan-features.edit');
    Route::post('admin/plan-features/{model}', [PlanFeatureController::class, 'update'])->name('plan-features.update');
    Route::delete('admin/plan-features/{model}', [PlanFeatureController::class, 'destroy'])->name('plan-features.destroy');
});

Route::middleware(['web', 'splade', 'verified'])->name('admin.')->group(function () {
    Route::get('admin/plan-subscription', [PlanSubscriptionController::class, 'index'])->name('plan-subscription.index');
    Route::get('admin/plan-subscription/api', [PlanSubscriptionController::class, 'api'])->name('plan-subscription.api');
    Route::get('admin/plan-subscription/create', [PlanSubscriptionController::class, 'create'])->name('plan-subscription.create');
    Route::post('admin/plan-subscription', [PlanSubscriptionController::class, 'store'])->name('plan-subscription.store');
    Route::get('admin/plan-subscription/{model}', [PlanSubscriptionController::class, 'show'])->name('plan-subscription.show');
    Route::get('admin/plan-subscription/{model}/edit', [PlanSubscriptionController::class, 'edit'])->name('plan-subscription.edit');
    Route::post('admin/plan-subscription/{model}', [PlanSubscriptionController::class, 'update'])->name('plan-subscription.update');
    Route::delete('admin/plan-subscription/{model}', [PlanSubscriptionController::class, 'destroy'])->name('plan-subscription.destroy');
});

Route::get('/api/plans', [PlanController::class, 'index']);
