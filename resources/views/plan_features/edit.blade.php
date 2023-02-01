<x-splade-modal class="font-main">
    <h1 class="text-2xl font-bold mb-4">{{trans('tomato-admin::global.crud.edit')}} {{trans('tomato-subscription::global.features.single')}} #{{$model->id}}</h1>

    <x-splade-form class="flex flex-col space-y-4" action="{{route('admin.plan-features.update', $model->id)}}" method="post" :default="$model">

        <x-splade-input name="name.ar" type="text" label="{{trans('tomato-subscription::global.features.name')}} [{{trans('tomato-subscription::global.lang.ar')}}]"  placeholder="{{trans('tomato-subscription::global.features.name')}} [{{trans('tomato-subscription::global.lang.ar')}}]" />
        <x-splade-input name="name.en" type="text" label="{{trans('tomato-subscription::global.features.name')}} [{{trans('tomato-subscription::global.lang.en')}}]"  placeholder="{{trans('tomato-subscription::global.features.name')}} [{{trans('tomato-subscription::global.lang.en')}}]" />
        <x-splade-textarea name="description.ar" label="{{trans('tomato-subscription::global.features.description')}} [{{trans('tomato-subscription::global.lang.ar')}}]" placeholder="{{trans('tomato-subscription::global.features.description')}} [{{trans('tomato-subscription::global.lang.ar')}}]" autosize />
        <x-splade-textarea name="description.en" label="{{trans('tomato-subscription::global.features.description')}} [{{trans('tomato-subscription::global.lang.en')}}]" placeholder="{{trans('tomato-subscription::global.features.description')}} [{{trans('tomato-subscription::global.lang.en')}}]" autosize />

        <x-splade-select  name="key" label="{{trans('tomato-subscription::global.features.key')}}" placeholder="{{trans('tomato-subscription::global.features.key')}}" choices>
            @foreach(Route::getRoutes() as $route)
                @if(isset($route->action['as'])))
                <option value="{{$route->action['as']}}">{{$route->uri}}</option>
                @endif
            @endforeach
        </x-splade-select>
        <x-splade-input name="value" type="number"   label="{{trans('tomato-subscription::global.features.value')}}" placeholder="{{trans('tomato-subscription::global.features.value')}}" />

        <x-splade-checkbox name="is_active" label="{{trans('tomato-subscription::global.features.is_active')}}" />

        <x-splade-submit label="{{trans('tomato-admin::global.crud.update')}} {{trans('tomato-subscription::global.features.single')}}" :spinner="true" />
    </x-splade-form>
</x-splade-modal>
