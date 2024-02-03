<template>
        <div class="featured-products">
            <div class="title">
                {{featuredProducts.theTitle}}
            </div>
            <products-carousel v-if="products.length" :items="products" :auth="auth" :size="size"></products-carousel>
        </div>
</template>

<script>

    export default {
        props     : ['positionable', 'route', 'checkout_route', 'size'],
        data() {
            return {
                featuredProducts: [],
                products        : [],
                auth            : $("meta[name=login-status]").attr('content')

            }
        },
        mounted() {
            axios.get('/positionables/featured-products/' + this.positionable.positionable_id).then(res => {
                this.featuredProducts = res.data.featured_products
                this.products         = res.data.products
                console.log(res.data.products)
            })
        },
        methods   : {
        }
    }
</script>
<style scoped lang="sass">
    /*@import "~styles/frontend/variables"*/

    .featured-products
        margin-left : 150px
        margin-right : 150px
        margin-top : 50px
        margin-bottom : 50px
        @media (max-width: 767px)
            margin-left : 25px
            margin-right : 25px
            margin-bottom : 50px

    .title
        margin-bottom: 20px
        font-weight: 900
        font-size: 24px                

        
</style>
