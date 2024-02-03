<template>
    <div class="product-container col-md-4">
        <a v-bind:href="'/products/'+product.id">
            <img :src="product.largeThumbnail" loading="lazy"/>
            <div class="name">
                {{product.theName}}
            </div>
        </a>
        <div class="price">
            <div class="finalPrice">
                {{product.finalPrice}} {{ $t('SAR') }}
            </div>
            <div class="originalPrice">
                <template v-if="product.price_after_discount || product.dailyDealPrice">
                    <span class="old-price no-margin" v-text="product.original_price + ' ' +$t('SAR')"></span>
                </template>
            </div>
        </div>
        <div class="addToCart">
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
                @click="$parent.addToCart(product,currentQuantity)">
                <i class="fi flaticon-bag"></i>
                <span v-if="currentQuantity >= product.maxQuantity">نفدت الكمية</span>
                <span v-else>{{$t('Add to cart')}}</span>
            </button>
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

    .product-container
        margin-bottom: 25px
        line-height: 1.5
        img
            width : 100%
            height: 400px
            background-color: #eee 
            object-fit : cover
            border-radius: 25px
            
        .name
            font-size: 24px
            padding-top: 5px
            font-weight: 900
        .price
            display: flex
            flex-direction: row
            align-items: center
            justify-content: space-between
            padding-bottom: 15px
            .finalPrice
                padding-top: 5px
                font-weight: 200
                font-size: 24px
            .originalPrice
                padding-top: 0px
                font-weight: 200
                font-size: 16px
                text-decoration: line-through
                color: $brand-danger

        .add-to-cart
            padding: 1em 2.1em 1.1em
            border-radius: 50px
            font-weight: 800
            font-size:  1.2em
            border: 3px solid transparent
            box-shadow: 0em -0.4rem 0em $brand-primary inset
            transition: all 0.3s ease-in-out
            
            &:hover
                background-color: $brand-secondary
                color: $brand-primary
                border: 3px solid $brand-primary

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
