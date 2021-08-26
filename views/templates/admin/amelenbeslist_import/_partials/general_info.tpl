{$orderNumber=(!empty($order.orderNumber)) ? $order.orderNumber : ''}
{$shopOrderNumber=(!empty($order.shopOrderNumber)) ? $order.shopOrderNumber : ''}
{$dateCreated=(!empty($order.dateCreated)) ? $order.dateCreated : ''}
{$price=(!empty($order.price)) ? $order.price : ''}
{$shipping=(!empty($order.shipping)) ? $order.shipping : ''}
{$transactionCosts=(!empty($order.transactionCosts)) ? $order.transactionCosts : ''}
{$commission=(!empty($order.commission)) ? $order.commission : ''}
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-2">
            <div class="img-fluid rounded-start" style="display: grid; place-items: center; height: 100%">
                <i class="material-icons" style="font-size: 80px;">info</i>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card-body">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th scope="col">Numer Zamówienia</th>
                        <th scope="col">Numer Zamówienia - Sklep</th>
                        <th scope="col">Koszt Produktów</th>
                        <th scope="col">Dostawa</th>
                        <th scope="col">Koszt Transakcji</th>
                        <th scope="col">Prowizja</th>
                        <th scope="col">Data Utworzenia</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{$orderNumber}</td>
                        <td>{$shopOrderNumber}</td>
                        <td>{$price}</td>
                        <td>{$shipping}</td>
                        <td>{$transactionCosts}</td>
                        <td>{$commission}</td>
                        <td>{$dateCreated}</td>
                    </tr>
                    </tbody>
                </table
            </div>
        </div>
    </div>
</div>
</div>
