{$firstName=(!empty($shipping_address.firstName)) ? $shipping_address.firstName : ''}
{$lastNameInsertion=(!empty($shipping_address.lastNameInsertion)) ? $shipping_address.lastNameInsertion : ''}
{$lastName=(!empty($shipping_address.lastName)) ? $shipping_address.lastName : ''}
{$zip=(!empty($shipping_address.zip)) ? $shipping_address.zip : ''}
{$city=(!empty($shipping_address.city)) ? $shipping_address.city : ''}
{$address=(!empty($shipping_address.address)) ? $shipping_address.address : ''}
{$addressNumber=(!empty($shipping_address.addressNumber)) ? $shipping_address.addressNumber : ''}
{$addressNumberAdditional=(!empty($shipping_address.addressNumberAdditional)) ? $shipping_address.addressNumberAdditional : ''}
{$country=(!empty($shipping_address.country)) ? $shipping_address.country : ''}
{$sex=(!empty($shipping_address.sex)) ? $shipping_address.sex : ''}
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-2">
            <div class="img-fluid rounded-start" style="display: grid; place-items: center; height: 100%">
                <i class="material-icons" style="font-size: 80px;">local_shipping</i>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card-body">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th scope="col">Imię</th>
                        <th scope="col">Przedrostek</th>
                        <th scope="col">Nazwisko</th>
                        <th scope="col">Kod Pocztowy</th>
                        <th scope="col">Miasto</th>
                        <th scope="col">Ulica</th>
                        <th scope="col">Numer Domu</th>
                        <th scope="col">Numer Dodatkowy</th>
                        <th scope="col">Kraj</th>
                        <th scope="col">Płeć</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{$firstName}</td>
                            <td>{$lastNameInsertion}</td>
                            <td>{$lastName}</td>
                            <td>{$zip}</td>
                            <td>{$city}</td>
                            <td>{$address}</td>
                            <td>{$addressNumber}</td>
                            <td>{$addressNumberAdditional}</td>
                            <td>{$country}</td>
                            <td>{$sex}</td>
                        </tr>
                    </tbody>
                </table
            </div>
        </div>
    </div>
</div>
</div>
