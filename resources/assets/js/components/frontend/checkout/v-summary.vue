<template>
    <div style="margin-top: 25px;">
        <div class="col-md-4">
            <div class="step-header">
                <span class="step-num ">4</span>
                <strong>{{$t('Order Summary')}}</strong>
                <br>
            </div>

            <div class="products">
                <div class="product" v-for="(item,index) in items" ref="items"
                     :key="Math.random()*100">
                    <template v-if="item.type === 'product'">
                        <div class="grid"> <!--grid-->
                            <div class="a">
                                <a :href="'/products/'+item.id">
                                    <img :src="item.thumbnail" class=""
                                         onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';"/>
                                </a>
                            </div>
                            <div class="b">
                                <strong><a :href="'/products/'+item.id" v-text="item.theName" class="name"></a></strong>
                                <div v-if="item.propertyType ==='color'" :style="{backgroundColor:item.propertyValue}" class="summary-property-color"></div>
                                <span v-else> {{item.propertyValue}} </span>
                                <br />
                                <span v-text="item.option ? item.option.name:''" class="name option"></span>
                            </div>
                            <div class="c">
                                <!-- <span class="manufacturer">
                                    <span v-text="item.manufacturer ? item.manufacturer.name:''"></span> &bullet; &nbsp; </span> -->
                                <template v-if="$store.state.checkout.coupon">
                                    <template v-if="$store.state.checkout.coupon.type === 'product'
                                    && $store.state.checkout.coupon.minimum <= item.quantity ">
                                        <template
                                                v-if="$store.state.checkout.coupon.products.find(prod=> { return prod === item.id })">
                                            <template v-if="$store.state.checkout.coupon.calc === 'percent'">
                                                <span class="price">
                                                    <span class=" bold"
                                                          v-text="calcCouponPrice(item)+ 'ر.س.'"></span>
                                                    <br>
                                                    <span class="bold text-lined"
                                                          v-text="item.option ? item.option.original_price : item.finalPrice+ 'ر.س.'"></span>
                                                </span>
                                            </template>
                                            <template v-else>
                                                <span class="price">
                                                    <span class=" bold"
                                                          v-text="( ( item.option ? item.option.original_price : item.finalPrice ) - $store.state.checkout.coupon.amount)+'ر.س.'"></span>
                                                <br>
                                                <span class="bold text-lined" v-text="item.option ? item.option.original_price+ 'ر.س.' : item.finalPrice+ 'ر.س.'"></span>
                                            </span>

                                            </template>
                                        </template>
                                        <template v-else>
                                            <span v-text="item.option ? item.option.original_price+ 'ر.س.' : item.finalPrice + 'ر.س.'" class="price bold"></span>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <span v-text="item.option ? item.option.original_price+ 'ر.س.' : item.finalPrice + 'ر.س.'" class="price bold"></span>
                                    </template>

                                </template>
                                <template v-else>
                                    <span v-text="item.option ? item.option.original_price+ 'ر.س.' : item.finalPrice + 'ر.س.'" class="price bold"></span>
                                </template>

                            </div>
                            <div class="d">
                                <template v-if="$store.state.checkout.coupon">
                                    <template v-if="$store.state.checkout.coupon.type === 'product'
                                    && $store.state.checkout.coupon.minimum <= item.quantity ">
                                        <template v-if="$store.state.checkout.coupon.products.find(prod=> { return prod === item.id })">
                                            <template v-if="$store.state.checkout.coupon.calc === 'percent'">
                                                <span v-text="calcCouponPrice(item,item.quantity)   + 'ر.س.'"
                                                      class="price bold"></span>
                                            </template>
                                            <template v-else>
                                                <span v-text="parseFloat((( item.option ? item.option.original_price : item.finalPrice ) - $store.state.checkout.coupon.amount) * item.quantity)  + 'ر.س.'"
                                                      class="price bold"></span>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <span v-text="(( item.option ? item.option.original_price : item.finalPrice ) * item.quantity)  + 'ر.س.'" class="price bold"></span>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <span v-text="(( item.option ? item.option.original_price : item.finalPrice ) * item.quantity)  + 'ر.س.'" class="price bold"></span>
                                    </template>

                                </template>
                                <template v-else>
                                    <span v-text="(( item.option ? item.option.original_price : item.finalPrice ) * item.quantity)  + 'ر.س.'" class="price bold"></span>
                                </template>
                            </div>
                            <div class="e">
                                <span class="plus" @click="increaseQuantity(index)">+</span>
                                <span v-text="item.quantity" class="quantity "></span>
                                <span class="minus" @click="decreaseQuantity(index)">-</span>

                            </div>
                            <div class="f">
                                <i @click="removeItem(item)" class="fi flaticon-cancel"></i>
                            </div>
                        </div>

                        <!--
                        <div class="flex">

                            <strong class="name" v-text="item.name"></strong>
                            <br>
                            <span class="manufacturer" ><span v-text="item.manufacturer.name"></span> &bull; </span>
                            <template v-if="$store.state.checkout.coupon">
                                <template v-if="$store.state.checkout.coupon.type === 'percent'">
                                    <template
                                            v-if="$store.state.checkout.coupon.products.find(prod=> { return prod === item.id })">
                                        <span class="pull-left text-bold" v-text="calcCouponPrice(item)+ 'ر.س.'"></span>
                                        <span class="pull-left text-lined" v-text="item.finalPrice+ 'ر.س.'"></span>
                                    </template>
                                    <span v-else class="pull-left" v-text="item.finalPrice+ 'ر.س.'"></span>
                                </template>
                                <span v-else class="pull-left" v-text="item.finalPrice+ 'ر.س.'"></span>
                            </template>
                            <span v-else class="pull-left" v-text="item.finalPrice+ 'ر.س.'"></span>
                            <br>
                            <span v-if="$store.state.cart.items.find(prod=> { return prod.id === item.id })"
                                  v-text="' الكمية : '+$store.state.cart.items.find(prod=> { return prod.id === item.id }).quantity"></span>
                            <span class="btn btn-danger btn-sm pull-left" @click="removeItem(item)">
                        <span class="glyphicon glyphicon-trash"></span> حذف</span>
                        </div>
-->
                        <hr>
                    </template>
                    <template v-else>
                        <summary-package :items="items" :index="index" :item="item"></summary-package>

                    </template>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!--<template v-if="$store.state.checkout.address">
            <hr>
            <div class="col-xs-12">
                <strong>العنوان : </strong>
                <p>{{ shippingAddress ? shippingAddress.city.name + ' - ' + shippingAddress.street : '' }}
                    <br>{{ shippingAddress ? shippingAddress.details : '' }}</p>
            </div>
            <div class="clearfix"></div>
        </template>-->
        <code-checker ref="codeChecker"></code-checker>
        <br>
        <div class="summary">
            <div class="col-md-4" style="font-size: 2rem;font-weight: 700;">
                {{$t('Total Items')}}
                <span class="pull-left">{{$store.state.cart.prices.totalPrice.toFixed(2)}}ر.س.</span>
                <br>
                <!-- 
                ضريبة القيمة المضافة
                <span class="pull-left">{{$store.state.cart.prices.vat.toFixed(2)}}ر.س.</span>
                <br> -->

                <!--الخيارات الإضافية
                <span class="pull-left">{{ $store.state.cart.prices.additionalOptions}}ر.س.</span>
                <br>-->
                <template v-if="$store.state.checkout.coupon">
                    <span :class="{'text-lined':$store.state.checkout.coupon.type === 'shipping'}">
                        {{$t('Shipping Fee')}}
                        <span class="pull-left"
                              :class="{'text-lined':$store.state.checkout.coupon.type === 'shipping'}">{{ $store.state.cart.prices.shipping}}ر.س.</span>
                    </span>
                </template>
                <template v-else>
                    {{$t('Shipping Fee')}}
                    <span class="pull-left">{{ $store.state.cart.prices.shipping}}ر.س.</span>
                </template>
                <br>
                <template v-if="$store.state.cart.prices.payment > 0">
                    <span>
                        {{$t('Cash On Delivery Fee')}}
                        <span class="pull-left">{{ $store.state.cart.prices.payment}}ر.س.</span>
                    </span>
                </template>

                <br>
                <template v-if="$store.state.checkout.coupon">
                    <template
                            v-if="$store.state.cart.prices.discount > 0 && $store.state.checkout.coupon.type !== 'shipping'">
                        {{$t('Discount')}}
                        <span class="pull-left">-{{ ($store.state.cart.prices.discount)}}ر.س.</span>
                        <br>
                    </template>
                </template>
                <br>
                <strong>{{$t('Total')}} <span class="pull-left">{{ $store.getters.getGrossPrice.toFixed(2) }}ر.س.</span></strong>
            </div>
            <div class="col-xs-12">
                <!-- <br>
                <label>
                    <input type="checkbox" v-model="agree_on_terms" /> موافق على شروط <a href="/pages/2" target="_blank" class="text-secondary">الاستخدام</a> و <a href="/pages/6" target="_blank" class="text-secondary">الخصوصية</a>
                </label> -->
                <label style="margin: 10px 0">
                    <input type="checkbox" v-model="is_gift" /> عدم الإفصاح عن هوية المرسل  (خاص بالهدايا)
                </label>
                <textarea class="form-control" style="resize: none;" placeholder="نص كرت الإهداء أو الملاحظات الأخرى" v-model="notes"></textarea>
                <br>
                <template v-if="$store.state.checkout.payment && $store.state.checkout.payment === 1"> <!-- 1 = Credit Card -->
                    <v-moyasar ref="moyasar" 
                    :payments_redirect_url="payments_redirect_url" 
                    :publishable_api_key="moyasar_publishable_api_key"
                    :payment_method_id="$store.state.checkout.payment"
                    ></v-moyasar>
                </template>
                <template v-else-if="$store.state.checkout.payment && $store.state.checkout.payment === 4"> <!-- 4 = Apple Pay -->
                    <v-moyasar ref="moyasar" 
                    :payments_redirect_url="payments_redirect_url" 
                    :publishable_api_key="moyasar_publishable_api_key"
                    :payment_method_id="$store.state.checkout.payment"
                    ></v-moyasar>
                </template> 
                <template v-else>
                    <span class="btn btn-primary btn-block btn-lg"
                        @click="validateCheckout()"
                        style="margin-bottom: 150px;">
                        <strong v-if="!isLoading">{{$t('Confirm Purchase')}}</strong>
                        <div class="spinner" v-else>
                            <div class="rect1"></div>
                            <div class="rect2"></div>
                            <div class="rect3"></div>
                            <div class="rect4"></div>
                            <div class="rect5"></div>
                        </div>
                    </span>
                </template>
            </div>
            <form :action="checkoutUrl" ref="urwayform" method="POST">
            <!-- <form v-if="user.id == 5" action="https://payments-dev.urway-tech.com/URWAYPGService/direct.jsp?paymentid=2030016116460471819" ref="urwayform" method="POST"> -->
            </form>
            <!-- <a v-if="user.id == 5" @click="submitForm()">sss</a> -->
        </div>
        <sweet-modal icon="error" title="خطأ" overlay-theme="dark" ref="modal">
            <h3>{{$t('Sorry')}}..</h3>
            <p v-for="error in errMsg" v-text="error" class="error"></p>
        </sweet-modal>
        <sweet-modal overlay-theme="dark" ref="mobileValidation">
            <div class="text-center">
                <h3 class="text-secondary">تأكيد رقم الجوال</h3>
                <br>
                <p>نرجو إدخال رمز التحقق المرسل على جوالك رقم
                    <b>{{isGuest ? $store.state.checkout.guest_info.mobile : user.mobile}}</b>
                </p>
                <br>
                <div class="col-xs-8 col-sm-9 ">
                    <div :class="`form-group ${isVerCodeWrong ? ' has-error' : '' }`">
                        <input type="tel" v-model="ver_code" class="form-control text-center" placeholder="رمز التحقق">
                        <template v-if="isVerCodeWrong">
                            <span class="help-block">الرمز غير صحيح!</span>
                        </template>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-3 form-group no-padding">
                    <button class="btn btn-primary btn-block" @click="buy()">
                        <strong v-if="!isLoading">تحقق</strong>
                        <div class="spinner" v-else>
                            <div class="rect1"></div>
                            <div class="rect2"></div>
                            <div class="rect3"></div>
                            <div class="rect4"></div>
                            <div class="rect5"></div>
                        </div>
                        </button>

                </div>
                <div class="clearfix"></div>
            </div>
        </sweet-modal>
    </div>
</template>

<script>

    export default {

        props   : ['addresses', 'user', 'payments_redirect_url', 'moyasar_publishable_api_key',],
        data() {
            return {
                params           : null,
                redirectUrl      : '',
                errMsg           : [],
                items            : this.$root.$refs.cart.getCartItems(),
                shipping         : '',
                isGuest          : !Boolean(this.$root.$refs.address),
                ver_code         : null,
                isVerCodeWrong   : false,
                checkoutUrl      : '',
                showPaymentScript: false,
                isLoading        : false,
                is_gift          : false,
                agree_on_terms   : false,
                notes            : null,
            }
        },
        mounted() {
            let vm = this
            window.addEventListener("load", function(event) {
                vm.updateTotalPrice()
            });
        },
        computed: {},
        methods : {
            findItemIndex(item) {
                return this.items.findIndex(i => {
                    return (item.id === i.id && item.type === i.type && (item.option_id ? item.option_id === i.option_id : true))
                });
            },
            isValidGuest() {

                //Reset errors
                this.$root.$refs.guest.errors = {}

                let errorCount = 0

                //  username
                if (!this.$store.state.checkout.guest_info.username) {
                    errorCount++
                    this.$root.$refs.guest.errors.username = [this.$i18n.t('This field is required!')]
                }
                // address_details
                // if (!this.$store.state.checkout.guest_info.address_details) {
                //     errorCount++
                //     this.$root.$refs.guest.errors.address_details = ['هذا الحقل مطلوب!']
                // }
                // address_owner
                this.$store.state.checkout.guest_info.address_owner = this.$store.state.checkout.guest_info.username
                // if (!this.$store.state.checkout.guest_info.address_owner) {
                //     errorCount++
                //     this.$root.$refs.guest.errors.address_owner = ['هذا الحقل مطلوب!']
                // }
                // city_id
                if (!this.$store.state.checkout.guest_info.city_id) {
                    errorCount++
                    this.$root.$refs.guest.errors.city_id = [this.$i18n.t('This field is required!')]
                } else {
                    if (this.$store.state.checkout.guest_info.city_id == 1) {
                        // district_id
                        if (!this.$store.state.checkout.guest_info.district_id) {
                            errorCount++
                            this.$root.$refs.guest.errors.district = [this.$i18n.t('This field is required!')]
                        }
                    }
                }
                // country_id
                if (!this.$store.state.checkout.guest_info.country_id) {
                    errorCount++
                    this.$root.$refs.guest.errors.country_id = [this.$i18n.t('This field is required!')]
                }
                // mobile
                if (!this.$store.state.checkout.guest_info.mobile) {
                    errorCount++
                    this.$root.$refs.guest.errors.mobile = [this.$i18n.t('This field is required!')]
                }
                return errorCount === 0

            },
            async buy() {
                this.isLoading = true;
                let vm          = this
                let requestData = {
                    address_id        : this.$store.state.checkout.address,
                    guest_info        : this.$store.state.checkout.guest_info,
                    shipping_method_id: this.$store.state.checkout.shipping,
                    shipping_price    : this.$store.state.cart.prices.shipping,
                    shippingDate      : this.$store.state.checkout.shippingDate,
                    shippingTime      : this.$store.state.checkout.shippingTime,
                    payment_method_id : this.$store.state.checkout.payment,
                    cart              : this.$store.state.cart,
                    coupon            : this.$store.state.checkout.coupon,
                    ver_code          : this.ver_code,
                    is_gift           : this.is_gift,
                    notes             : this.notes,
                    receiver_info     : this.$store.state.checkout.receiver_info
                };

                return axios.post('order/buy', requestData).then(respond => {
                    // console.log(respond.data);
                    //Clear Cart
                    // this.$store.commit('clearCart');
                    // this.$root.$refs.cart.clearCart()

                    if (requestData.payment_method_id === 1 || requestData.payment_method_id === 4) { //pay online & apple pay
                        // vm.openPayTabsPopup(respond.data)
                        if (respond.data.error) {
                            vm.errMsg.push('خطأ في الدفع الإلكتروني، يرجى المحاولة مرة أخرى أو اختيار طريقة دفع أخرى')
                            vm.isLoading = false;
                            vm.$refs.modal.open()
                            return false;
                        }
                        vm.$refs.moyasar.order_id = respond.data.order.id
                        return {
                            description: 'Order Id #'+respond.data.order.id,
                        };
                    } else {
                        window.location.href = '/orders/' + respond.data.id
                    }

                }).catch(res => {
                    console.log(res.response.data.errors)
                    if (res.response.data.errors) {
                        this.errMsg.push(res.response.data.errors.quantityError)
                        if (res.response.data.errors['guest_info.mobile']) {
                            this.errMsg.push(res.response.data.errors['guest_info.mobile'][0])
                        }
                        if(res.response.data.errors['guest_info.email']){
                            this.errMsg.push(res.response.data.errors['guest_info.email'][0])
                        }
                        this.$refs.mobileValidation.close()
                        this.$refs.modal.open()
                    } else {
                        this.isVerCodeWrong = true
                    }
                    this.isLoading = false;
                })
            },
            openPayTabsPopup(data) {
                let script = document.createElement('script');
                script.src = 'https://www.paytabs.com/express/v4/paytabs-express-checkout.js';
                script.id = 'paytabs-express-checkout';
                script.setAttribute('data-secret-key', data.secret_key);
                script.setAttribute('data-merchant-id', data.merchant_id);
                script.setAttribute('data-url-redirect', data.url_redirect);
                script.setAttribute('data-order-id', data.order_id);
                script.setAttribute('data-amount', data.amount);
                script.setAttribute('data-currency', 'SAR');
                script.setAttribute('data-title', data.title);
                script.setAttribute('data-product-names', data.product_names);
                script.setAttribute('data-customer-phone-number', data.customer_phone_number);
                script.setAttribute('data-customer-email-address', data.customer_email_address);
                script.setAttribute('data-billing-full-address', data.billing_full_address);
                script.setAttribute('data-billing-city', data.billing_city);
                script.setAttribute('data-billing-state', data.billing_state);
                script.setAttribute('data-customer-country-code', '966');
                script.setAttribute('data-language', 'ar');
                script.setAttribute('data-is-mada', '0');
                script.setAttribute('data-ui-show-billing-address', 'false');
                script.setAttribute('data-billing-country', 'SAU');
                script.setAttribute('data-billing-postal-code', "12464-1000");
                script.setAttribute('data-color', '#9a0120');
                document.body.appendChild(script);
                var clickPTClass = setInterval(() => {
                    if (document.getElementsByClassName('PT_open_iframe')) {
                        document.getElementsByClassName('PT_open_iframe')[0].click()
                        clearInterval(clickPTClass)
                    }
                }, 500);
                    
            },
            removeItem(item) {
                this.$root.$refs.cart.removeFromCart(item)
                this.updateTotalPrice()
                this.$root.$refs.shipping.getAddressShippingMethods()

            },
            calcCouponPrice(product, quantity = null) {
                let discount = parseFloat(
                    product.finalPrice * (quantity ? quantity : 1) * (1 - (this.$store.state.checkout.coupon.amount / 100)));

                return discount
            },
            async validateCheckout() {
                this.isLoading = true;
                //1- Validate data
                this.errMsg = [];

                //1.1 User details
                if (!this.isGuest) {
                    //1.1.1 address | FOR AUTHED USERS
                    if (!this.$store.state.checkout.address) {
                        this.errMsg.push('- '+ this.$i18n.t('Select Shipping Address'))
                    }
                } else {
                    //1.1.2 guest info || FOR GUESTS
                    if (!this.isValidGuest()) {
                        this.errMsg.push(this.$i18n.t('Your information is incomplete!'))
                    }
                }

                // receiver info
                if (this.$store.state.checkout.receiver_info.another_reciver_checked){
                    var receiver_info_error = false
                    // receiver_name
                    if (!this.$store.state.checkout.receiver_info.receiver_name) {
                        receiver_info_error = true
                    }
                    // receiver_mobile
                    if (!this.$store.state.checkout.receiver_info.receiver_mobile) {
                        receiver_info_error = true
                    }
                    // receiver_city_id
                    if (!this.$store.state.checkout.receiver_info.receiver_city_id) {
                        receiver_info_error = true
                    }
                    if (this.$store.state.checkout.receiver_info.receiver_city_id == 'select') {
                        receiver_info_error = true
                    }
                    // receiver_district_id
                    if (!this.$store.state.checkout.receiver_info.receiver_district_id) {
                        receiver_info_error = true
                    }
                    if(receiver_info_error){
                        this.errMsg.push('- '+ this.$i18n.t('Receiver details required!'))
                    }
                }
                
                //1.2 shipping
                if (!this.$store.state.checkout.shipping) {
                    this.errMsg.push('- '+ this.$i18n.t('Select Shipping Method'))
                }
                //1.2.1 shipping date
                if(!this.$store.state.checkout.shippingDate){
                    this.errMsg.push('- '+ this.$i18n.t('Shipping date required!'))
                }
                //1.2.2 shipping time
                if(!this.$store.state.checkout.shippingTime){
                    this.errMsg.push('- '+ this.$i18n.t('Shipping time required!'))
                }
                
                //1.3 payment
                if (!this.$store.state.checkout.payment) {
                    this.errMsg.push('- '+ this.$i18n.t('Select Payment Method'))
                }

                //1.3 payment
                if (this.$root.$refs.shipping.orderWeight >= 15) {
                    this.errMsg.push('لا يمكنك إتمام الطلب لتجاوز وزن الشحنة 15 KG')
                }
                
                //1.3 agree_on_terms
                // if (!this.agree_on_terms) {
                //     this.errMsg.push('- يجب الموافقة على الشروط والأحكام')
                // }

                if (this.errMsg.length) {
                    this.$refs.modal.open()
                    this.isLoading = false;
                } else {
                    return this.buy().then(res => {
                        return res;
                    })
                }
            },
            increaseQuantity(index) {
                let product = this.items[index]
                let item    = {
                    id          : product.id,
                    type        : product.type,
                    quantity    : 1,
                    option_id   : product.option_id ? product.option_id : '',
                    maxQuantity : product.maxQuantity,
                }
                if (product.quantity < product.maxQuantity) {
                    this.$store.dispatch('addToCart', item)
                    this.$root.$refs.cart.addCartItem(item)
                }
                this.$refs.codeChecker.checkCode()
                this.updateTotalPrice()
                this.$root.$refs.shipping.getAddressShippingMethods()
            },
            decreaseQuantity(index) {
                if (this.items[index].quantity > 1) {
                    let product = this.items[index]
                    let item    = {
                        id          : product.id,
                        type        : product.type,
                        quantity    : -1,
                        option_id   : product.option_id ? product.option_id : '',
                        maxQuantity : product.maxQuantity,
                    }
                    this.$store.dispatch('addToCart', item)
                    this.$root.$refs.cart.addCartItem(item)
                    this.$refs.codeChecker.checkCode()
                    this.updateTotalPrice()
                    this.$root.$refs.shipping.getAddressShippingMethods()
                }
            },
            updateTotalPrice() {
                let total = 0;
                let totalVAT = 0;
                this.items.forEach(item => {
                    if (item.type === 'product') {
                        let discount = 0
                        // let vat = ((parseInt(item.finalPrice) / 105) * 5)
                        let itemPrice = Number((Number(( item.option ? item.option.original_price : item.finalPrice )) * item.quantity))
                        if (this.$store.state.checkout.coupon) {
                            discount = Number(((itemPrice / 100) * (item.discount_percentage? item.discount_percentage : 0) ))
                        }
                        total += itemPrice - discount
                        let vat2 = Number(((itemPrice - discount) / 20))
                        totalVAT += vat2
                    } else {
                        let discount = 0
                        // let vat = ((parseInt(item.finalPrice) / 105) * 5)
                        let itemPrice = Number(Number(item.price) * item.quantity)
                        if (this.$store.state.checkout.coupon) {
                            discount = Number(((itemPrice / 100) * (item.discount_percentage? item.discount_percentage : 0) ))
                        }
                        total += itemPrice - discount
                        let vat2 = Number(((itemPrice - discount) / 20))
                        totalVAT += vat2
                    }

                });
                this.$store.commit('updateTotalPrice', total)
                this.$store.commit('updateTotalVAT', totalVAT)

                if (this.$refs.moyasar) {
                    this.$refs.moyasar.initMoyasar();
                }
            },
            checkPopup() {
                //need to check only desktops
                if (!(typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1)) {
                    //to check if the popup blocker enabled or not
                    //we use login page just because it is light page
                    //chrome consider popup is dangerous when it is trigger was an ajax call not user clicking action
                    axios.get('/checkout').then(() => {
                        let win = window.open('about:blank', 'popup',
                            'height=1,width=1,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');
                        popupBlockerChecker.check(win, this);
                    })
                } else {
                    this.buy()
                }
            },

        }

    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"

    .product
        margin-bottom : 20px

        .summary
            
            line-height : 33px
            a.btn
                margin-top : 30px

        .name
            font-size : 15px
            color: $brand-dark
        .option
            font-size : 12px
        .manufacturer
            color : #aaa
            font-size : 12px
        .price
            font-size : 12px
            font-weight : bold

        .error
            font-size : large
            font-weight : bold

        .sweet-modal .sweet-title > h2
            line-height : 64px

        .grid
            display : grid
            grid-template-areas : "a b b e f" "a c c e f" "a d d e f"
            grid-template-columns : fit-content(70px)
            justify-content : stretch
            width : 100%
            grid-gap : 0 15px
            align-items : stretch
            margin : 20px 0

            & > div
                justify-self : start
                text-align : right
                justify-content : start
            .a
                grid-column : 1
                grid-row : 1
                grid-row-end : 4
                grid-area : a
                width : 70px
                img
                    width : 100%

            .b
                grid-area : b

            .c
                grid-area : c
                display : flex
            .d
                grid-area : d
                .price
                    font-size : 15px
                    font-weight : bold
            .e
                grid-area : e
                display : flex
                justify-content : space-between
                align-items : stretch
                flex-direction : column
                justify-self : end
                text-align : center
                .plus, .minus
                    cursor: pointer;
            .f
                grid-area : f
                display : grid
                align-items : center
                justify-self : end
                .fi:before
                    padding : 7px
                    font-size : 9px
                    background :
                    border-radius : 50%
                    cursor : pointer

                .fi:hover:before
                    background : grey
                    color : #fff
            .quantity
                border : 1px solid lightgray
                padding : 0 15px
                border-radius : 3px
                text-align : center
                font-size : 13px
                font-weight : bold

    .spinner 
        margin     : 0 auto;
        width      : 50px;
        height     : 24px;
        text-align : center;
        font-size  : 10px;
    

    .spinner > div 
        background-color  : #fff;
        height            : 100%;
        width             : 6px;
        display           : inline-block;

        -webkit-animation : sk-stretchdelay 1.2s infinite ease-in-out;
        animation         : sk-stretchdelay 1.2s infinite ease-in-out;
    

    .spinner .rect2 
        -webkit-animation-delay : -1.1s;
        animation-delay         : -1.1s;
    

    .spinner .rect3 
        -webkit-animation-delay : -1.0s;
        animation-delay         : -1.0s;
    

    .spinner .rect4 
        -webkit-animation-delay : -0.9s;
        animation-delay         : -0.9s;
    

    .spinner .rect5 
        -webkit-animation-delay : -0.8s;
        animation-delay         : -0.8s;
    

    @-webkit-keyframes sk-stretchdelay 
        0%, 40%, 100% 
            -webkit-transform : scaleY(0.4)
        
        20% 
            -webkit-transform : scaleY(1.0)
        
    

    @keyframes sk-stretchdelay 
        0%, 40%, 100% 
            transform         : scaleY(0.4);
            -webkit-transform : scaleY(0.4);
        
        20% 
            transform         : scaleY(1.0);
            -webkit-transform : scaleY(1.0);
    .summary-property-color
        border: 1px solid #cacaca
        width: 16px
        height: 16px
        display: inline-block
        border-radius: 8px
        vertical-align: middle
        margin: 0 15px
</style>