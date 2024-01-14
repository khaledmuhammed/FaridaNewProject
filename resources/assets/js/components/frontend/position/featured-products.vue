<template>
        <div class="featured-products">
            <div class="title text-primary">
                <span>{{featuredProducts.theTitle}}</span>
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
            })
        },
        methods   : {
        }
    }
</script>
<style scoped lang="sass">
    /*@import "~styles/frontend/variables"*/

    .featured-products
        margin-top : 100px

        .title
            font-size : 20px
            margin : -70px 0 0 0
            font-family : Bold
            position : relative
            height: 80px
            background-repeat: no-repeat;
            text-align: center;

            span
                background : white
                padding : 0 20px
                position : absolute
                margin : auto
                right : 0
                left : 0
</style>
