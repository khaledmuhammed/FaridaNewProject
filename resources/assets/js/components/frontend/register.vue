<template>
    <div>
        <modal>
            <div slot="header">
                <h3>{{$t('Register')}}
                    <span class="btn pull-left btn-sm" @click="closeModal">
                        <span class="glyphicon glyphicon-remove"></span>
                    </span>
                </h3>

            </div>
            <div slot="body" class="form-horizontal">
                <div :class="`form-group ${errors.first_name ? ' has-error' : '' }`">
                    <label for="first_name" class="col-sm-4 control-label">{{$t('First Name')}}</label>

                    <div class="col-sm-8">
                        <input id="first_name" type="text" class="form-control" name="first_name"
                               v-model="form.first_name" required>

                        <template v-if="errors.first_name">
                            <span class="help-block">
                                <strong>{{ errors.first_name[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>

                <div :class="`form-group ${errors.last_name ? ' has-error' : '' }`">
                    <label for="last_name" class="col-sm-4 control-label">{{$t('Last Name')}}</label>

                    <div class="col-sm-8">
                        <input id="last_name" type="email" class="form-control" name="last_name"
                               v-model="form.last_name" required>

                        <template v-if="errors.last_name">
                            <span class="help-block">
                                <strong>{{ errors.last_name[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>

                <div :class="`form-group ${errors.email ? ' has-error' : '' }`">
                    <label for="email" class="col-sm-4 control-label">{{$t('Email')}}</label>

                    <div class="col-sm-8">
                        <input id="email" type="email" class="form-control" name="email"
                               v-model="form.email" required>

                        <template v-if="errors.email">
                            <span class="help-block">
                                <strong>{{ errors.email[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>

                <div :class="`form-group ${errors.mobile ? ' has-error' : '' }`">
                    <label for="mobile" class="col-sm-4 control-label">{{$t('Mobile')}}</label>

                    <div class="col-sm-8">
                        <input id="mobile" type="tel" class="form-control" name="mobile" placeholder="بالصيغة الدولية. مثال : 966xxxx"
                               v-model="form.mobile" required>

                        <template v-if="errors.mobile">
                            <span class="help-block">
                                <strong>{{ errors.mobile[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>
                <template v-if="countries.length">
                    <div class="form-group">
                        <label for="countries" class="col-sm-4 control-label">{{$t('Country')}}</label>
                        <div class="col-sm-8">
                            <select name="country_id" id="countries" class="form-control" v-model="form.country_id"
                                    required>
                                <option disabled selected>{{$t('Select')}}</option>
                                <option v-for="country in countries" :value="country.id"
                                        v-text="country.name_ar"></option>
                            </select>
                        </div>
                    </div>

                    <div :class="`form-group ${errors.city_id ? ' has-error' : '' }`" v-if="form.country_id">
                        <label for="cities" class="col-sm-4 control-label">{{$t('City')}}</label>
                        <div class="col-sm-8">
                            <select name="city_id" id="cities" class="form-control" required v-model="form.city_id">
                                <option disabled selected>{{$t('Select')}}</option>
                                <option v-for="city in cities" :value="city.id"
                                        v-text="city.name_ar"></option>
                            </select>
                            <template v-if="errors.city_id">
                            <span class="help-block">
                                <strong>{{ errors.city_id[0] }}</strong>
                            </span>
                            </template>
                        </div>
                    </div>
                </template>
                <div :class="`form-group ${errors.gender ? ' has-error' : '' }`">
                    <label for="gender" class="col-sm-4 control-label">{{$t('Gender')}}</label>
                    <div class="col-sm-8">
                        <select name="gender" id="gender" class="form-control" required v-model="form.gender">
                            <option disabled selected>{{$t('Select')}}</option>
                            <option value="M">{{$t('Male')}}</option>
                            <option value="F">{{$t('Female')}}</option>
                        </select>
                        <template v-if="errors.gender">
                            <span class="help-block">
                                <strong>{{ errors.gender[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>
                <div :class="`form-group ${errors.password ? ' has-error' : '' }`">
                    <label for="password" class="col-sm-4 control-label">{{$t('Password')}}</label>

                    <div class="col-sm-8">
                        <input id="password" type="password" class="form-control" name="password"
                               v-model="form.password" required>

                        <template v-if="errors.password">
                            <span class="help-block">
                                <strong>{{ errors.password[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>


                <div :class="`form-group ${errors.password_confirmation ? ' has-error' : '' }`">
                    <label for="password_confirmation" class="col-sm-4 control-label">{{$t('Confirm Password')}}</label>

                    <div class="col-sm-8">
                        <input id="password_confirmation" type="password" class="form-control"
                               name="password_confirmation"
                               v-model="form.password_confirmation" required>

                        <template v-if="errors.password_confirmation">
                            <span class="help-block">
                                <strong>{{ errors.password_confirmation[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>
            </div>
            <div class="text-left" slot="footer">
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-4 no-padding">
                        <button class="btn btn-primary" @click="register">{{$t('Register')}}</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </modal>

    </div>
</template>

<script>
    export default {
        props   : ['action'],
        data() {
            return {
                form     : {},
                errors   : [],
                countries: []
            }
        },
        ready() {
        },
        mounted() {
            this.getCountries()
        },
        computed: {
            cities() {
                return this.countries.find(item => {return item.id === this.form.country_id}).cities
            }
        },
        methods : {
            getCountries() {
                axios.get('/countries').then(res => {
                    this.countries = res.data.countries
                })
            },

            register() {
                this.errors = []
                axios.post(this.action, this.form).then(res => {
                    location.reload();

                }).catch(error => {
                    this.errors = error.response.data.errors
                })
            },
            closeModal() {
                this.$root.showRegister = false
            }

        }
    }
</script>
<style scoped lang="sass">

</style>