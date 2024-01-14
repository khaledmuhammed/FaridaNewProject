<template>
    <div>
        <!--<div class="col-xs-3 plus-icon"><span class="glyphicon glyphicon-plus"></span></div>-->
        <div class="package " v-if="aPackage">
            <div class="products">
                <div v-for="product in aPackage.into_packages" class="product">
                    <img :src="product.thumbnail"
                         onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';"/>
                </div>
            </div>
            <div class="details">
                <p v-text="aPackage.name" class="name"></p>
                <p v-text="aPackage.price + 'ر.س.'" class="price"></p>
                <p v-text="aPackage.quantity" class="quantity"></p>
            </div>
            <div class="remove-btn">
                <i @click="$parent.removeFromCart(item)" class="fi flaticon-cancel"></i>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
    </div>
</template>

<script>

    export default {
        props   : ['item'],
        data() {
            return {
                aPackage: []
            }
        },
        mounted() {
            this.findPackage()
        },
        computed: {},
        methods : {
            findPackage() {
                this.aPackage = this.item
            },
        }
    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"

    .package
        overflow : hidden
        margin-top : 5px
        margin-bottom : 5px
        display : flex
        justify-content : right
        flex-direction : row

        .products
            display : flex
            flex: 3
            flex-wrap : wrap
        .details
            flex: 2
            margin-right : auto
            text-align : right
            color : $brand-primary
            font-size : 15px
            display : flex
            flex-direction : column
            align-self : flex-end
            padding-bottom : 5px
        .price
            font-size : 13px
            font-family : Bold
        .quantity
            border : 1px solid lightgray
            padding : 5px 15px
            border-radius : 3px
            text-align : center
            font-size : 13px
            display : flex
            width : fit-content
            justify-content : center
            align-items : center
            font-weight : bold
        .remove-btn
            display: flex
            justify-content: center
            align-items : center
            .fi:before
                padding : 7px
                font-size : 9px
                background :
                border-radius : 50%
                cursor : pointer
            .fi:hover:before
                background : grey
                color : #fff


    .info
        text-align : right
        color : $brand-primary
        .name
            font-size : 15px
            font-weight : bold

    .product
        margin : 5px 0 5px 5px
        img
            max-width : 50px

    .plus-icon
        margin-top : 10px
        font-size : 16px
        margin-right : 10px


</style>