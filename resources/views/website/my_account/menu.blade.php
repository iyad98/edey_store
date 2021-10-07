<nav class="woocommerce-MyAccount-navigation">
    <ul>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard">
            <a href="{{LaravelLocalization::localizeUrl('/')}}">{{trans('website.home')}}</a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders {{isset($menu) && $menu =='orders'  ? 'is-active' : '' }}">
            <a href="{{LaravelLocalization::localizeUrl('my-account/orders')}}">{{trans('website.orders')}}</a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address {{isset($menu) && $menu =='address'  ? 'is-active' : '' }}">
            <a href="{{LaravelLocalization::localizeUrl('my-account/edit-address')}}">{{trans('website.addresses')}}</a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account {{isset($menu) && $menu =='myaccount'  ? 'is-active' : '' }}">
            <a href="{{LaravelLocalization::localizeUrl('my-account')}}">{{trans('website.account_details')}}</a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account {{isset($menu) && $menu =='coupons'  ? 'is-active' : '' }}">
            <a href="{{LaravelLocalization::localizeUrl('my-account/coupons')}}">{{trans('website.coupons')}}</a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
            <a href="{{LaravelLocalization::localizeUrl('website/logout')}}">{{trans('website.logout')}}</a>
        </li>
    </ul>
</nav>