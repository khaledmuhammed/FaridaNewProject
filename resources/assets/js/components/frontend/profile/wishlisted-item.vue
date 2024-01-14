<template>

    <div class="product">
        <div class="a">
            <a :href="'/products/'+product.id">
                <img :src="product.thumbnail"
                     onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';"/>
            </a>
        </div>
        <div class="b">
            <a :href="'/products/'+product.id" v-text="product.name" class="name h5 text-bold"></a>
        </div>
        <div class="c">
            <span v-text="product.manufacturer.name" class="name"></span>
        </div>
        <div class="d">
            <span v-text="(product.price_after_discount ? product.price_after_discount : product.original_price ) + ' ر.س. '"
                  class="price"></span>
        </div>
        <div class="f">
            <i v-if="!loading" @click="toggleWishlist(product.id)" class="fi flaticon-cancel"></i>
            <font-awesome-icon icon="spinner" v-if="loading" spin></font-awesome-icon>
        </div>
    </div>
</template>

<script>
    export default {
        props  : ['product'],
        data() {
            return {
                loading: false
            }
        },
        methods: {
            toggleWishlist(id) {
                this.loading = true
                axios.post('/wishlist/' + id).then(res => {
                    this.loading = false
                    this.$parent.getItems()
                }).catch(error => {
                    this.loading = false

                })
            }

        }
    }
</script>
<style lang="sass" scoped>
    @import '~styles/frontend/variables'

    .product
        display : grid
        grid-template-areas : "a b b f" "a c c f" "a d e f"
        grid-template-columns : fit-content(70px)
        justify-content : stretch
        width : 300px
        grid-gap : 0 15px
        align-items : stretch
        margin : 20px 0

        & > div
            justify-self : start
            text-align : right
            justify-content : start
        .a
            grid-column : 1
            grid-row : 1
            grid-row-end : 4
            grid-area : a
            width : 70px
            img
                width : 100%

        .b
            grid-area : b

        .c
            grid-area : c
        .d
            grid-area : d
            font-size : 13px
            font-weight : bold
        .e
            grid-area : e
            align-content : center
            display : grid
            font-size : 13px
            font-family : Bold
        .f
            grid-area : f
            display : grid
            align-items : center
            justify-self : end
            .fi:before
                padding : 7px
                font-size : 9px
                background :
                border-radius : 50%
                cursor : pointer

            .fi:hover:before
                background : grey
                color : #fff
</style>
