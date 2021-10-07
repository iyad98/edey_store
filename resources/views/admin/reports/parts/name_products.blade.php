<table>



	@foreach($order_products as $order_product)
		<tr>
			<td>
			 <span class="m-nav__link-badge">
			<span class="m-badge m-badge--default m-badge--wide m-badge--rounded" style="margin: 5px;">
				{{$order_product->product_variation ? $order_product->product_variation->product->name : ''}}
			</span>
</span>
			</td>
		</tr>

	@endforeach

</table>