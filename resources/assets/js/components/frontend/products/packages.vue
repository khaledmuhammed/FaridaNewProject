<template>
    <div>
        <div class="collapse-header">
            <a href="#packages" class="collapsed" data-toggle="collapse" role="button">{{$t('Buy it together')}}</a>
        </div>
        <div class="collapse" id="packages">
            <div class="product text-center" v-for="(product,index) in packages[0].into_packages">
                <div class="product-info">
                    <img :src="product.thumbnail"
                         onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';">
                    <p class="name">{{product.theName}}</p>
                    <p class="name">{{product.original_price}} {{$t('SAR')}}</p>
                </div>
                <div v-if="index != packages[0].into_packages.length-1" class="col-xs-1 plus">
                    <span class="glyphicon glyphicon-plus"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row packages-price">
                <div class="col-sm-5 col-sm-offset-1 ">
                    <p class="price" v-text="packages[0].price + ' ريال '"></p>
                    <p class="discount-phrase" v-text="$t('We saved you')+` ${price} `+$t('SAR')"></p>
                </div>
                <div class="col-sm-4 col-md-3 col-sm-offset-1 col-md-offset-2 ">
                    <div class="row text-center">
                        <!-- <template v-if="packages[0].maxQuantity - currentQuantity < 6">
                            <span class="text-center text-red" >الكمية المتوفرة :  {{packages[0].maxQuantity - currentQuantity}}</span>
                        </template> -->
                        <a class="add-to-cart btn btn-primary btn-block text-secondary"
                           v-bind:disabled="currentQuantity >= packages[0].maxQuantity"
                           @click="addToCart(packages[0])">
                            <i class="fi flaticon-bag"></i>
                            <span>{{$t('Add to cart')}}</span>
                            <!--
                                <span v-if="canAddPackage">إضافة إلى السلة</span>
                                <span v-else>تم إضافة المجموعة إلى السلة</span>
                            -->
                        </a>
                    </div>
                </div>
            </div>
            <sweet-modal icon="success" ref="packages_modal" :key="1">
                <h4>
                    <span>{{$t('Package Has been added')}} {{$t('to')}} <span class="cart">{{$t('Cart')}}</span></span>
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
        props   : ['packages', 'auth', 'product'],
        data() {
            return {
                collapsed   : false,
                productAdded: false,
                countdown   : 4
            }
        },
        computed: {
            price() {
                return this.packages[0].into_packages.reduce((a, b) => {
                    // console.log(a);
                    return +a + +b.original_price;
                }, 0) - this.packages[0].price;
            },
            currentQuantity() {
                if (this.packages[0]) {
                    return this.$root.$refs.cart.getQuantity(this.packages[0])
                } else {
                    return 0
                }
            }
        },
        mounted() {

        },
        methods : {
            addToCart(packages) {
                let item = {
                    id          : packages.id,
                    type        : 'package',
                    quantity    : 1,
                    option_id   : null,
                    max_quantity: packages.maxQuantity,

                }
                if (this.currentQuantity < item.max_quantity) {
                    this.$root.$refs.cart.addCartItem(item)
                    this.$store.dispatch('addToCart', item).then(() => {
                        this.$refs.packages_modal.open()
                    })
                }

            },
            closeModal() {
                this.$refs.packages_modal.close()
            },

            startCountdown() {
                let interval = setTimeout(() => {
                    this.decreaseCountdown()
                    if (this.countdown === 0) {
                        clearInterval(interval)
                        this.closeModal()

                    }
                }, 1000);
            },
            decreaseCountdown() {
                this.countdown--
                this.startCountdown()
            }


        },
    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"

    .product
        margin-top : 10px
        margin-bottom : 10px
        float : right
        img
            height : 100px
            margin : 5px auto
            display : block
        .product-info
            float : right

    .plus
        height : 150px
        float : right
        text-align : center
        span
            line-height : 150px
            display : block
            margin : 0 auto

    .packages-price
        margin : 30px auto 40px

    .price
        font-family : Bold
        font-size : 28px
        color : $brand-primary

    .add-to-cart
        margin-top : 20px

    .warning-modal
        .product-info
            margin-top : 20px
            text-align : right

            .add-to-cart
                margin-top : 12px
            .price
                font-size : 23px

            .product-name
                color : #6d7174
                font-size : 22px
                font-family : Bold
                direction : ltr
                margin : 0

            .currency
                color : $brand-primary
                font-size : 18px
</style>