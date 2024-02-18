<template>
    <div>
        <template v-if="show" name="slide-fade">
            <template v-for="thePackage in packages">
                <div :class="` col-md-4 product-container`">
                            <a v-bind:href="'/products/'+thePackage.id">
                                <img :src="thePackage.thumbnail" loading="lazy" />
                                <div class="name">
                                    {{thePackage.theName}}
                                </div>
                            </a>
                            <p class="description">{{thePackage.theDescription}}</p>
                            
                            <div class="price">
                                <div class="finalPrice">
                                    {{Number(thePackage.price).toFixed(2)}} {{$t('SAR')}}
                                </div>
                                <div class="originalPrice">
                                    {{Number(thePackage.originalPrice).toFixed(2)}} {{$t('SAR')}}
                                </div>
                            </div>
                            
                           
                            <div class="addToCart">
                                <a class=" btn btn-primary btn-block"
                                :disabled="currentQuantity(thePackage) >= thePackage.maxQuantity"
                                :href="`/package/`+thePackage.id">
                                    <i class="fi flaticon-bag"></i>
                                    <span>{{$t('More Details')}}</span>
                                </a>
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
