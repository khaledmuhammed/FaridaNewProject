@component('mail::message')
<tr>
    <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
        <center>
            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                <tr>
                    <td>
                        <br/>
                        <p style="text-align: center;"><img src="{{$product->media->first()->url}}" width="300" /></p>
                        <h2 style="text-align: center;">{{$product->name}}</h2>
                        <h3 style="text-align: center;">@lang('Currently available on store')!!</h3>
                        @component('mail::button', ['url' => $url, 'color' => 'primary'])
                        @lang('Show')
                        @endcomponent
                        <p style="text-align: center;">@lang('Faridah Flowers Team').</p>
                    </td>
                </tr>
            </table>
        </center>
    </td>
</tr>
@endcomponent