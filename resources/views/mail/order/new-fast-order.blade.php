@component('mail::message')
<tr>
    <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
        <center>
            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                <tr>
                    <td>
                        <br/>
                        <h2>@lang('Hi')</h2>
                        <h3>هناك طلب واتساب جديد.</h3>
                        <div>
                            <p><b>@lang('Order ID') : </b>#{{$order->id}}</p>
                            <p><b>@lang('Name') : </b>{{$order->name}}</p>
                            <p><b>@lang('Mobile') : </b>{{$order->mobile}}</p>
                            <br/>
                            <br/>
                        </div>
                    </td>
                </tr>
            </table>
        </center>
    </td>
</tr>
@endcomponent