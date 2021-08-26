<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
{*<pre>*}
{*    {"<?php\n\$data =\n"|@cat:{$orders|@var_export:true|@cat:";\n?>"}|@highlight_string:true}*}
{*</pre>*}
<table class="table">
    <thead>
        <tr>
            <th scope="col">Nr Zamówienia</th>
            <th scope="col">Koszt Produktów</th>
            <th scope="col">Data</th>
            <th scope="col">Szczegóły</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$orders item=$order}
                <tr class="amelenbeslist__order" data-controller_link="{$controller_link}" data-order="{$order|@json_encode|escape}">
                    <td>{$order.orderNumber}</td>
                    <td>{$order.price}</td>
                    <td>{$order.dateCreated}</td>
                    <td>
                        <a href="{$controller_link}&action=SHOW_ORDER_DETAILS&order={$order|@json_encode|escape}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
            </a>
        {/foreach}
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
