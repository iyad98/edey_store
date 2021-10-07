{{--
<span class="m-nav__link-badge">
			<span class="m-badge {{order_status_class()[$status]}} m-badge--wide m-badge--rounded" style="margin: 5px;">
				{{trans_order_status()[$status]}}
			</span>
		</span>

--}}

<mark class="order-status {{order_status_class()[$status]}}"><span>
		{{trans_orignal_order_status()[$status]}}
	</span>
</mark>
