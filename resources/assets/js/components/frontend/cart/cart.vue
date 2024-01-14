<template>
    <div class="wrapper">
        <template v-if="items.length">
            <h4 class="text-right text-bold text-primary">{{$t('Shopping Cart')}}</h4>
            <br>
            <template v-for="(item,index) of items" v-if="item.type === 'product'">
                <div class="product"> <!--grid-->
                    <div class="a">
                        <a :href="'/products/'+item.id">
                            <img :src="item.thumbnail"
                                 onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';"/>
                        </a>
                    </div>
                    <div class="b">
                        <a :href="'/products/'+item.id" v-text="item.theName" class="name h5 text-bold text-dark"></a>
                        <div v-if="item.propertyType === 'color'" :style="{backgroundColor:item.propertyValue}" class="cart-property-type-color"></div>
                        <span v-else style="font-size:1.2em">  {{item.propertyValue}}  </span>
                    </div>
                    <div class="c">
                        <span v-text="item.manufacturer ? item.manufacturer.name:''" class="name text-dark"></span>
                        <br/>
                        <span v-text="item.option ? item.option.name:''" class="name text-dark"></span>
                    </div>
                    <div class="d">
                        <span v-text="item.quantity" class="quantity text-dark"></span>
                    </div>
                    <div class="e">
                        <span v-text="item.option ? item.option.original_price : item.finalPrice + 'ر.س.'" class="price text-dark"></span>
                    </div>
                    <div class="f">
                        <i @click="removeFromCart(item)" class="fi flaticon-cancel"></i>
                    </div>
                </div>

            </template>
            <template v-else>
                <cart-package :item="item"></cart-package>

            </template>
            <a href="/checkout" class="btn btn-primary btn-block checkout">{{$t('Checkout')}}</a>
            <button @click="clearCart" class="btn btn-block btn-default ">{{$t('Clear Cart')}}</button>
        </template>
        <template v-else>
            <p class="note">{{$t('Cart Empty')}}!</p>
        </template>
    </div>
</template>

<script>

    import CartPackage from './cart-package'

    export default {
        components: {CartPackage},
        data() {
            return {
                items   : [],
                products: []
            }
        },
        mounted() {
            this.updateTotalPrice()

        },
        computed  : {
        },
        methods   : {
            show() {
                this.products = this.$store.getters.getCartItems
            },
            addCartItem(item) {
                if (item.type === 'product') {
                    let index = item.property_value_id ?
                        this.findItemWithPropertyIndex(item) : this.findItemIndex(item);

                    if (index === -1) {
                        const payload = {id: [item.id], option_id: [item.option_id]}
                        if(item.property_value_id) payload.property_value_id = item.property_value_id
                        axios.post('/products-by-id',payload).then(products => {

                            products.data[0].quantity = item.quantity ? item.quantity : 1;
                            if (item.option_id) products.data[0].option_id = item.option_id

                            if(item.property_value_id){
                                const propertyValue = products.data[0].property_values.filter(x =>x.id === item.property_value_id)[0]
                                products.data[0].maxQuantity = propertyValue.pivot.stock
                                products.data[0].propertyType = propertyValue.property.type
                                products.data[0].propertyValue = this.$t('direction_end') === 'left'? propertyValue.value : propertyValue.value_en
                                products.data[0].property_value_id = item.property_value_id
                            }
                            this.items.push(products.data[0]);
                            this.updateTotalPrice()
                        })
                    } else {
                        this.items[index].quantity = item.quantity ? (this.items[index].quantity + item.quantity) : //old quantity + new quantity
                                                     (this.items[index].quantity + 1); //old quantity + 1
                        this.updateTotalPrice()
                    }
                } else { //PACKAGES
                    let index = this.findItemIndex(item);

                    if (index === -1) {
                        axios.get('/package-by-id/' + item.id).then(res => {
                            res.data.quantity = item.quantity ? item.quantity : 1;
                            this.items.push(res.data);
                            this.updateTotalPrice()
                        })
                    } else {
                        this.items[index].quantity = item.quantity ? (this.items[index].quantity + item.quantity) : //old quantity + new quantity
                                                     (this.items[index].quantity + 1); //old quantity + 1
                        this.updateTotalPrice()
                    }
                }


            },
            getQuantity(item, propertyValueId = null){
                if (this.items.length) {
                    var anItem = null
                    if(propertyValueId){
                        anItem = this.items.find( i => item.id === i.id && item.type === i.type && i.property_value_id === propertyValueId)
                    }else{
                         anItem = this.items.find(i => {
                           return (item.id === i.id && item.type === i.type && (i.option_id ? i.option_id === item.option_id : true))
                       })
                    }

                    return anItem ? anItem.quantity : 0
                } else {
                    return 0
                }
            },

            /**
             * Get the total quantity of a product that have more than a property value.
             * ex: if the cart have two "Mug", the first is `red`, the second is `bule` , it return 2 
             * @param item , a product that excepected to have one or more property value
             * @returns Integer, the total sum of the quantities of that product in the cart
             */
            getTotalQuantity(item){
                if (!this.items.length) return 0;
                if(this.items.length == 1) return (this.items[0].id == item.id && this.items[0].type == item.type) ? this.items[0].quantity : 0;
                return this.items.reduce(function(a,b){
                    b = (item.id == b.id && item.type == b.type) ? b.quantity : 0;
                    return a + b;
                }, 0);
            },

            removeFromCart(item) {
                this.$store.dispatch('removeFromCart', item);
                let i = item.property_value_id ? this.findItemWithPropertyIndex(item): this.findItemIndex(item);
                this.items.splice(i, 1);
                this.updateTotalPrice()

            },
            clearCart() {
                this.items = []
                this.$store.dispatch('clearCart');

            },
            updateTotalPrice() {
                let total = 0;
                this.items.forEach(item => {
                    if (item.type === 'product') {
                        total += parseInt(( item.option ? item.option.original_price : item.finalPrice )) * item.quantity
                    } else {
                        total += parseInt(item.price) * item.quantity
                    }

                });
                this.$store.commit('updateTotalPrice', total)
            },
            getCartItems() {
                return this.items;
            },
            findItemIndex(item) {
                return this.items.findIndex(i => {
                    return (item.id === i.id && item.type === i.type && (item.option_id ? item.option_id === i.option_id : true))
                });
            },
            findItemWithPropertyIndex(item){
                return this.items.findIndex(i => item.id === i.id && item.type === i.type && item.property_value_id === i.property_value_id )
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
        grid-gap : 0 15px
        align-items : stretch
        margin : 0 0 20px 0

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
            border : 1px solid lightgray
            padding : 0 15px
            border-radius : 3px
            text-align : center
            font-size : 13px
            display : flex
            justify-content : center
            align-items : center
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

    .note
        font-size : 15px
    .cart-property-type-color
        border: 1px solid #cacaca
        width: 16px
        height: 16px
        display: inline-block
        border-radius: 8px
        vertical-align: middle
        margin: 0 15px
</style>