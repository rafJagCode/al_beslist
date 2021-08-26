{$id=(!empty($customer.id)) ? $customer.id : ''}
{$email=(!empty($customer.email)) ? $customer.email : ''}
{$phone=(!empty($customer.phone)) ? $customer.phone : ''}
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-2">
            <div class="img-fluid rounded-start" style="display: grid; place-items: center; height: 100%">
                <i class="material-icons" style="font-size: 80px;">person</i>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card-body">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefon</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{$id}</td>
                        <td>{$email}</td>
                        <td>{$phone}</td>
                    </tr>
                    </tbody>
                </table
            </div>
        </div>
    </div>
</div>
</div>
