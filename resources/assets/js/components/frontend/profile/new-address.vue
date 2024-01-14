<template>
    <div>
        <modal v-if="showModal">
            <h3 slot="header">{{$t('Add New Address')}}
                <span class="btn pull-left btn-sm" @click="showModal = false">
                        <span class="glyphicon glyphicon-remove"></span>
                    </span>
            </h3>
            <div slot="body" class="form-horizontal">
                <div class="form-group">
                    <label for="first_name" class="col-sm-3 control-label required">{{$t('First Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="first_name" id="first_name" class="form-control"
                               v-model="form.first_name"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-sm-3 control-label required">{{$t('Last Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="last_name" id="last_name" class="form-control" v-model="form.last_name"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="countries" class="col-sm-3 control-label required">{{$t('Country')}}</label>
                    <div class="col-sm-9">
                        <select name="country_id" id="countries" class="form-control" v-model="form.country_id"
                                required>
                            <option selected disabled>{{$t('Select')}}</option>
                            <option v-for="country in countries" :value="country.id" v-text="country.theName"></option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cities" class="col-sm-3 control-label required">{{$t('City')}}</label>
                    <div class="col-sm-9">
                        <select name="city_id" id="cities" class="form-control" required v-model="form.city_id">
                            <option selected disabled>{{$t('Select')}}</option>
                            <option v-for="city in cities" :value="city.id"
                                    v-text="city.theName"></option>
                        </select>
                    </div>
                </div>
                 <div class="form-group" v-if="districts.length">
                    <label for="districts" class="col-sm-3 control-label required">{{$t('District')}}</label>
                    <div class="col-sm-9">
                        <select name="district_id" id="districts" class="form-control" required v-model="form.district_id">
                            <option selected disabled>{{$t('Select')}}</option>
                            <option v-for="district in districts" :value="district.id"
                                    v-text="district.name_ar"></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="details" class="col-sm-3 control-label">{{$t('Description')}}</label>
                    <div class="col-sm-9">
                        <textarea type="text" name="details" id="details" class="form-control" v-model="form.details"
                                  ></textarea>
                    </div>
                </div>

            </div>
            <div class="text-left" slot="footer">
                <button class="btn btn-primary" @click="storeAddress">{{$t('Save')}}</button>
            </div>
        </modal>

    </div>
</template>

<script>
    export default {
        props   : ['addresses', 'route'],
        data() {
            return {
                showModal   : false,
                countries   : [],
                form        : {
                    first_name: null,
                    last_name : null,
                    country_id: null,
                    city_id   : null,
                    district_id  : null,
                    details   : null
                },
                address_list: []
            }
        },
        mounted(){
            // this.addAddress()
            this.form.country_id = 1
        },
        computed: {
            cities() {
                if (this.countries.length) {
                    return this.countries.find(country => { return country.id === this.form.country_id}).cities
                } else {
                    return [];
                }
            },
            districts() {
                if (this.form.city_id && this.cities.length) {
                    return this.cities.find(
                        city => { return city.id === this.form.city_id}).districts
                } 
                return [];
                
            }
        },

        methods: {
            addAddress() {
                axios.get('/countries').then(res => {
                    this.countries = res.data.countries
                })
                this.showModal = true
            },
            storeAddress() {
                //Todo : Make Validation

                axios.post(this.route, this.form).then(respond => {
                    console.log(respond)
                    if (respond.data) {

                        this.form = {
                            first_name: null,
                            last_name : null,
                            country_id: null,
                            city_id   : null,
                            district_id  : null,
                            details   : null
                        }

                        this.showModal = false
                        window.location.reload()
                        // this.$parent.getAddresses()
                    }
                })

            }

        }
    }
</script>
<style lang="sass" scoped>

    textarea
        resize : none

    .control-label.required:after 
        content : '*';
        color   : red;
    
</style>