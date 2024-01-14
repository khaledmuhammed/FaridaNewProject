<template>
    <div>
        <template v-if="show" name="slide-fade">
            <template v-for="thePackage in packages">
                <div :class="`col-sm-6 col-md-${size?size:'4'} product`">
                    <div class="box">
                            <a :href="`/package/`+thePackage.id"><img :src="thePackage.thumbnail" /></a>
                            <div class="labels">
                                <template v-for="label in thePackage.products[0].labels">
                                    <div class="">
                                            <span v-text="label.theName" class="product-label"
                                                :style="{backgroundColor : label.color}"></span>
                                        </div>
                                    </template>
                                </div>
                            <div class="col-xs-12">
                                <a :href="`/package/`+thePackage.id"><p class="name">{{thePackage.theName}}</p></a>
                                <p class="description">{{thePackage.theDescription}}</p>
                            <!-- <div class="row">
                                <div class="col-xs-12 package-products">
                                    <template v-for="product in thePackage.into_packages">
                                        <div class="col-xs-12 no-padding">
                                            <a :href="`/products/${product.id}`">
                                            <span class="col-xs-2 no-padding">
                                                <img :src="product.thumbnail"
                                                onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';" />
                                            </span>
                                            <span class="col-xs-10">{{product.name}} ({{product.into_package_quantity}})</span>
                                            </a>
                                        </div>
                                    </template>
                                </div>
                            </div> -->
                            <span class="originalPrice">
                                {{Number(thePackage.originalPrice).toFixed(2)}} {{$t('SAR')}}
                            </span>

                            <h1 class="price">
                                {{Number(thePackage.price).toFixed(2)}} {{$t('SAR')}}
                            </h1>
                            <p class="vat">{{$t('VAT included')}}</p>
                            <!-- <template v-if="package.products[0].active_daily_deal.length">
                                <countdown :value="package.products[0].active_daily_deal[0].end_date"></countdown>
                            </template> -->
                            <div class="col-sm-10 col-sm-offset-1 col-xs-12">
                                <a class="add-to-cart btn btn-primary btn-block"
                                :disabled="currentQuantity(thePackage) >= thePackage.maxQuantity"
                                :href="`/package/`+thePackage.id">
                                    <i class="fi flaticon-bag"></i>
                                    <span>{{$t('More Details')}}</span>
                                </a>
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
                                    <span>إضافة إلى قائمة الأمنيات</span>
                                </a>

                            </template>
                        </div>-->
                        </div>
                    </div>
                </div>
            </template>
            <sweet-modal icon="success" ref="packages_modal">
                <h4>
                    <span>{{$t('Has been added')}} <span class="product-name">{{$t('Package')}}</span> {{$t('to')}} <span
                            class="cart">{{$t('Cart')}}</span></span>
                </h4>
                <div class="buttons margin-top">
                    <button class="btn btn-info btn-md" @click="closeModal()">{{$t('Continue shopping')}}</button>
                    <a class="btn btn-primary btn-md" href="/checkout">{{$t('Checkout')}}</a>
                </div>
            </sweet-modal>
        </template>
        <transition name="slide-fade">
            <div v-if="!show" class="text-center">
                <h3 class="no-results">{{$t('There is not package now')}}</h3>
            </div>
        </transition>
    </div>
</template>

<script>

    export default {
        props   : ['auth', 'size', 'items'],
        data() {
            return {
                packages: this.items,
            }
        },
        computed: {
            show() {
                return this.packages.length
            },
        },
        methods : {
            addToCart(aPackage) {
                let item = {
                    id          : aPackage.id,
                    type        : 'package',
                    quantity    : 1,
                    option_id   : null,
                    max_quantity: aPackage.maxQuantity,

                }

                if (this.currentQuantity(aPackage) < item.max_quantity) {
                    this.$root.$refs.cart.addCartItem(item)
                    this.$store.dispatch('addToCart', item).then(() => {
                        this.$refs.packages_modal.open()
                    })
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

    .product
        margin-top : 10px
        margin-bottom : 20px
        .box
            padding : 0 0 20px
            border-radius : 0
            background : transparent
            text-align : center
            border: 1px solid #e8e7e7;
        img
            margin : 0
            display : block
            width : 100%
            object-fit : cover
        a p, a:visited p, a:focus p, a:active p
            color : $text-color
        .originalPrice 
            color: $text-color-light
            font-size : 14px
            text-decoration: line-through;
        .price
            font-size : 18px
            color : $brand-primary
            font-family : Bold
            margin-top: 5px;
        .name
            font-family : Bold
            font-size : 16px
            color : $brand-primary
            overflow : hidden
            margin: 0;
        .description
            height: 40px;
            margin: 10px 0;
            font-size: 12px;
            color: #333;
            min-height: 70px;
            overflow: hidden;
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

        .package-products 
            text-align: right;
            min-height: 180px;

            span
                margin-bottom: 5px;

                img
                    margin-left : 10px;
        

    .product-name, .cart
        color : $brand-primary
        font-family : Bold

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


</style>
