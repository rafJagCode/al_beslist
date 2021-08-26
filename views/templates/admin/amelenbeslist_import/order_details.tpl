<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

{$customer = $order.customer}
{$shipping_address = $order.addresses.shipping}
{$products = $order.products.product}
{$payment = $order.payment}

{include file="./_partials/general_info.tpl"}
{include file="./_partials/customer.tpl"}
{include file="./_partials/shipping.tpl"}
{include file="./_partials/payment.tpl"}
{include file="./_partials/products.tpl"}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
