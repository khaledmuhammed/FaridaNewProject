<template>
    <div>
        <div class="collapse-header" v-bind:class="{'collapsed' : collapsed}" v-on:click="collapsed = !collapsed">
            <span>منتجات مجانية مع هذا المنتج</span>
        </div>
        <div v-if="!collapsed">
            <div class="product text-center" v-for="(product,index) in free_items">
                <div class="product-info">
                    <img :src="product.largeThumbnail"
                         onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';">
                    <p class="name">{{product.name}}</p>
                </div>
                <div v-if="index != free_items.length-1" class="col-xs-1 plus">
                    <span class="glyphicon glyphicon-plus"></span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['free_items'],
        data() {
            return {
                collapsed: false,
            }
        }
    }
</script>
<style lang="sass" scoped>
    /*@import "~styles/frontend/variables"*/

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


</style>