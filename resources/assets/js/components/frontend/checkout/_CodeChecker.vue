<template>
    <div>
        <div class="col-xs-7 col-md-8">
            <div class="form-group no-margin"
                 :class="{'has-error':errors.code, 'has-success':validCoupon}">
                <input v-model="code" class="form-control input-md coupon " :placeholder="$t('Do you have a coupon?')"
                       @input="errors=[]"/>
            </div>
        </div>
        <div class="col-xs-5 col-md-4">
            <button class="btn btn-primary btn-block btn-md " @click="checkCode">
                <span v-if="!isLoading">{{$t('Validate')}}</span>
                <div class="spinner" v-else>
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </button>
        </div>
        <div class="col-xs-12 form-group no-margin" :class="{'has-error':errors.code, 'has-success':validCoupon}">
            <div class="help-block text-success" v-if="validCoupon">{{$t('Awesome! you have got a discount')}}</div>
            <div class="help-block" v-for="error in errors.code">{{error}}</div>


        </div>
        <div class="clearfix"></div>
    </div>
</template>

<script>
    export default {
        name    : "CodeChecker",
        data() {
            return {
                code     : '',
                errors   : {},
                isLoading: false
            }
        },
        computed: {
            validCoupon() {
                let coupon = this.$store.state.checkout.coupon;
                if (coupon) {
                    if (coupon.type === 'fixed') {
                        return this.$store.getters.getTotalPrice >= coupon.min_amount
                    }
                    return true
                }
                return false
            }
        },
        methods : {
            checkCode() {
                if (this.code.length && !this.isLoading) {
                    this.isLoading = true;
                    this.$store.commit('updateCoupon', null);
                    this.$store.commit('updateDiscount', 0);

                    this.errors = {};

                    axios.post('/coupon', {
                        code: this.code,
                        cart: this.$store.state.cart,
                        payment_method_id: this.$store.state.checkout.payment,
                    }).then(res => {
                        let coupon = res.data.coupon;
                        let discount = 0;
                        let cart     = this.$root.$refs.cart.getCartItems();
                        if (coupon.type === 'order') {
                            if (parseFloat(coupon.minimum) <= this.$store.getters.getTotalPrice) {
                                this.$store.commit('updateCoupon', coupon);
                                if (coupon.calc === 'fixed') {
                                    discount = parseFloat(coupon.amount)
                                    this.$store.commit('updateDiscount', discount)
                                    cart.forEach(item => {
                                        item.discount_percentage = (discount * 100) / this.$store.getters.getTotalPrice;
                                    })
                                } else {
                                    discount = this.$store.getters.getTotalPrice * parseFloat(coupon.amount) / 100
                                    this.$store.commit('updateDiscount', discount)
                                    cart.forEach(item => {
                                        item.discount_percentage = coupon.amount;
                                    })
                                }
                                

                            } else {
                                this.errors.code = ["قيمة المشتريات يجب أن تكون أعلى من " + coupon.minimum + " ريال"]
                            }
                        } else {
                            
                            cart.forEach(item => {
                                if (coupon.products.includes(item.id)) {
                                    if (item.quantity < coupon.minimum) {
                                        this.errors.code = ["بعض منتجاتك أقل من الكمية المطلوبة لتطبيق الكوبون"]
                                    } else {
                                        if (coupon.calc === 'fixed') {
                                            discount += item.quantity * coupon.amount
                                            item.discount_percentage = (coupon.amount * 100) / item.finalPrice
                                        } else {
                                            discount += (item.finalPrice * item.quantity) * ((coupon.amount) / 100)
                                            item.discount_percentage = coupon.amount;
                                        }
                                    }
                                }
                            });
                            if (discount > 0) {
                                this.$store.commit('updateCoupon', coupon);
                            }
                            this.$store.commit('updateDiscount', discount)

                        }
                        this.$root.$refs.summary.updateTotalPrice()

                        /*if (parseFloat(coupon.min_amount) !== 0 && parseFloat(
                         coupon.min_amount) < this.$store.getters.getTotalPrice) {
                         this.$store.commit('updateCoupon', coupon);
                         if (coupon.type === 'fixed') {
                         this.$store.commit('updateDiscount', parseFloat(coupon.amount))
                         } else if (coupon.type === 'shipping') {
                         this.$store.commit('updateDiscount', this.$store.state.cart.prices.shipping)
                         } else {
                         let cart     = this.$root.$refs.cart.getCartItems();
                         let discount = 0;
                         cart.forEach(item => {
                         if (coupon.products.includes(item.id)) {
                         discount += item.finalPrice * item.quantity * ((coupon.amount) / 100)
                         }
                         });
                         this.$store.commit('updateDiscount', discount)
                         }


                         } else {
                         this.errors.code = ["قيمة المشتريات يجب أن تكون أعلى من " + coupon.min_amount + " ريال"]
                         }*/

                        this.isLoading = false
                    }).catch(res => {
                        this.errors    = res.response.data.errors;
                        this.isLoading = false
                    })
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/frontend/variables";

    .form-control {
        border : 1px dashed $brand-primary !important;
    }

    .spinner {
        margin     : 0 auto;
        width      : 50px;
        height     : 24px;
        text-align : center;
        font-size  : 10px;
    }

    .spinner > div {
        background-color  : #fff;
        height            : 100%;
        width             : 6px;
        display           : inline-block;

        -webkit-animation : sk-stretchdelay 1.2s infinite ease-in-out;
        animation         : sk-stretchdelay 1.2s infinite ease-in-out;
    }

    .spinner .rect2 {
        -webkit-animation-delay : -1.1s;
        animation-delay         : -1.1s;
    }

    .spinner .rect3 {
        -webkit-animation-delay : -1.0s;
        animation-delay         : -1.0s;
    }

    .spinner .rect4 {
        -webkit-animation-delay : -0.9s;
        animation-delay         : -0.9s;
    }

    .spinner .rect5 {
        -webkit-animation-delay : -0.8s;
        animation-delay         : -0.8s;
    }

    @-webkit-keyframes sk-stretchdelay {
        0%, 40%, 100% {
            -webkit-transform : scaleY(0.4)
        }
        20% {
            -webkit-transform : scaleY(1.0)
        }
    }

    @keyframes sk-stretchdelay {
        0%, 40%, 100% {
            transform         : scaleY(0.4);
            -webkit-transform : scaleY(0.4);
        }
        20% {
            transform         : scaleY(1.0);
            -webkit-transform : scaleY(1.0);
        }
    }

    .text-green {
        color : $brand-success !important;
    }

</style>