<template>
    <div>
        <hr>
        <h4 v-if="payment_method_id == 1" class="text-primary">{{$t('Enter the credit card info')}}</h4>
        <div class="mysr-form"></div>
    </div>
</template>

<script>
    export default {
        props: ['payments_redirect_url', 'publishable_api_key', 'payment_method_id', 'repay_order_id', 'repay_order_total_price', 'is_repay'],
        data() {
            return {
                order_id: null,
                paymentMethod: '',
                apple_pay_label: {}
            }
        },
        mounted() {
            let vm = this

            if (vm.is_repay == "1") {
                vm.order_id = vm.repay_order_id
            }

            if (vm.payment_method_id == 1) {
                vm.paymentMethod = ['creditcard', 'stcpay'];
            } else if(vm.payment_method_id == 4) {
                vm.paymentMethod = ['applepay'];
                vm.apple_pay_label = {
                    country: 'SA',
                    label: 'ورود فريدة',
                    validate_merchant_url: 'https://api.moyasar.com/v1/applepay/initiate',
                    merchant_capabilities: [
                        'supports3DS',
                        'supportsCredit',
                        'supportsDebit'
                    ],
                }
            }

            let externalScript = document.createElement('script')
            externalScript.setAttribute('src', 'https://cdn.moyasar.com/mpf/1.12.0/moyasar.js')
            document.head.appendChild(externalScript)
            setTimeout(function() {
                vm.initMoyasar();
            }, 2500);
        },
        methods : {
            initMoyasar() {
                let vm = this
                let total_price = vm.is_repay == "1" ? Number(this.repay_order_total_price) : Number(this.$store.getters.getGrossPrice.toFixed(2));
                Moyasar.init({
                    // Required
                    // Specify where to render the form
                    // Can be a valid CSS selector and a reference to a DOM element
                    element: '.mysr-form',

                    // Required
                    // Amount in the smallest currency unit
                    // For example:
                    // 10 SAR = 10 * 100 Halalas
                    // 10 KWD = 10 * 1000 Fils
                    // 10 JPY = 10 JPY (Japanese Yen does not have fractions)
                    amount: total_price * 100,

                    // Required
                    // Currency of the payment transation
                    currency: 'SAR',

                    // Required
                    // A small description of the current payment process
                    description: vm.order_id != null ? 'Order Id #'+vm.order_id : '-',

                    // Required
                    publishable_api_key: vm.publishable_api_key,

                    // Required
                    // This URL is used to redirect the user when payment process has completed
                    // Payment can be either a success or a failure, which you need to verify on you system (We will show this in a couple of lines)
                    callback_url: vm.payments_redirect_url,

                    // Optional
                    // Required payments methods
                    // Default: ['creditcard', 'applepay', 'stcpay']
                    methods: vm.paymentMethod,

                    // apple_pay_label
                    apple_pay: vm.apple_pay_label,

                    fixed_width: false,

                    // Create Order
                    on_initiating: function () {
                        if (vm.is_repay != "1") { // create order only if not repay
                            return vm.$parent.validateCheckout().then(response => {
                                // console.log('after validateCheckout')
                                // console.log(response)
                                return response;
                            })
                        }
                        return {};
                    },

                    // Save Payment
                    on_completed: function (payment) {
                        return vm.savePayment(payment).then(response => {
                            return response
                        })
                    }
                });
                if (vm.payment_method_id == 1) { // creditcard
                    setTimeout(function() {
                        document.getElementsByClassName('mysr-form-button')[0].innerHTML = 'تأكيد الشراء والدفع | ';
                    }, 1000)
                }
            },
            async savePayment(payment) {
                payment.order_id = this.order_id;
                // console.log(payment)
                axios.post('/moyasar/payments_save', payment).then(respond => {
                    return respond.code == 201;
                });
            }
        }
    }

</script>


<style lang="sass" scoped>
    /*@import "~styles/frontend/variables"*/

</style>