<span class="m-nav__link-badge">
			<span class="m-badge {{$order_bank_status == 1 ? "m-badge--primary": "m-badge--danger"}}  m-badge--wide m-badge--rounded" style="margin: 5px;">
				{{$order_bank_status_text}}

			</span>
		</span>
<br>
<p style="padding-right: 10px;">
	{{isset($reject_reason) ? $reject_reason : ""}}
</p>