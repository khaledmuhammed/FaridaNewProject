<template>
    <div>
        <div :class="`col-sm-6 col-md-${size?size:'4'} col-xs-6 text-center product`">
            <div class="box ">
                <a v-bind:href="'/products/'+product.id">
                    <img :src="product.largeThumbnail"
                         onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';">
                    <div class="labels">
                        <template v-for="label in product.labels">
                            <div class="">
                                    <span v-text="label.theName" class="product-label"
                                          :style="{backgroundColor : label.color}"></span>
                                </div>
                            </template>
                        </div>
                    </a>
                    <div class="col-xs-12">
                        <h6 class="manufacturer" v-if="product.manufacturer">{{product.manufacturer.name}}</h6>
                        <p class="name">{{product.theName}}</p>
                    <h1 class="price">
                        <template v-if="product.price_after_discount || product.dailyDealPrice">
                            <span class="old-price no-margin" v-text="product.original_price + ' ر.س.'"></span>
                        </template>
                        <span v-if="product.dailyDealPrice" v-text="product.dailyDealPrice"></span>
                        <span v-else v-text="product.finalPrice"></span>
                        <span>ر.س.</span>
                    </h1>
                    <!-- <p class="vat">شامل ضريبة القيمة المضافة</p> -->
                    <template v-if="product.active_daily_deal.length">
                        <countdown :value="product.active_daily_deal[0].end_date"></countdown>
                    </template>
                    <div class="col-sm-10 col-sm-offset-1 col-xs-12 xs-no-padding">
                        <a 
                            v-if="product.property_values.length" 
                            :disabled ="currentTotalQuantity >= product.maxQuantity"
                            class="add-to-cart btn btn-primary btn-block"
                            :href="'/products/'+product.id"
                        >
                            <span>{{currentTotalQuantity >= product.maxQuantity ? "نفدت الكمية": "حدد خيار"}}</span>
                        </a>
                        <button v-else class="add-to-cart btn btn-primary btn-block"
                           :disabled="currentQuantity >= product.maxQuantity"
                           @click="addToCart(product,currentQuantity)">
                            <i class="fi flaticon-bag"></i>
                            <span v-if="currentQuantity >= product.maxQuantity">نفدت الكمية</span>
                            <span v-else>{{$t('Add to cart')}}</span>
                        </button>
                    </div>
                    <!--   <div class="col-sm-10 col-sm-offset-1" v-if="auth">
                      <template v-if="$store.state.wishlist.includes(product.id)">
                          <a class="add-to-wishlist btn btn-block no-padding"
                             @click="$store.dispatch('removeFromWishlist',product.id)">
                              <i class="glyphicon glyphicon-heart"></i>
                              <span>إزالة من قائمة الأمنيات</span>
                          </a></template>
                      <template v-else>
                          <a class="add-to-wishlist btn btn-block no-padding"
                             @click="$store.dispatch('addToWishlist',product.id)">
                              <i class="glyphicon glyphicon-heart"></i>
                              <span>أضف للأمنيات</span>
                          </a>

                      </template>
                  </div>-->
                </div>
            </div>
            <sweet-modal icon="success" ref="modal">
                <h4>
                    <span>{{$t('Has been added')}} <span class="product-name">{{product.theName}}</span> {{$t('to')}} <span
                            class="cart">{{$t('Cart')}}</span></span>
                </h4>
                <div class="buttons margin-top">
                    <button class="btn btn-info btn-lg" @click="closeModal()">{{$t('Continue shopping')}}</button>
                    <a class="btn btn-primary btn-lg" href="/checkout">{{$t('Checkout')}}</a>
                </div>
            </sweet-modal>
        </div>
    </div>
</template>

<script>
    export default {
        props   : ['product', 'size'],
        computed: {
            currentQuantity() {
                if (this.product) {
                    return this.$root.$refs.cart.getQuantity(this.product)
                } else {
                    return 0
                }
            },
            currentTotalQuantity(){
                if(! this.product) return 0;
                return this.$root.$refs.cart.getTotalQuantity(this.product);
            }

        },
        methods : {
            addToCart(product, current_quantity) {
                if (product.options.length > 0) {
                    window.location = '/products/'+product.id
                    return;
                }

                let item = {
                    id          : product.id,
                    type        : 'product',
                    quantity    : 1,
                    option_id   : product.option_id ? product.option_id : '',
                    max_quantity: product.maxQuantity,
                }
                if (current_quantity < product.maxQuantity) {
                    this.$root.$refs.cart.addCartItem(item)
                    this.$store.dispatch('addToCart', item).then(() => {
                        this.$refs.modal.open()
                    })
                }
            },
            closeModal() {
                this.$refs.modal.close()
            },
        },
        mounted() {
        }

    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"

    .product
        margin-bottom : 20px
        padding : 15px
        .box
            padding : 0 0 20px
            border-radius : 5px
            box-shadow : 0px 0px 16px 2px #ccc
            background : transparent
            .vat
                font-size: 10px
        img
            margin : 0
            display : block
            width : 100%
            object-fit : cover
        a p, a:visited p, a:focus p, a:active p
            color : $text-color
        .price
            font-size : 18px
            color : $brand-dark
            font-family : Bold
            .old-price
                text-decoration : line-through
                color : $brand-danger
                font-size: 13px
        .name
            font-family : Bold
            font-size : 16px
            color : $brand-dark
            overflow : hidden
            height : 60px
        .manufacturer
            color : grey
            margin-bottom : 0
        .add-to-cart
            font-size : 13px
            margin-top : 10px
            margin-bottom : 5px
            border-radius : 3px
            line-height : 24px
            white-space : pre-wrap
        .add-to-wishlist
            font-size : 13px
            border-radius : 8px
            margin-top : 10px
            line-height : 24px
            margin-bottom : 20px
            color : $text-color
            white-space : pre-wrap
            cursor: pointer;

    .product-name, .cart
        color : $brand-primary
        font-family : Bold

    .labels
        position : absolute
        top : 30px
        left : 16px
        font-size : 11px
        .product-label
            margin : 0 3px 3px 0
            padding : 2px 10px
            float : left
            text-decoration : none
            &:hover, &:active, &:focus, &:visited
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


</style>
