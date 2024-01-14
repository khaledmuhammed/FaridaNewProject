<template>
    <div>
        <transition-group name="slide-fade">
        <template v-for="(product,index) in products">
         <v-product v-if="show" :key="index" :product="product" :size="size">
            </v-product>
        </template>
           
        </transition-group>
        <transition name="slide-fade">
            <div v-if="!show" class="text-center">
                <h3 class="no-results"> {{$t('No products found')}}</h3>
            </div>
        </transition>
    </div>
</template>

<script>

    export default {
        props   : ['auth', 'size', 'items', 'category_id'],
        data() {
            return {
                products: this.items,
            }
        },
        computed: {
            show() {
                return this.products.length
            },
        },
        methods : {
            filterProducts(filterOptions) {
                axios.post('/categories/' + this.category_id, {'filter_options': filterOptions}).then(res => {
                    this.products = res.data;
                })
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
        img
            margin : 0
            display : block
            width : 100%
            object-fit : cover
        a p, a:visited p, a:focus p, a:active p
            color : $text-color
        .price
            font-size : 18px
            color : $brand-primary
            font-family : Bold
        .name
            font-family : Bold
            font-size : 16px
            color : $brand-primary
            height : 50px
            overflow : hidden
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
