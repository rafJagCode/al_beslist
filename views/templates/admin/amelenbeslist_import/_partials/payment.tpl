{$method=(!empty($payment.method)) ? $payment.method : ''}
{$consumer_name=(!empty($payment.consumer_name)) ? $payment.consumer_name : ''}
{$status=(!empty($payment.status)) ? $payment.status : ''}
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-2">
            <div class="img-fluid rounded-start" style="display: grid; place-items: center; height: 100%">
                <i class="material-icons" style="font-size: 80px;">credit_card</i>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card-body">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th scope="col">Nazwa Płatnika</th>
                        <th scope="col">Metoda Płatności</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{$consumer_name}</td>
                        <td>{$method}</td>
                        <td>{$status}</td>
                    </tr>
                    </tbody>
                </table
            </div>
        </div>
    </div>
</div>
</div>
