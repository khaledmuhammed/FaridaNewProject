<template>
    <div class="package">
        <span class="name">
            <strong class="name">{{aPackage.name}}</strong>  &nbsp;
            <span class="price" v-text="aPackage.price + 'ر.س.'"></span>
        </span>
        <div class="products">
            <div v-for="(product) in aPackage.into_packages" class="product">
                <img :src="product.thumbnail" class=""
                     onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';"/>
            </div>
        </div>
        <div class="quantity-controller">
            <span class="plus" @click="$parent.increaseQuantity(index)">+</span>
            <span v-text="item.quantity" class="quantity "></span>
            <span class="minus" @click="$parent.decreaseQuantity(index)">-</span>
        </div>
        <div class="remove-btn">
            <i @click="$parent.removeItem(item)" class="fi flaticon-cancel"></i>
        </div>

        <p class="total" v-text="aPackage.price * aPackage.quantity + 'ر.س.'"></p>
        <hr>
    </div>
</template>

<script>

    export default {
        props   : ['items', 'item', 'index'],
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
                this.aPackage = this.items.find(i => {
                    return (this.item.id === i.id && i.type === 'package')
                });
            },
            removeItem(item) {
                this.$root.$refs.cart.removeFromCart(item)
            },

        }
    }
</script>
<style lang="sass" scoped>
    /*@import "~styles/frontend/variables"*/

    .package
        overflow : hidden
        display : grid
        grid-template : "name quantity remove" "images quantity remove" "total quantity remove"

        .products
            grid-area : images
            display : flex
            /*max-width : calc(100% - 120px)*/
            flex-wrap : wrap

        .remove-btn
            display : grid
            grid-area : remove
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

        .quantity-controller
            grid-area : quantity
            display : flex
            justify-content : space-evenly
            align-items : stretch
            flex-direction : column
            justify-self : end
            margin-right : auto
            margin-left : 15px
            text-align : center
            .quantity
                border : 1px solid lightgray
                padding : 0 15px
                border-radius : 3px
                text-align : center
                font-size : 13px
                font-weight : bold

        .product
            margin : 5px 0 5px 5px
            img
                max-width : 50px

        .plus-icon
            margin-top : 6px
            font-size : 11px
            margin-right : 0px

        .name
            grid-area : name
            display : flex
            .name
                color : #aaa
        .total
            grid-area : total
            font-size : 15px
            font-weight : bold

</style>