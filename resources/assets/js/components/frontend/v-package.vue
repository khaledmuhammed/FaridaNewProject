<template>
    <div>
        <template v-if="show" name="slide-fade">
            <div class="col-sm-12 margin-top">
                <div class="col-sm-6 col-xs-12">
                    <img :src="item.thumbnail" width="100%" />
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="col-xs-12 no-padding">
                        <h2 class="name">{{item.theName}}</h2>
                        <p class="description">{{item.theDescription}}</p>
                        <div v-if="item.shipping_free == 1" class="text-red">
                            <br>
                            <p>** توصيل مجاني **</p>
                        </div>
                        <br><br>
                        <span class="originalPrice">
                            {{(Number(item.originalPrice) + (Number(item.originalPrice) * 0.15)).toFixed(2)}} {{$t('SAR')}}
                        </span>
                        <!-- <span class="label-primary discount-persntg">{{(100 - (item.price / item.originalPrice * 100)).toFixed(2)}}%</span> -->
                        <br>
                        <h3 class="price">
                            {{Number(item.price).toFixed(2)}} {{$t('SAR')}}
                        </h3>
                        <p class="vat">{{$t('VAT included')}}</p>
                        <!-- <p class="vat">{{$t('Price without VAT')}} : {{item.price}} {{$t('SAR')}}</p> -->
                        <div class="col-sm-12 col-xs-12 no-padding margin">
                            <datetime
                                type="time"
                                v-model="delivery_time"
                                :format="{ hour: 'numeric', minute: '2-digit'}"
                                :phrases="{ok: 'تأكيد', cancel: 'إلغاء'}"
                                :minute-step="5"
                                placeholder="وقت التوصيل"
                                use12-hour>
                            </datetime>
                            <p style="color: rgba(0,0,0,0.5)">التوصيل بعد ساعتين كحد أدنى</p>
                            <p class="errorMsg">{{$t(errorMsgTime)}}</p>
                            
                        </div>
                        <div class="col-sm-12 col-xs-12 no-padding">
                            <select class="form-control" v-model="delivery_day" required >
                                <option selected disabled value="">يوم التوصيل</option>
                                <option value="Sunday">{{$t("Sunday")}}</option>
                                <option value="Monday">{{$t("Monday")}}</option>
                                <option value="Tuesday">{{$t("Tuesday")}}</option>
                                <option value="Wednesday">{{$t("Wednesday")}}</option>
                                <option value="Thursday">{{$t("Thursday")}}</option>
                                <option value="Friday">{{$t("Friday")}}</option>
                                <option value="Saturday">{{$t("Saturday")}}</option>
                            </select>
                            <p class="errorMsg">{{$t(errorMsgDay)}}</p>
                        </div>
                        <div class="col-sm-12 col-xs-12 no-padding">
                            <a class="add-to-cart btn btn-primary btn-block"
                            :disabled="currentQuantity(item) >= item.maxQuantity"
                            @click="addToCart(item)">
                                <i class="fi flaticon-bag"></i>
                                <span>{{$t('Add to cart')}}</span>
                            </a>
                        </div>
                        <br/>
                        <br/>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12 package-products">
                                <h5>{{$t('Package Items')}} ({{item.into_packages.length}})</h5>
                                <template v-for="(product, index) in item.into_packages">
                                    <div class="col-xs-12 no-padding product" :key="index">
                                        <a :href="`/products/${product.id}`">
                                            <span class="col-xs-2 no-padding">
                                                <img :src="product.thumbnail"
                                                onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';" />
                                            </span>
                                        </a>
                                        <span class="col-xs-10">
                                            <a :href="`/products/${product.id}`">
                                                <span class="col-xs-12 product-name">{{product.theName}}</span>
                                            </a>
                                            <span class="col-xs-12 product-quantity">{{$t('Quantity')}} : {{product.into_package_quantity}}</span>
                                        </span>
                                    </div>
                                </template>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <sweet-modal icon="success" ref="packages_modal">
                <p>
                    <span>{{$t('Has been added')}} <span class="product-name">{{$t('Package')}}</span> {{$t('to')}} <span
                            class="cart">{{$t('Cart')}}</span></span>
                </p>
                <div class="buttons margin-top">
                    <button class="btn btn-info btn-md" @click="closeModal()">{{$t('Continue shopping')}}</button>
                    <a class="btn btn-primary btn-md" href="/checkout">{{$t('Checkout')}}</a>
                </div>
            </sweet-modal>
        </template>
    </div>
</template>

<script>

    export default {
        props   : ['auth', 'size', 'item'],
        data() {
            return {
                errorMsgTime : '',
                errorMsgDay  : '',
                delivery_time : '',
                delivery_day  : ''
            }
        },
        computed: {
            show() {
                return this.item
            },
        },
        methods : {
            validation(){
                this.errorMsgTime = '';
                this.errorMsgDay  = '';

                if(!this.delivery_time && !this.delivery_day){
                    this.errorMsgTime = 'This field is required!';
                    this.errorMsgDay  = 'This field is required!';
                    return false;
                }else if(!this.delivery_time){
                    this.errorMsgTime = 'This field is required!';
                    return false;
                }else if(!this.delivery_day){
                    this.errorMsgDay  = 'This field is required!';
                    return false;
                }
                return true;
            },
            addToCart(aPackage) {
                if(this.validation()){
                    let item = {
                        id            : aPackage.id,
                        type          : 'package',
                        quantity      : 1,
                        option_id     : null,
                        max_quantity  : aPackage.maxQuantity,
                        delivery_time : this.delivery_time, // Not Work !!!
                        delivery_day  : this.delivery_day,  // Not Work !!!
                    }
                    if (this.currentQuantity(aPackage) < item.max_quantity) {
                        this.$root.$refs.cart.addCartItem(item)
                        this.$store.dispatch('addToCart', item).then(() => {
                            this.$refs.packages_modal.open()
                        })
                    }
                }
            },
            closeModal() {
                this.$refs.packages_modal.close()
            },
            currentQuantity(aPackage) {
                if (aPackage) {
                    return this.$root.$refs.cart.getQuantity(aPackage)
                } else {
                    return 0
                }
            }
        },
        mounted() {

        }

    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"

    .errorMsg
        color : red
    .margin
        margin-top: 10px
    .name
        font-family : Bold
        color : $brand-primary
        font-size : 22px
    .product
        margin-top : 10px
        margin-bottom : 20px
        .product-name, .cart
            font-size: 16px;
            color: $brand-primary
        .product-quantity
            font-size: 13px;
        .box
            padding : 0 0 20px
            border-radius : 0
            background : transparent
            text-align : center
        img
            margin : 0
            display : block
            width : 100%
            object-fit : cover
        a p, a:visited p, a:focus p, a:active p
            color : $text-color
        
        
        .manufacturer
            color : grey
            margin-bottom : 0
        .add-to-cart
            font-size : 13px
            margin-top : 10px
            margin-bottom : 5px
            border-radius : 8px
            line-height : 24px
            white-space : pre-wrap

    .originalPrice 
        color: $text-color-light
        font-size : 14px
        text-decoration: line-through;
    .price
        color : $brand-dark
    .discount 
        font-size : 12px
        color: $text-color-light
        text-decoration: line-through;

    .description
        font-size: 14px;
        color: #333;
    .labels
        position : absolute
        top : 10px
        left : 25px
        font-size : 11px
        .product-label
            margin : 0 3px 3px 0
            padding : 2px 10px
            float : left
            color : #000
            text-decoration : none
            &:hover, &:active, &:focus, &:visited
                color : #000
                text-decoration : none

    .fade-enter-active, .fade-leave-active
        transition : opacity .5s

    .fade-enter, .fade-leave-to
        opacity : 0

    .slide-fade-enter-active
        transition : all .3s ease

    .slide-fade-leave-active
        transition : all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0)

    .slide-fade-enter, .slide-fade-leave-t
        transform : translateX(10px)
        opacity : 0

    .discount-persntg
        padding : 6px
        border-radius : 5px
        color : #fff
        font-size : 9px
        text-decoration: none;


</style>
