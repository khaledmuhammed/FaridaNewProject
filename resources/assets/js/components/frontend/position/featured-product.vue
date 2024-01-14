<template>
    <div>
        <div class="text-center product">
            <div class="box" dir="rtl">
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
                    <h6 v-if="product.manufacturer" class="manufacturer">{{product.manufacturer.name}}</h6>
                    <p class="name">{{product.theName}}</p>
                    <h1 class="price">
                        <template v-if="product.price_after_discount || product.dailyDealPrice">
                            <span class="old-price no-margin" v-text="product.original_price + ' ر.س.'"></span>
                        </template>
                        <span v-if="product.dailyDealPrice" v-text="product.dailyDealPrice"></span>
                        <span v-else v-text="product.finalPrice"></span>
                        <span>{{$t('SAR')}}</span>
                    </h1>
                    <p class="vat">{{$t('VAT included')}}</p>
                    <template v-if="product.active_daily_deal.length">
                        <countdown :value="product.active_daily_deal[0].end_date"></countdown>
                    </template>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-10 col-sm-offset-1 ">
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
                       @click="$parent.$parent.addToCart(product,currentQuantity)">
                        <i class="fi flaticon-bag"></i>
                        <span v-if="currentQuantity >= product.maxQuantity">نفدت الكمية</span>
                        <span v-else>{{$t('Add to cart')}}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props   : ['product'],
        data() {
            return {
            }
        },
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
        padding : 15px
        .box
            padding : 0 0 20px
            border-radius : 0
            background : transparent
            box-shadow : 0px 0px 16px 2px #ccc
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
                font-size: 13px
                text-decoration : line-through
                color : $brand-danger
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

    .product-name, .cart
        color : $brand-primary
        font-family : Bold

    .labels
        position : absolute
        top : 30px
        left : 24%
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

</style>
