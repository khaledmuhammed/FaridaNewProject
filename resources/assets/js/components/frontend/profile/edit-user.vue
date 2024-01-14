<template>
    <div>
        <modal v-if="showModal">
            <h3 slot="header">{{$t('Edit my account information')}}
                <span class="btn pull-left btn-sm" @click="showModal = false">
                    <span class="glyphicon glyphicon-remove"></span>
                </span>
            </h3>
            <div slot="body" class="form-horizontal">
                <div class="form-group">
                    <label for="first_name" class="col-sm-3 control-label">{{$t('First Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="first_name" id="first_name" class="form-control"
                               v-model="form.first_name"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-sm-3 control-label">{{$t('Last Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="last_name" id="last_name" class="form-control" v-model="form.last_name"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-sm-3 control-label">{{$t('Email')}}</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" id="email" class="form-control" v-model="form.email"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-sm-3 control-label">{{$t('Mobile')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="mobile" id="mobile" class="form-control" v-model="form.mobile"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="countries" class="col-sm-3 control-label">{{$t('Gender')}}</label>
                    <div class="col-sm-9">
                        <select name="gender" id="gender" class="form-control" v-model="form.gender"
                                required>
                            <option value="M">{{$t('Male')}}</option>
                            <option value="F">{{$t('Female')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="countries" class="col-sm-3 control-label">{{$t('Country')}}</label>
                    <div class="col-sm-9">
                        <select name="country_id" id="countries" class="form-control" v-model="form.country_id"
                                required>
                            <option v-for="country in countries" :value="country.id" v-text="country.name_ar"></option>
                        </select>
                    </div>
                </div>

                <div class="form-group" v-if="cities.length">
                    <label for="cities" class="col-sm-3 control-label">{{$t('City')}}</label>
                    <div class="col-sm-9">
                        <select name="city_id" id="cities" class="form-control" required v-model="form.city_id">
                            <option v-for="city in cities" :value="city.id"
                                    v-text="city.name_ar"></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-sm-3 control-label">{{$t('Password')}}</label>
                    <div class="col-sm-9">
                        <input type="password" name="password" id="password" class="form-control" v-model="form.password"
                               required>
                    </div>
                </div>
            </div>
            <div class="text-left" slot="footer">
                <button class="btn btn-primary" @click="updateUser">{{$t('Save')}}</button>
            </div>
        </modal>

    </div>
</template>

<script>
    export default {
        props   : ['user', 'route'],
        data() {
            return {
                showModal   : false,
                countries   : [],
                form        : {
                    first_name: this.user.first_name,
                    last_name : this.user.last_name,
                    email     : this.user.email,
                    mobile    : this.user.mobile,
                    gender    : this.user.gender,
                    country_id: this.user.city.country_id,
                    city_id   : this.user.city_id,
                    password  : '',
                },
            }
        },
        computed: {
            cities() {
                if (this.form.country_id) {
                    return this.countries.find(country => { return country.id === this.form.country_id}).cities
                } else {
                    return [];
                }
            }
        },

        methods: {
            editUser() {
                axios.get('/countries').then(res => {
                    this.countries = res.data.countries
                })
                this.showModal = true
            },
            updateUser() {
                //Todo : Make Validation

                axios.put(this.route, this.form).then(respond => {
                    console.log(respond)
                    if (respond.data) {
                        location.reload();
                    }
                })

            }

        }
    }
</script>
<style lang="sass" scoped>

    textarea
        resize : none
</style>