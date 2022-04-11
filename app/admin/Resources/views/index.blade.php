@extends('panel::layouts.master')

@section('content')

    @if($category_count == 1)
        <div class="alert alert-info" role="alert">
            <h2 class="h4">Getting started?</h2>
            <ul>
                <li>Start off by adding some <a href="/panel/categories" class="alert-link">categories</a></li>
                <li>Customize the <a href="/panel/settings" class="alert-link">settings</a> of your website</a></li>
                <li>Perhaps even add a few <a href="/" class="alert-link">listings</a></li>
                <li>Add your <a href="/panel/settings" class="alert-link">stripe keys</a> to start earning</li>
                <li>Tell the world!</li>
            </ul>
        </div>
    @endif
    <h1 class="h3">Welcome {{auth()->user()->name}},</h1>
    <h2 class="h5">What would you like to do today?</h2>
    <br />
    <br />

    <div class="row">

        <div class="col-md-6 mb-3">

            <div class="row">

                <div class="col-md-2">
                    <img src="data:image/png;base64,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" style="width: 48px" />
                </div>
                <div class="col-md-8">


                    <ul class="list-unstyled">
                        <li class="pb-1"><a href="#" class="text-muted font-weight-bold">Listings & Categories</a></li>
                        <li class="pb-1"><a href="/panel/listings">View Listings</a></li>
                        <li class="pb-1"><a href="/panel">Post new listing</a></li>
                        <li class="pb-1"><a href="/panel/categories">View category listing</a></li>
                        <li class="pb-1"><a href="/panel/categories/create">Create new category</a></li>
                    </ul>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-3">

            <div class="row">

                <div class="col-md-2">
                    <img src="data:image/png;base64,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" style="width: 48px" />
                </div>
                <div class="col-md-8">


                    <ul class="list-unstyled">
                        <li class="pb-1"><a href="#articles" class="text-muted font-weight-bold">Users &amp; Orders</a></li>
                        <li class="pb-1"><a href="/panel/users">View Buyers &amp; Sellers</a></li>
                        <li class="pb-1"><a href="/panel/orders">View Orders</a></li>
                    </ul>

                </div>

            </div>

        </div>

{{--        <div class="col-md-6 mb-3">--}}

{{--            <div class="row">--}}

{{--                <div class="col-md-2">--}}
{{--                    <img src="/images/admin/categories.png" style="width: 48px" />--}}
{{--                </div>--}}
{{--                <div class="col-md-8">--}}


{{--                    <ul class="list-unstyled">--}}
{{--                        <li class="pb-1"><a href="#articles" class="text-muted font-weight-bold">Content</a></li>--}}
{{--                        <li class="pb-1"><a href="/panel/pages">Manage pages</a></li>--}}
{{--                        <li class="pb-1"><a href="/panel/menu">Manage menu</a></li>--}}
{{--                    </ul>--}}

{{--                </div>--}}

{{--            </div>--}}

{{--        </div>--}}

{{--        <div class="col-md-6 mb-3">--}}

{{--            <div class="row">--}}

{{--                <div class="col-md-2">--}}
{{--                    <img src="/images/admin/design.png" style="width: 48px" />--}}
{{--                </div>--}}
{{--                <div class="col-md-8">--}}


{{--                    <ul class="list-unstyled">--}}
{{--                        <li class="pb-1"><a href="#articles" class="text-muted font-weight-bold">Design</a></li>--}}
{{--                        @if(module_enabled('homepage'))--}}
{{--                        <li class="pb-1"><a href="/panel/addons/homepage">Customize homepage</a></li>--}}
{{--                        @endif--}}
{{--                        <li class="pb-1"><a href="/panel/themes">Themes &amp; CSS</a></li>--}}
{{--                    </ul>--}}

{{--                </div>--}}

{{--            </div>--}}

{{--        </div>--}}

{{--        <div class="col-md-6 mb-3">--}}

{{--            <div class="row">--}}

{{--                <div class="col-md-2">--}}
{{--                    <img src="/images/admin/config.png" style="width: 48px" />--}}
{{--                </div>--}}
{{--                <div class="col-md-8">--}}


{{--                    <ul class="list-unstyled">--}}
{{--                        <li class="pb-1"><a href="#articles" class="text-muted font-weight-bold">Settings</a></li>--}}
{{--                        <li class="pb-1"><a href="/panel/settings">General settings</a></li>--}}
{{--                        <li class="pb-1"><a href="/panel/fields">Fields &amp; filters</a></li>--}}
{{--                        <li class="pb-1"><a href="/panel/pricing-models">Pricing models</a></li>--}}
{{--                    </ul>--}}

{{--                </div>--}}

{{--            </div>--}}

{{--        </div>--}}

    </div>


@stop
