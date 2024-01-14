@component('mail::message')
<tr>
    <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
        <center>
            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                <tr>
                    <td>
                        <br/>
                        <h2>@lang('Hi') {{$order->username}}</h2>
                        <h3>@lang('Thank you for ordering from') @lang('Faridah Flowers').</h3>
                        <div>
                            <p><b>@lang('Order ID') : </b>#{{$order->id}}</p>
                            <p><b>@lang('Order Status') : </b>{{$order->currentStatus->theName}}</p>
                            <br/>
                            <p>@lang('Your order has been shipped and the shipper will contact you') .</p>
                            <p>{{$order->orderHistory->last()['notes']}}</p>
                            <br/>
                        </div>
                        <p>@lang('Thank you for ordering from') @lang('Faridah Flowers').</p>
                    </td>
                </tr>
            </table>
        </center>
    </td>
</tr>
@endcomponent