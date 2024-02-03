<template>
    <div class="payment-container">
        <div class="step-header" :class="{'step-success' :$store.state.checkout.payment}">
            <span class="step-num ">3</span>
            <span class="step-title">{{$t('Payment Methods')}}</span>
        </div>
        <div class="form-horizontal">
            <div class="radio col-sm-12" v-for="method in paymentMethods">
                <label class="col-sm-8 col-xs-8 no-padding">
                    <input :value="method.id" type="radio" v-model="payment"
                           :disabled="!$store.state.checkout.shipping || canMakePaymentByApplePay == 0 && method.id == 4">
                    <span class="flex">
                    <span>{{method.theName}} &nbsp; &nbsp;</span>
                    <span class="price text-primary" v-if="method.price > 0"> +{{method.price}} ريال  </span>
                        </span>
                </label>
                <span v-if="canMakePaymentByApplePay == 0 && method.id == 4" class="details col-sm-12 col-xs-12">
                    <small>
                        <span class="text-red">متصفحك لا يقبل الدفع بواسطة</span>
                        <span> Pay</span>
                    </small>
                </span>
                <span class="text-left col-sm-4 col-xs-4 no-padding" v-if="method.id == 1"><img src="/imgs/paymentpartners1.png" width="100%" /></span>
                <!-- <span class="text-left col-sm-4 col-xs-4 no-padding" v-if="method.id == 2"><img src="/imgs/cod.png" width="60" /></span> -->
                <!-- <span class="text-left col-sm-4 col-xs-4 no-padding" v-if="method.id == 3"><img src="/imgs/banks1.png" width="90%" /></span> -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user_id'],
        data() {
            return {
                paymentMethods: [],
                canMakePaymentByApplePay: 0
            }
        },
        mounted() {
            axios.get('payment-methods').then(res => {
                // console.log(res.data);
                this.paymentMethods = res.data
            })
            this.checkApplePay();
        },
        computed: {
            payment: {
                get() {
                    return this.$store.state.checkout.payment
                },
                set(value) {
                    if (value != null) {
                        let price = this.paymentMethods.find(method => {return method.id === value}).price
                        
                        // Check if payment price is free
                        let cart     = this.$root.$refs.cart.getCartItems();
                        let payment_free = false
                        cart.forEach(item => {
                            if (item.payment_free == 1) {
                                payment_free = true;
                                return;
                            }
                        })
                        
                        // Search country id
                        let country_id = ''
                        if (this.$store.state.checkout.address) {
                            country_id = this.$root.$refs.address.addresses.find(address => {return address.id === this.$store.state.checkout.address}).city.country_id
                        } else if (this.$store.state.checkout.guest_info.country_id) {
                            country_id = this.$store.state.checkout.guest_info.country_id
                        }

                        // Set shipping price is free
                        if (payment_free == true && country_id == 1) { // 1 = Saudi Arabia
                            price = 0;
                        }
                        
                        this.$store.commit('updatePayment', {
                            value,
                            price
                        })
                        this.$root.$refs.summary.$refs.codeChecker.checkCode()
                        this.$root.$refs.summary.updateTotalPrice()
                    }
                }
            }
        },
        methods : {
            /*
             updatePayments(payments) {
             this.paymentMethods = payments
             },
             */
            checkApplePay() {
                let vm = this;
                if (window.ApplePaySession) {
                    var merchantIdentifier = "merchant.com.moyasar";
                    var promise = ApplePaySession.canMakePaymentsWithActiveCard(
                    merchantIdentifier
                    );
                    promise.then(function(canMakePayments) {
                    if (canMakePayments) {
                        console.log("hi, I can do ApplePay");
                        vm.canMakePaymentByApplePay = 1;
                    } else {
                        console.log(
                        "ApplePay is possible on this browser, but not currently activated."
                        );
                        vm.canMakePaymentByApplePay = 0;
                    }
                    });
                } else {
                    console.log("ApplePay is not available on this browser");
                    vm.canMakePaymentByApplePay = 0;
                }
            },
            updatePaymentMethods() {
                let address_id  = this.$store.state.checkout.address
                let shipping_id = this.$store.state.checkout.shipping
                let city_id     = this.$store.state.checkout.guest_info.city_id
                if (shipping_id) {
                    if (address_id) {

                        axios.get(`/payment-methods/address/${address_id}/${shipping_id}`).then(res => {
                            this.paymentMethods                = res.data
                            this.$store.state.checkout.payment = null
                            this.payment                       = null
                            this.$store.state.cart.prices.payment = 0
                        })
                    } else if (city_id) {
                        axios.get(`/payment-methods/city/${city_id}/${shipping_id}`).then(res => {
                            this.paymentMethods                = res.data
                            this.$store.state.checkout.payment = null
                            this.payment                       = null
                            this.$store.state.cart.prices.payment = 0
                        })

                    }
                }

            }
        }
    }

</script>


<style lang="sass" scoped>
    /*@import "~styles/frontend/variables"*/
    .payment-container
        padding-left: 75px
        padding-right: 75px
        @media (max-width: 767px)
            padding-left: 0px
            padding-right: 0px
</style>