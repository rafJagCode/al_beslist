<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-2">
            <div class="img-fluid rounded-start" style="display: grid; place-items: center; height: 100%">
                <i class="material-icons" style="font-size: 80px;">shopping_cart</i>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card-body">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th scope="col">Kod bvb</th>
                        <th scope="col">Tytuł</th>
                        <th scope="col">Ilość</th>
                        <th scope="col">Cena</th>
                        <th scope="col">Dostawa</th>
                        <th scope="col">Prowizja</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$products item=$product}
                        {$bvbCode=(!empty($product.bvbCode)) ? $product.bvbCode : ''}
                        {$title=(!empty($product.title)) ? $product.title : ''}
                        {$numberOrdered=(!empty($product.numberOrdered)) ? $product.numberOrdered : ''}
                        {$price=(!empty($product.price)) ? $product.price : ''}
                        {$shipping=(!empty($product.shipping)) ? $product.shipping : ''}
                        {$commission=(!empty($product.commission.total)) ? $product.commission.total : ''}
                        <tr>
                            <td>{$bvbCode}</td>
                            <td>{$title}</td>
                            <td>{$numberOrdered}</td>
                            <td>{$price}</td>
                            <td>{$shipping}</td>
                            <td>{$commission}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table
            </div>
        </div>
    </div>
</div>
</div>
