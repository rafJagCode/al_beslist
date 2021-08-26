<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<table class="table">
    <thead>
    <tr>
        <th scope="col">EAN13</th>
        <th scope="col">Id Produktu</th>
        <th scope="col">Referencja</th>
        <th scope="col">Ilość</th>
        <th scope="col">Cena</th>
        <th scope="col">Data Aktualizacji</th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$changedProducts item=$product}
        <tr>
            <td>{$product.ean13}</td>
            <td>{$product.id_product}</td>
            <td>{$product.reference}</td>
            <td>{$product.quantity}</td>
            <td>{$product.price}</td>
            <td>{$product.updated}</td>
        </tr>
    {/foreach}
    </tbody>
</table>

<nav aria-label="...">
    <ul class="pagination pagination-sm">
        {for $i=1 to $pagination->pages }
            <li class="page-item {if $page == $i }disabled{/if}"><a class="page-link" href="{$controller_link}&page={$i}">{$i}</a></li>
        {/for}
    </ul>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
