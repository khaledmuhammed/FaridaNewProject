<template>
    <div>
        <div class="step-header" :class="{'step-success' : $store.state.checkout.address}">
            <span class="step-num ">1</span>
            <span class="step-title">{{$t('Address')}}</span>
            <!-- <p>{{$t('Select Shipping Address')}}</p> -->
        </div>
        
        <div class="row">
            <template v-for="address in address_list">
                <!-- <label @click="selectAddress(address.id)">
                    <input type="radio" :value="address.id" v-model="address_id" />
                    <span class="name">{{address.name}}</span>، 
                    <span class="city">{{address.city.name_ar}}</span>،
                    <span class="details" v-if="address.details">{{address.details}}،</span>
                    <span class="details" v-if="address.district">{{address.district}}،</span>
                    <span class="details" v-if="address.street">{{address.street}}</span>
                </label> -->
                <div class="col-md-4">
                    <div class="card" :class="{active:$store.state.checkout.address === address.id}"
                        @click="selectAddress(address.id)">
                        <b class="name-label">{{$t('Name')}}</b>
                        <span class="name">{{address.name}}</span>
                        <b class="city-label">{{$t('City')}}</b>
                        <span class="city">{{address.city.name_ar}}</span>
                        <b class="details-label">{{$t('Description')}}</b>
                        <span class="details">{{address.district.name_ar}}, {{address.details}}</span>
                    </div>
                </div>
            </template>
        </div>
        <div class="btn btn-primary" style="margin-top: 15px;" @click="addAddress()">
            <b>+ {{$t('Add New Address')}}</b>
        </div>
        <new-address ref="address" :route="route"></new-address>

    </div>
</template>

<script>

    export default {
        props  : ['addresses', 'route'],
        data() {
            return {
                address_list: [],
                address_id: null
            }
        },
        mounted() {
            this.address_list = this.addresses
            setTimeout(()=>{
                if(this.address_list[0]) this.selectAddress(this.address_list[0].id)
            }, 0)
        },
        methods: {
            selectAddress(id) {
                this.$store.state.checkout.address = id
                this.updateShippingMethods()
            },
            updateShippingMethods() {
                this.$root.$refs.shipping.getAddressShippingMethods()
            },
            addAddress() {
                this.$refs.address.addAddress()
            },
            getAddresses() {
                axios.get('/addresses').then(res => {
                    this.address_list = res.data
                })
            },


        }
    }
</script>
<style lang="scss" scoped>
    @import "~styles/frontend/variables";
    .step-header {
        p {
            font-size: 12px;
            color: #c32c3b;
            text-align: center;
        }
    }
    .card {
        display         : grid;
        grid-template   : 'name-label name' 'city-label city' 'details-label details';
        grid-column-gap : 20px;
        grid-row-gap    : 11px;
        align-items     : normal;
        justify-content : right;
        cursor          : pointer;
        font-size       : 13px;
        border-radius: 25px;
        margin        : 10px auto !important;
        padding       : 30px 10px;
        border : 3px solid transparent;
        transition: all 0.3s ease-in-out;
        .name-label {
            grid-area : name-label;
        }
        .name {
            grid-area : name;
        }
        .city-label {
            grid-area : city-label;
        }
        .city {
            grid-area : city;
        }
        .details-label {
            grid-area : details-label;
        }
        .details {
            grid-area : details;
        }
        &.active {
            border : 3px solid $brand-primary;
            box-shadow: 0em -0.4rem 0em $brand-primary inset
        }
        &:hover{
            border : 3px solid $brand-primary;
            box-shadow: 0em -0.4rem 0em $brand-primary inset
        }
    }

    .add {
        display         : flex;
        margin          : 25px auto;
        height          : 150px;
        box-shadow      : 1px 1px 8px -3px grey;
        border-radius   : 5px;
        align-items     : center;
        justify-content : center;
        text-align      : center;

    }

</style>