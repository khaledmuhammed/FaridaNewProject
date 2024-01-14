<template>
    <div>
        <div class="box box-inline-block-top">
            <div class="box-header text-left">
                <span class="pull-right">{{$t('My Account')}}</span>
                <button class="btn btn-primary" @click="editUser()"><span class="glyphicon glyphicon-edit"></span></button>
            </div>
            <div class="box-content">
                <div class="row">
                    <label class="col-sm-5">{{$t('Name')}} :</label>
                    <div class="col-sm-7">
                        <p>{{user.first_name}} {{user.last_name}}</p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">{{$t('Email')}} :</label>
                    <div class="col-sm-7">
                        <p>{{user.email}}</p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">{{$t('Mobile')}} :</label>
                    <div class="col-sm-7">
                        <p>{{user.mobile}}</p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">{{$t('Gender')}} :</label>
                    <div class="col-sm-7">
                        <p>{{gender}}</p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">{{$t('City')}} :</label>
                    <div class="col-sm-7">
                        <p>{{user.city.name_ar}}</p>
                    </div>
                </div>
            </div>
        </div>
        <edit-user ref="edit_user" :user="user" :route="route"></edit-user>
    </div>
</template>

<script>
    export default {
        props: ['user','route'],
        data() {
            return {
                showModal   : false,
            }
        },
        mounted() {
            axios.get(this.route).then(res => {
                
            })
        },
        methods: {
            editUser() {
                this.$refs.edit_user.editUser()
            },
        },
        computed: {
            gender() {
                return this.user.gender == 'M' ? 'ذكر' : 'أنثى';
            }
        }
    }
</script>
