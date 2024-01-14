<template>

    <div>
        <div class="row">
            <span class="manufacturer">
                <span v-if="product.manufacturer">
                {{product.manufacturer.name}}
                </span>
                <!-- <span :class="{active:isWishlisted}" class="pull-left favorite flaticon-heart fi"
                        @click="toggleWishlist(product.id)">
                </span>
                <font-awesome-icon icon="spinner" v-if="loading" spin class="pull-left favorite"></font-awesome-icon> -->
            </span>
            <h1 class="name"><strong>{{product.theName}}</strong></h1>
            <br>
            <!-- <span class="sub_description text-red"><strong>{{product.sub_description}}</strong></span> -->
            <br><br>
            <template v-if="price_after_discount || product.dailyDealPrice">
                <span class="old-price no-margin" v-text="original_price + ' ر.س.'"></span>
                <span class="label-primary discount ">{{$t('Discount')}} {{discount}}%</span>
            </template>
            <h6 class="price">
                <span v-if="product.dailyDealPrice" v-text="product.dailyDealPrice"></span>
                <span v-else v-text="price"></span>
                <span>{{$t('SAR')}}</span>
            </h6>
            <p>رمز المنتج : {{product.product_code}}</p>
            <template v-if="product.not_sold_alone">
            <p class="text-danger">هذا المنتج لا يباع وحده ، اختر معه باقة ورد</p>
            </template>
            <!-- <p>وزن المنتج : {{product.weight}}</p> -->
            <div class="product-options" v-if="product.options.length > 0">
                <template v-for="(option, index) in product.options">
                    <span :key="index" @click="selectOption(option)" :id="`option-`+option.id" class="option-class ">{{option.name}}</span>
                </template>
            </div>
            <!-- <h4 class="no-margin vat">شامل ضريبة القيمة المضافة</h4> -->
            <template v-if="product.active_daily_deal.length">
                <countdown :value="product.active_daily_deal[0].end_date"></countdown>
            </template>

            <template v-if="product.property_values.length">
                <h4>
                    {{$t('Product Properties')}} [ {{ $t('direction_end') == 'left' ? product.property_values[0].property.name : product.property_values[0].property.name_en}} ]
                </h4>
                <div 
                    v-for="(value,index) in product.property_values.sort((a,b)=>a.sort_order - b.sort_order)" 
                    :key="value.id" 
                    style="display:inline-block"
                >
                    <div v-if="value.property.type == 'selection'" style="margin:0 15px">
                        <input type="radio" :id="`property-value-${value.id}`" v-model="property_value_id" :value="value.id" style="margin:0 5px" :checked="index==0">
                        <label :for="`property-value-${value.id}`">{{$t('direction_end') == 'left' ? value.value : value.value_en}}</label>
                    </div>
                    
                    <div v-else> <!-- if the value.property.type = color -->
                        <input type="radio" :id="`property-value-${value.id}`" v-model="property_value_id" :value="value.id"  :checked="index==0" style="visibility: hidden">
                        <label :for="`property-value-${value.id}`" class="product-property-color" :style="{backgroundColor:value.value}"></label>
                    </div>
                </div>
            </template>
            <br>
            <span class="plus"
                  @click="increaseQuantity()">+
            </span>
            <input type="text" name="quantity" class="quantity " v-model="quantity">
            <span class="minus" @click="decreaseQuantity()">-</span>
            <div class="clearfix"></div>
            <p class="text-red margin-right margin-top" v-if="maxQuantity - currentQuantity < 10">الكمية المتبقية
                : {{ maxQuantity - currentQuantity}} </p>
            <br>
            <!-- <button class="add-to-cart btn btn-primary btn-block text-secondary  "
                    v-if="quantity <= 0"
                    v-on:click="whenAvailable(product.id)">
                <p class="">
                <i class="fi flaticon-bag"></i>
                <span>{{$t('Tell me when available')}}</span>
                </p>
            </button> -->
            <button class="add-to-cart btn btn-primary btn-block"
                    v-bind:disabled="currentQuantity > maxQuantity"
                    v-on:click="addToCart()">
                <i class="fi flaticon-bag"></i>
                <span v-if="currentQuantity > maxQuantity">نفدت الكمية</span>
                <span v-else>{{$t('Add to cart')}}</span>
            </button>
            <p class="hint">باختلاف طبيعة المنتج، قد يختلف المنتج النهائي عن الصورة المعروضة بنسبة بسيطة جدا</p>
            <div class="share-icons text-center">
                <!-- <social-sharing inline-template>
                    <span class="social-icons">
                        <network network="facebook">
                        <i class="fa fa-facebook-f"></i>
                        </network>
                        <network network="twitter">
                            <i class="fi flaticon-twitter"></i>
                        </network>
                        <network network="whatsapp">
                            <i class="fi flaticon-whatsapp"></i>
                        </network>
                    </span>
                </social-sharing>
                <span @click="shareEmail()">
                    <i class="fi flaticon-envelope"></i>
                </span>
                <span class="text-primary space">|</span> -->
                <template v-if="auth">
                    <template v-if="$store.state.wishlist.includes(product.id)">
                        <a class="add-to-wishlist"
                            @click="$store.dispatch('removeFromWishlist',product.id)">
                            <i class="glyphicon glyphicon-heart"></i>
                            <span>{{$t('Remove from wish list')}}</span>
                        </a>
                    </template>
                    <template v-else>
                        <a class="add-to-wishlist"
                            @click="$store.dispatch('addToWishlist',product.id)">
                            <i class="glyphicon glyphicon-heart"></i>
                            <span>{{$t('Add to wish list')}}</span>
                        </a>
                    </template>
                </template>
            </div>
        </div>

        <sweet-modal icon="success" ref="modalWhenAvailable">
            <h4>{{$t('Done')}}</h4>
            <h5>{{$t('You will be notified when the product is available on your email')}}</h5>
            <br />
            <div class="buttons margin-top">
                <button class="btn btn-info btn-lg" @click="closeModal()">{{$t('Continue shopping')}}</button>
            </div>
        </sweet-modal>

        <sweet-modal icon="warning" ref="modalWhenAvailableNotAuth">
            <h4>{{$t('Please login to notify you when the product is available')}}</h4>
            <br />
            <div class="buttons margin-top">
                <button class="btn btn-info btn-lg" @click="closeModal()">{{$t('Close')}}</button>
            </div>
        </sweet-modal>

        <sweet-modal icon="success" ref="modal">
            <h4>
                    <span>{{$t('Has been added')}} <span class="product-name">{{product.name}}</span> {{$t('to')}} <span
                            class="cart">{{$t('Cart')}}</span></span>
            </h4>
            <div class="buttons margin-top">
                <button class="btn btn-info btn-lg" @click="closeModal()">{{$t('Continue shopping')}}</button>
                <a class="btn btn-primary btn-lg" href="/checkout">{{$t('Checkout')}}</a>
            </div>
        </sweet-modal>

        <sweet-modal icon="success" ref="modalWishlist">
            <h4>
                <span>تم
                    {{isWishlisted ?'إضافة': 'إزلة'}}
                    <span class="product-name">{{product.name}}</span>
                {{isWishlisted?'إلى': 'من'}}
                    <span class="cart">قائمة أمنياتك</span>
                </span>
            </h4>
            <div class="buttons margin-top">
                <button class="btn btn-primary btn-lg" @click="closeModal()">{{$t('Continue shopping')}}</button>
            </div>
        </sweet-modal>

    </div>

</template>

<script>
    export default {
        props   : ['product', 'auth', 'wishlisted'],
        data() { 
            return {
                quantity    : 0,
                isWishlisted: false,
                loading     : false,
                price       : '',
                price_after_discount: '',
                original_price: '',
                maxQuantity : 0,
                property_value_id: this.product.property_values.length ? this.product.property_values[0].id : null,
            }
        },
        mounted() {
            this.maxQuantity           = this.product.property_values.length ?
                                         this.product.property_values[0].pivot.stock : this.product.maxQuantity
            this.quantity              = this.maxQuantity > this.currentQuantity ? 1 : 0
            this.isWishlisted          = this.product.isWishlisted
            this.price                 = this.product.finalPrice
            this.original_price        = this.product.original_price
            this.price_after_discount  = this.product.price_after_discount

            // Select first option
            if (this.product.options.length > 0) {
                this.selectOption(this.product.options[0]);
            }
            if(this.product.property_values){
                this.product.property_values.sort((a,b)=>a.sort_order - b.sort_order)
            }
        },
        computed: {
            discount() {
                return (100 - (this.price / this.original_price * 100)).toFixed(2)
            },
            currentQuantity() {
                if (this.product) {
                    return this.$root.$refs.cart.getQuantity(this.product, this.property_value_id) + this.quantity
                } 
                return 0
            }
        },
        watch:{
            property_value_id(newValue){
                this.maxQuantity = this.product.property_values.find(x => x.id == newValue).pivot.stock
                if(this.quantity > this.maxQuantity) this.quantity = this.maxQuantity
            }
        },
        methods: {
            addToCart() {
                this.$refs.modal.open()
                let item = {
                    id                  : this.product.id,
                    type                : 'product',
                    quantity            : this.quantity,
                    option_id           : this.product.option_id ? this.product.option_id : '',
                    maxQuantity         : this.maxQuantity,
                    property_value_id   : this.property_value_id
                }
                if (item.maxQuantity >= this.currentQuantity) {
                    this.$store.dispatch('addToCart', item)
                    this.$root.$refs.cart.addCartItem(item)
                }

                //reset quantity counter
                this.quantity = this.product.maxQuantity === this.currentQuantity ? 0 : 1
            },
            selectOption(option) {
                // Add active class
                var active = document.getElementsByClassName("active");
                while (active.length) active[0].classList.remove("active");
                document.getElementById('option-'+option.id).classList.add('active');

                // Select option
                this.maxQuantity           = option.quantity
                this.quantity              = this.maxQuantity > this.currentQuantity ? 1 : 0
                this.product.option_id     = option.id
                this.price                 = option.finalPrice
                this.original_price        = option.original_price
                this.price_after_discount  = option.price_after_discount
            },
            whenAvailable(id) {
                if (this.auth) {
                    this.loading = true
                    axios.post('/whenAvailable/' + id).then(res => {
                        this.isAddedToWhenAvailable = res.data.status
                        this.$refs.modalWhenAvailable.open()
                        this.loading = false
                    })
                } else {
                    this.$refs.modalWhenAvailableNotAuth.open()
                }
            },
            increaseQuantity() {
                if (this.maxQuantity > this.currentQuantity) {
                    this.quantity++
                }
            },
            decreaseQuantity() {
                this.quantity > 0 ? this.quantity-- : false
            },
            closeModal() {
                this.$refs.modal.close()
                this.$refs.modalWishlist.close()
                this.$refs.modalWhenAvailable.close()
            },
            toggleWishlist(id) {
                this.loading = true
                axios.post('/wishlist/' + id).then(res => {
                    this.isWishlisted = res.data.status
                    this.$refs.modalWishlist.open()
                })
            },
            shareEmail() {
                window.open('mailto:?subject='+this.product.name+'&body='+this.product.name+'\n\n'+window.location.href);
            }
        },
    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"

    .product-property-color 
        width: 35px 
        height: 35px 
        border: 1px solid gray
    input[type=radio]:checked 
        & + .product-property-color 
            border: 2px solid black
            scale: 1.2
            

    .manufacturer
        font-size : 14px

    .name
        color : $brand-dark
        font-size : 22px
        font-family : Bold
        display : block

    .sub_description
        font-size : 12px

    .price
        color : $brand-dark
        margin : 10px 0
        span
            font-size : 30px !important
            font-weight : bold

    .discount
        padding : 6px
        border-radius : 5px
        color : #fff
        font-size : 9px

    .old-price
        text-decoration : line-through
        color : $brand-danger

    .vat
        color : gray

    .minus, .plus
        color : #8b8d90
        font-size : 25px
        line-height : 30px
        margin : 0 15px
        cursor : pointer
        font-weight : bold

    .quantity
        border-radius : 5px
        font-size : 20px
        padding : 5px
        border : 1px solid $text-color-light
        outline : 0
        margin-top : 20px
        width : 20%
        text-align : center

    .share-icons
        margin-top: 20px;
        font-size: 16px;
        color: $brand-secondary

        .space
            margin: 0 20px;

    .add-to-wishlist
        font-size : 16px
        color : $brand-tertiary
        cursor: pointer;

        .glyphicon
            margin-left : 10px

    .product-name, .cart
        color : $brand-dark
        font-family : Bold

    .favorite
        font-size : 26px
        &.active
            color : $brand-dark

    .product-options
        span
            padding: 3px 10px;
            background: $brand-secondary;
            color: #FFF;
            margin-left: 10px;
            cursor: pointer;
        .active
            background: $brand-primary
            
    .hint
        color: rgba(0,0,0,0.8)
        font-size: 12px
        margin-top: 7px
        text-align: center
    @media #{$mobile}
        .manufacturer
            margin-top : 20px
            display : block

        .name
            color : $brand-secondary
            font-size : 15px

</style>