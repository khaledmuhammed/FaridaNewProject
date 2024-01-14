<template>
    <div>
        <div class="box box-inline-block-top">
            <div class="box-header text-left">
                <span class="pull-right">{{$t('My Addresses')}}</span>
                <b>
                    <button @click="addAddress" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>
                    </button>
                </b>
                <div class="clearfix"></div>
            </div>
            <div class="box-content">
                <!-- <template v-for="(address,index) of address_list">
                    <template v-if="index < 3">
                        <p class="address" v-text="'- '+address.name"></p>
                        <hr>
                    </template>
                </template> -->
                <template v-for="(address,index) of address_list">
                    <div class="col-sm-10">
                    <p class="address">{{address.name}}</p>
                    <p class="address" v-if="address.city">{{address.city.country.name_ar}}, {{address.city.name_ar}}</p>
                    <p class="address" v-if="address.district">{{address.district.name_ar}}</p>
                    <p class="address" v-if="address.details">{{address.details}}</p>
                    
                    </div>
                    <div class="col-sm-2 no-padding">
                        <a @click="editAddress(address.id)" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                        <a @click="destroyAddress(address.id)" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                    <div class="col-sm-12"><hr></div>
                    <!-- <p v-if="index === 3" class="text-center"><a href="/addresses" class="text-center">المزيد</a></p> -->
                </template>
            </div>
        </div>
        <modal v-if="showModal" @close="showModal = false">
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
                            <option v-for="country in countries" :value="country.id" v-text="country.name_ar"></option>
                        </select>
                    </div>
                </div>

                <div class="form-group" v-if="cities.length">
                    <label for="cities" class="col-sm-3 control-label required">{{$t('City')}}</label>
                    <div class="col-sm-9">
                        <select name="city_id" id="cities" class="form-control" required v-model="form.city_id">
                            <option v-for="city in cities" :value="city.id"
                                    v-text="city.name_ar"></option>
                        </select>
                    </div>
                </div>

                <div class="form-group" v-if="districts.length">
                    <label for="districts" class="col-sm-3 control-label required">{{$t('District')}}</label>
                    <div class="col-sm-9">
                        <select name="district_id" id="districts" class="form-control" required v-model="form.district_id">
                            <option v-for="district in districts" :value="district.id"
                                    v-text="district.name_ar"></option>
                        </select>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="district" class="col-sm-3 control-label required">{{$t('District')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="district" id="district" class="form-control"
                               v-model="form.district"
                               required>
                    </div>
                </div> -->

                <div class="form-group">
                    <label for="details" class="col-sm-3 control-label required">{{$t('Description')}}</label>
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
        <modal v-if="showEditModal" @close="showEditModal = false">
            <h3 slot="header">{{$t('Add New Address')}}
                <span class="btn pull-left btn-sm" @click="showEditModal = false">
                    <span class="glyphicon glyphicon-remove"></span>
                </span>
            </h3>
            <div slot="body" class="form-horizontal">
                <div class="form-group">
                    <label for="first_name" class="col-sm-3 control-label required">{{$t('First Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="first_name" id="first_name" class="form-control"
                               v-model="editForm.first_name"
                               required>
                        <template v-if="errors.first_name">
                            <span class="text-danger">
                                <strong>{{ errors.first_name[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-sm-3 control-label required">{{$t('Last Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="last_name" id="last_name" class="form-control" v-model="editForm.last_name"
                               required>
                        <template v-if="errors.last_name">
                            <span class="text-danger">
                                <strong>{{ errors.last_name[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>
                <div class="form-group">
                    <label for="countries" class="col-sm-3 control-label required">{{$t('Country')}}</label>
                    <div class="col-sm-9">
                        <select name="country_id" id="countries" class="form-control" v-model="editForm.country_id"
                                required>
                            <option v-for="country in countries" :value="country.id" v-text="country.name_ar"></option>
                        </select>
                    </div>
                </div>

                <div class="form-group" v-if="cities.length">
                    <label for="cities" class="col-sm-3 control-label required">{{$t('City')}}</label>
                    <div class="col-sm-9">
                        <select name="city_id" id="cities" class="form-control" required v-model="editForm.city_id">
                            <option v-for="city in cities" :value="city.id"
                                    v-text="city.name_ar"></option>
                        </select>
                        <template v-if="errors.city_id">
                            <span class="text-danger">
                                <strong>{{ errors.city_id[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>
                <div class="form-group" v-if="districts.length">
                    <label for="districts" class="col-sm-3 control-label required">{{$t('District')}}</label>
                    <div class="col-sm-9">
                        <select name="district_id" id="districts" class="form-control" required v-model="editForm.district_id">
                            <option v-for="district in districts" :value="district.id"
                                    v-text="district.name_ar"></option>
                        </select>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="district" class="col-sm-3 control-label required">{{$t('District')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="district" id="district" class="form-control" v-model="editForm.district"
                               required>
                        <template v-if="errors.district">
                            <span class="text-danger">
                                <strong>{{ errors.district[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div> -->

                <div class="form-group">
                    <label for="details" class="col-sm-3 control-label required">{{$t('Description')}}</label>
                    <div class="col-sm-9">
                        <textarea type="text" name="details" id="details" class="form-control" v-model="editForm.details"
                                  required></textarea>
                        <template v-if="errors.details">
                            <span class="text-danger">
                                <strong>{{ errors.details[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>
            </div>
            <div class="text-left" slot="footer">
                <button class="btn btn-primary" @click="updateAddress(editForm.id)">
                    <strong v-if="!isLoading">{{$t('Update')}}</strong>
                    <div class="spinner" v-else>
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                    </div>
                </button>
            </div>
        </modal>
        <sweet-modal icon="success" ref="addAddressModal">
            <h4>
                <span>{{$t('Address successfully added')}}</span>
            </h4>
            <div class="buttons margin-top">
                <button class="btn btn-primary btn-md" @click="closeAddAddressModal()">{{$t('Continue')}}</button>
            </div>
        </sweet-modal>
        <sweet-modal icon="success" ref="editAddressModal">
            <h4>
                <span>{{$t('Address successfully updated')}}</span>
            </h4>
            <div class="buttons margin-top">
                <button class="btn btn-primary btn-md" @click="closeEditAddressModal()">{{$t('Continue')}}</button>
            </div>
        </sweet-modal>
        <sweet-modal icon="success" ref="deleteAddressModal">
            <h4>
                <span>{{$t('Address successfully deleted')}}</span>
            </h4>
            <div class="buttons margin-top">
                <button class="btn btn-primary btn-md" @click="closeDeleteAddressModal()">{{$t('Continue')}}</button>
            </div>
        </sweet-modal>
        <sweet-modal icon="warning" ref="cannotDeleteAddressModal">
            <h4>
                <span>{{$t('This address cannot be deleted because it is associated with a previous order')}}</span>
            </h4>
            <div class="buttons margin-top">
                <button class="btn btn-primary btn-md" @click="closeCannotDeleteAddressModal()">{{$t('Continue')}}</button>
            </div>
        </sweet-modal>
        <!-- <new-address ref="address" :route="route"></new-address> -->
        <!--
                <modal v-if="showModal" @close="showModal = false">
                    <h3 slot="header">عنوان جديد</h3>
                    <div slot="body" class="form-horizontal">
                        <div class="form-group">
                            <label for="first_name" class="col-sm-3 control-label">الاسم الأول</label>
                            <div class="col-sm-9">
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                       v-model="form.first_name"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-sm-3 control-label">الاسم الأخير</label>
                            <div class="col-sm-9">
                                <input type="text" name="last_name" id="last_name" class="form-control" v-model="form.last_name"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="countries" class="col-sm-3 control-label">الدولة</label>
                            <div class="col-sm-9">
                                <select name="country_id" id="countries" class="form-control" v-model="form.country_id"
                                        required>
                                    <option v-for="country in countries" :value="country.id" v-text="country.name_ar"></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" v-if="cities.length">
                            <label for="cities" class="col-sm-3 control-label">المدينة</label>
                            <div class="col-sm-9">
                                <select name="city_id" id="cities" class="form-control" required v-model="form.city_id">
                                    <option v-for="city in cities" :value="city.id"
                                            v-text="city.name_ar"></option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="details" class="col-sm-3 control-label">وصف</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="details" id="details" class="form-control" v-model="form.details"
                                          required></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="text-left" slot="footer">
                        <button class="btn btn-success" @click="storeAddress">حفظ</button>
                    </div>
                </modal>
        -->

    </div>
</template>

<script>
    export default {
        props   : ['addresses', 'route'],
        data() {
            return {
                showModal   : false,
                showEditModal: false,
                countries   : [],
                isLoading: false,
                errors: {
                    first_name: null,
                    last_name : null,
                    country_id: null,
                    city_id   : null,
                    district  : null,
                    details   : null
                },
                form        : {
                    first_name: null,
                    last_name : null,
                    country_id: null,
                    city_id   : null,
                    district_id  : null,
                    details   : null
                },
                editForm     : {
                    first_name: null,
                    last_name : null,
                    country_id: null,
                    city_id   : null,
                    district_id: null,
                    details   : null,
                    id        : null
                },
                address_list: []
            }
        },
        computed: {
            cities() {
                if(this.form.country_id){
                    return this.countries.find(country => { return country.id === this.form.country_id}).cities
                }else if(this.editForm.country_id){
                    return this.countries.find(country => { return country.id === this.editForm.country_id}).cities
                } else {
                    return [];
                }
            },
            districts() {
                if (this.form.city_id && this.cities.length) {
                    return this.cities.find(
                        city => { return city.id === this.form.city_id}).districts
                } else if(this.editForm.city_id && this.cities.length){
                    return this.cities.find(
                        city => { return city.id === this.editForm.city_id}).districts
                }
                return [];
                
            }
        },
        mounted() {
            this.address_list = this.addresses
        },
        methods : {
            getAddresses() {
                axios.get('/addresses').then(res => {
                    this.address_list = res.data
                })
            },
            addAddress() {
                // console.log(this.addresses);
                axios.get('/countries').then(res => {
                    this.countries = res.data.countries
                    this.showModal = true
                })
            },
            editAddress(id) {
                // console.log(this.addresses);
                axios.get('/countries').then(res => {
                    this.countries = res.data.countries
                    this.theEditAddress = this.address_list.find(address => { return address.id === id})
                    this.editForm = {
                        first_name: this.theEditAddress.first_name,
                        last_name : this.theEditAddress.last_name,
                        country_id: this.theEditAddress.city.country_id,
                        city_id   : this.theEditAddress.city_id,
                        district_id: this.theEditAddress.district_id,
                        details   : this.theEditAddress.details,
                        id        : this.theEditAddress.id
                    }
                    this.showEditModal = true
                })
            },
            storeAddress() {
                //Todo : Make Validation

                axios.post(this.route, this.form).then(respond => {
                    console.log(respond)
                    if (respond.data) {
                        this.address_list = respond.data

                        this.form = {
                            first_name: null,
                            last_name : null,
                            country_id: null,
                            city_id   : null,
                            district_id  : null,
                            details   : null
                        }

                        this.showModal = false
                        // this.$refs.addAddressModal.open()
                        location.reload()
                    }
                })

            },
            updateAddress(id) {
                if (this.isLoading) {
                    return;
                }
                this.errors = {
                    first_name: null,
                    last_name : null,
                    country_id: null,
                    city_id   : null,
                    district  : null,
                    details   : null
                },
                this.isLoading = true;
                if (this.editForm) {
                    axios.post('/addresses/update/'+id, this.editForm).then(respond => {
                        if (respond.data) {
                            this.editForm = {
                                first_name: null,
                                last_name : null,
                                country_id: null,
                                city_id   : null,
                                details   : null,
                                district  : null,
                                id        : null
                            }
                            this.address_list = respond.data
                            this.showEditModal = false
                            this.$refs.editAddressModal.open()
                        }
                    }).catch(errors => {
                        console.log(errors.response.data.errors)
                        this.errors = errors.response.data.errors
                    }).finally(f => {
                        this.isLoading = false;
                    })
                }
            },
            destroyAddress(id) {
                if (this.editForm) {
                    axios.get('/addresses/destroy/'+id).then(respond => {
                        // console.log(respond.data)
                        if (respond.data) {
                            if (respond.data.status && respond.data.status == 0) {
                                this.$refs.cannotDeleteAddressModal.open()
                                return;
                            }
                            // this.$refs.deleteAddressModal.open()
                            // this.address_list = respond.data
                            location.reload()
                        }
                    })
                }
            },
            closeAddAddressModal(){
                this.$refs.addAddressModal.close()
            },
            closeEditAddressModal(){
                this.$refs.editAddressModal.close()
            },
            closeDeleteAddressModal(){
                this.$refs.deleteAddressModal.close()
            },
            closeCannotDeleteAddressModal(){
                this.$refs.cannotDeleteAddressModal.close()
            }
        }
    }
</script>
<style lang="sass" scoped>

    .control-label.required:after 
        content : '*';
        color   : red;
    textarea
        resize : none

    p 
        margin: 0;

    .spinner 
        margin     : 0 auto;
        width      : 50px;
        height     : 24px;
        text-align : center;
        font-size  : 10px;
    

    .spinner > div 
        background-color  : #fff;
        height            : 100%;
        width             : 6px;
        display           : inline-block;

        -webkit-animation : sk-stretchdelay 1.2s infinite ease-in-out;
        animation         : sk-stretchdelay 1.2s infinite ease-in-out;
    

    .spinner .rect2 
        -webkit-animation-delay : -1.1s;
        animation-delay         : -1.1s;
    

    .spinner .rect3 
        -webkit-animation-delay : -1.0s;
        animation-delay         : -1.0s;
    

    .spinner .rect4 
        -webkit-animation-delay : -0.9s;
        animation-delay         : -0.9s;
    

    .spinner .rect5 
        -webkit-animation-delay : -0.8s;
        animation-delay         : -0.8s;
    

    @-webkit-keyframes sk-stretchdelay 
        0%, 40%, 100% 
            -webkit-transform : scaleY(0.4)
        
        20% 
            -webkit-transform : scaleY(1.0)
        
    

    @keyframes sk-stretchdelay 
        0%, 40%, 100% 
            transform         : scaleY(0.4);
            -webkit-transform : scaleY(0.4);
        
        20% 
            transform         : scaleY(1.0);
            -webkit-transform : scaleY(1.0);
</style>