@component('mail::message')
<tr>
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
      <center>
        <table cellspacing="0" cellpadding="0" width="600" class="w320">
          <tr>
            <td class="header-lg">
              <b>طلب جديد في المتجر !
            </td>
          </tr>
          <tr>
            <td class="free-text">
              @lang('Order ID') <a href="">#{{$order->id}}</a>. @lang('Below you will find your order details').
            </td>
          </tr>
          <tr>
            <td class="button">
              <!-- <div> -->
              <!--[if mso]>
                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://" style="height:45px;v-text-anchor:middle;width:155px;" arcsize="15%" strokecolor="#ffffff" fillcolor="#ff6f6f">
                  <w:anchorlock/>
                  <center style="color:#ffffff;font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;">Track Order</center>
                </v:roundrect>
              <![endif]-->
              <!-- <a href="http://"
              style="background-color:#ff6f6f;border-radius:5px;color:#ffffff;display:inline-block;font-family:'Cabin', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;">Track Order</a></div> -->
            </td>
          </tr>
          <tr>
            <td class="w320">
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td class="mini-container-left" style="text-align: right;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <span class="header-sm">@lang('Order Details')</span><br />
                                @lang('ID') : #{{$order->id}} <br />
                                @lang('Status') : {{$order->currentStatus->theName}} <br />
                                @lang('Date') : {{$order->formatted_created_at}} <br />
                                @lang('Shipping Method') : {{$order->shipping_method}} <br />
                                @lang('Payment Method') : {{$order->paymentMethod->theName}} <br />
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td class="mini-container-right">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <span class="header-sm">@lang('User Information')</span><br />
                                {{$order->username}} <br />
                                {{$order->mobile}}
                                <br />
                                <span class="header-sm">@lang('Shipping Address')</span> <br />
                                {{$order->address_owner}} <br />
                                {{$order->address_details}}
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
      <center>
        <table cellpadding="0" cellspacing="0" width="600" class="w320">
            <tr>
              <td class="item-table">
                <table cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td class="title-dark" width="300">
                      @lang('Items')
                    </td>
                    <td class="title-dark" width="97"  style="text-align: center;">
                      @lang('Price')
                    </td>
                    <td class="title-dark" width="97"  style="text-align: center;">
                      @lang('Quantity')
                    </td>
                    <td class="title-dark" width="97"  style="text-align: center;">
                      @lang('Discount')
                    </td>
                    <td class="title-dark" width="97"  style="text-align: left;">
                      @lang('Total')
                    </td>
                  </tr>

                  @foreach($order->orderItems as $item)
                  <tr>
                    <td class="item-col item">
                      <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td class="mobile-hide-img">
                          @if($item->orderable->getFirstMedia('images'))
                            <img src="{{$item->orderable->getFirstMedia('images')->getUrl()}}">
                          @endif
                          </td>
                          <td class="product">
                            <span style="color: #4d4d4d; font-weight:bold;">{{$item->orderable->name}}</span> 
                            @if($item->property_value)
                                @if($item->property_value->property->type == 'selection')
                                    <span>[ {{$item->property_value->value}} ]</span>
                                @else {{-- the property type is color --}}
                                    <span style="width:25px; height:15px; border:1px solid #b9b9b9; vertical-align: middle; display:inline-block; margin:0 10px; background:{{$item->property_value->value}}"></span>
                                @endif
                            @endif
                            <br />
                            {{$item->orderable->product_code}}
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td class="item-col unit_price" style="text-align: center;">
                      {{$item->unit_price}} @lang('SR')
                    </td>
                    <td class="item-col quantity" style="text-align: center;">
                      {{$item->count}}
                    </td>
                    <td class="item-col discount" style="text-align: center;">
                      {{$item->discount}} @lang('SR')
                    </td>
                    <td class="item-col" style="text-align: left;">
                      {{($item->unit_price * $item->count) - $item->discount }} @lang('SR')
                    </td>
                  </tr>
                  @endforeach

                  <!-- <tr>
                    <td class="item-col item">
                      <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td class="mobile-hide-img">
                            <img src="http://s3.amazonaws.com/swu-filepicker/RPezUIwPRv8pjatAAH1E_item_images_19.jpg" alt="item1">
                          </td>
                          <td class="product">
                            <span style="color: #4d4d4d; font-weight:bold;">Golden Earings</span> <br />
                            Hot city looks
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td class="item-col quantity">
                      1
                    </td>
                    <td class="item-col">
                      $2.52
                    </td>
                  </tr>

                  <tr>
                    <td class="item-col item">
                      <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td class="mobile-hide-img">
                            <img src="http://s3.amazonaws.com/swu-filepicker/9wRy50HQTg2CTyZA5Ozi_item_images_16.jpg" alt="item2">
                          </td>
                          <td class="product">
                            <span style="color: #4d4d4d; font-weight: bold;">Pink Shoes</span> <br />
                            Newest styles
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td class="item-col quantity">
                      1
                    </td>
                    <td class="item-col price">
                      $10.50
                    </td>
                  </tr> -->


                  <tr>
                    <td class="item-col item mobile-row-padding"></td>
                    <td class="item-col unit_price"></td>
                    <td class="item-col quantity"></td>
                    <td class="item-col discount"></td>
                    <td class="item-col total"></td>
                  </tr>


                  <tr>
                    <td class="item-col item">
                    </td>
                    <td colspan="2" class="item-col discount" style="text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;">
                      <span class="total-space">@lang('Total Items')</span> <br />
                      @if(!empty($order->coupon))
                      <span class="total-space">@lang('Discount')</span>  <br />
                      @endif
                      <!-- <span class="total-space">ضريبة القيمة المضافة</span> <br /> -->
                      <span class="total-space">@lang('Shipping Fee')</span>  <br />
                      <span class="total-space" style="font-weight: bold; color: #4d4d4d">@lang('Total')</span>
                    </td>
                    <td colspan="2" class="item-col total" style="text-align: left; border-top: 1px solid #cccccc;">
                      <span class="total-space">{{$order->items_price}} @lang('SAR')</span> <br />
                      @if(!empty($order->coupon))
                      <span class="total-space">- {{$order->discount}} @lang('SAR')</span>  <br />
                      @endif
                      <!-- <span class="total-space">{{$order->vat}} @lang('SAR')</span>  <br /> -->
                      <span class="total-space">{{$order->shipping_price}} @lang('SAR')</span>  <br />
                      <span class="total-space" style="font-weight:bold; color: #4d4d4d">{{$order->total_price}} @lang('SAR')</span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

        </table>
      </center>
    </td>
  </tr>
@endcomponent