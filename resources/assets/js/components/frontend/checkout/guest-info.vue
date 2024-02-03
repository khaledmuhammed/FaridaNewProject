<template>

    <div>
        <div class="step-header" :class="{'step-success' : $store.state.checkout.address}">
            <span class="step-num ">1</span>
            <span class="step-title">بيانات العميل</span>
        </div>
        <p class="">لإكمال الطلب يرجى <a class="btn btn-primary btn-sm " @click="showLogin">تسجيل
            الدخول</a>
        </p>
        <p class="">ولإكمال الطلب <b>كزائر</b> يمكنك تعبئة البيانات التالية:</p>
        <div>
            <form class="form-horizontal">
                <div :class="`form-group ${errors['guest_info.username ']? ' has-error' : '' }`">
                    <label for="username" class="col-md-2  required">الاسم</label>

                    <div class="col-md-4">
                        <input id="username" type="text" class="form-control" name="username"
                               v-model="$store.state.checkout.guest_info.username" required autofocus>

                        <template v-if="errors['guest_info.username']">
                            <span class="help-block">{{ errors['guest_info.username'][0] }}</span>
                        </template>
                    </div>
                </div>
                <div :class="`form-group ${errors['guest_info.email']? ' has-error' : '' }`">
                    <label for="email" class="col-md-2 ">البريد الالكتروني</label>

                    <div class="col-md-4">
                        <input id="email" type="email" class="form-control" name="email"
                               v-model="$store.state.checkout.guest_info.email" autofocus>
                               <span class="text-red">إذا كنت ترغب في متابعة طلبك ، برجاء إدخال البريد الالكتروني</span>

                        <template v-if="errors['guest_info.email']">
                            <span class="help-block">{{ errors['guest_info.email'][0] }}</span>
                        </template>
                    </div>
                </div>
                <div :class="`form-group ${errors['guest_info.mobile']? ' has-error' : '' }`">
                    <label for="mobile" class="col-md-2  required">الجوال</label>

                    <div class="col-md-4">
                        <input id="mobile" type="tel" class="form-control" name="mobile"
                               v-model="$store.state.checkout.guest_info.mobile" required autofocus>
                        <span class="text-red">بالصيغة الدولية 9665xxxxxxxxx، بدون إضافة الصفر 00 في البداية</span>
                        <template v-if="errors['guest_info.mobile']">
                            <span class="help-block">{{ errors['guest_info.mobile'][0] }}</span>
                        </template>
                    </div>
                </div>
                <!-- <div :class="`form-group ${errors['guest_info.address_owner']? ' has-error' : '' }`">
                    <label for="address_owner" class="col-md-2  required">اسم مستلم الشحنة</label>

                    <div class="col-md-4">
                        <input id="address_owner" type="text" class="form-control" name="address_owner"
                               v-model="$store.state.checkout.guest_info.address_owner" required autofocus>

                        <template v-if="errors['guest_info.address_owner']">
                            <span class="help-block">{{ errors['guest_info.address_owner'][0] }}</span>
                        </template>
                    </div>
                </div> -->
                <div :class="`form-group ${errors['guest_info.country_id']? ' has-error' : '' }`">
                    <label for="countries" class="col-md-2  required">الدولة</label>
                    <div class="col-md-4">
                        <select name="country_id" id="countries" class="form-control"
                                v-model="$store.state.checkout.guest_info.country_id"
                                required @input="$store.state.checkout.guest_info.city_id = null">
                            <option selected disabled>اختر</option>
                            <option v-for="country in countries" :value="country.id" v-text="country.name_ar"></option>
                        </select>
                        <template v-if="errors['guest_info.country_id']">
                            <span class="help-block">{{ errors['guest_info.country_id'][0] }}</span>
                        </template>

                    </div>
                </div>
                <div :class="`form-group ${errors['guest_info.city_id']? ' has-error' : '' }`"
                >
                    <label for="cities" class="col-md-2  required">المدينة</label>
                    <div class="col-md-4">
                        <select name="city_id" id="cities" class="form-control" required
                                v-model="$store.state.checkout.guest_info.city_id"
                                @change="updateShippingMethods">
                            <option selected disabled>اختر</option>
                            <option v-for="city in cities"
                                    :value="city.id"
                                    v-text="city.name_ar"></option>
                        </select>
                        <template v-if="errors['guest_info.city_id']">
                            <span class="help-block">{{ errors['guest_info.city_id'][0] }}</span>
                        </template>
                    </div>
                </div>
                <div v-if="districts.length" class="form-group"
                >
                    <label for="districts" class="col-md-2  required">الحي</label>
                    <div class="col-md-4">
                        <select name="district_id" id="districts" class="form-control" required
                                v-model="$store.state.checkout.guest_info.district_id" @change="districtSelected()">
                            <option selected disabled>اختر</option>
                            <option v-for="district in districts"
                                    :value="district.id"
                                    v-text="district.name_ar"></option>
                        </select>
                        <template v-if="errors['guest_info.district_id']">
                            <span class="help-block">{{ errors['guest_info.district_id'][0] }}</span>
                        </template>
                    </div>
                </div>
                <div :class="`form-group ${errors['guest_info.address_details']? ' has-error' : '' }`">
                    <label for="address_details" class="col-md-2 ">العنوان</label>

                    <div class="col-md-4">
                        <input id="address_details" type="text" class="form-control" name="address_details"
                               v-model="$store.state.checkout.guest_info.address_details" autofocus>

                        <template v-if="errors['guest_info.address_details']">
                            <span class="help-block">{{ errors['guest_info.address_details'][0] }}</span>
                        </template>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name    : "guest-info",
        data() {
            return {
                form     : {
                    username       : '',
                    email          : '',
                    mobile         : '',
                    address_owner  : '',
                    address_details: '',
                    city_id        : '',
                    district_id    : ''
                },
                countries: [],
                errors   : [],
            }
        },
        mounted() {
            this.getCountries()
            this.$store.state.checkout.guest_info.country_id = 1 // 1 = Saudi Arabia
        },
        computed: {
            cities() {
                if (this.$store.state.checkout.guest_info.country_id && this.countries.length) {
                    return this.countries.find(
                        country => { return country.id === this.$store.state.checkout.guest_info.country_id}).cities
                } 
                return [];
                
            },
            districts() {
                if (this.$store.state.checkout.guest_info.city_id && this.cities.length) {
                    return this.cities.find(
                        city => { return city.id === this.$store.state.checkout.guest_info.city_id}).districts
                } 
                return [];
                
            },
            district_zone(){
                if(this.districts.length){
                    return this.districts.find(
                        district => { return district.id === this.$store.state.checkout.guest_info.district_id}
                    ).district_zone
                }
            }

        },
        methods : {
            getCountries() {
                axios.get('/countries').then(res => {
                    this.countries = res.data.countries
                })
            },
            showLogin() {
                this.$root.showLogin = true
            },
            updateShippingMethods() {
                this.$root.$refs.shipping.getAddressShippingMethods()
            },
            districtSelected(){
                if (this.$store.state.checkout.guest_info.district_id) {
                    this.$root.$refs.shipping.updateShippingPrice();
                }
            }

        }
    }
</script>

<style lang="scss" scoped>
    /*@import "~styles/frontend/variables";*/

    .required:after {
        content : '*';
        color   : red;
    }

    .help-block {
        font-size : 12px;
    }

    form {
        padding : 15px;
    }
</style>