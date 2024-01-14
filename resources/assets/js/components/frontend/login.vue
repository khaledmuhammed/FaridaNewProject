<template>
    <div>
        <modal>
            <div slot="header">
                <h3>{{$t('Login')}}
                    <span class="btn pull-left btn-sm" @click="closeModal">                        <span
                            class="glyphicon glyphicon-remove"></span>
                    </span>
                </h3>

            </div>
            <div slot="body" class="form-horizontal">
                <div :class="`form-group ${errors.email ? ' has-error' : '' }`">
                    <label class="col-md-4 control-label">{{$t('Email')}}</label>

                    <div class="col-md-8">
                        <input type="email" class="form-control" name="email"
                               v-model="form.email" required autofocus>

                        <template v-if="errors.email">
                            <span class="help-block">
                                <strong>{{ errors.email[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>

                <div :class="`form-group ${errors.password ? ' has-error' : '' }`">
                    <label class="col-md-4 control-label">{{$t('Password')}}</label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password"
                               v-model="form.password" required autofocus>

                        <template v-if="errors.password">
                            <span class="help-block">
                                <strong>{{ errors.password[0] }}</strong>
                            </span>
                        </template>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" v-model="form.remember"> {{$t('Remember Me')}}
                            </label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="text-left" slot="footer">
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4 no-padding">
                        <a class="btn btn-link text-info" href="/password/reset">
                            {{$t('Forgot Your Password?')}}
                        </a>
                        <button class="btn btn-primary" @click="login">{{$t('Login')}}</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </modal>

    </div>
</template>

<script>
    export default {
        props  : ['action', 'token'],
        data() {
            return {
                form  : {
                    email   : null,
                    password: null,
                    remember: 0,
                },
                errors: []
            }
        },
        ready() {
        },
        mounted() {
        },
        methods: {
            login() {
                axios.post(this.action, this.form).then(res => {
                    console.log(res)
                    location.reload();

                }).catch(error => {
                    this.errors = error.response.data.errors
                    console.log('error', this.errors)
                })
            },
            closeModal() {
                this.$root.showLogin = false
            }
        }
    }
</script>
<style scoped lang="sass">

</style>