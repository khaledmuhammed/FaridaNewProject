<template>
    <div>
        <div class="box box-inline-block-top">
            <div class="box-header">{{$t('My Orders')}}</div>
            <div class="box-content">
                <template v-for="(order,index) in orders" v-if="index < 3">
                    <p class="order text-center">
                        <span class="pull-right">- <a :href="order_route +'/'+ order.id"
                                                                 v-text="`#${order.id}`"></a></span>
                        <span>{{$t('Status')}} : {{order.currentStatus['name_ar']}}</span>
                        <span
                                class="pull-left">{{order.formatted_created_at}}</span>
                    </p>
                    <hr>
                </template>
                <p v-else class="text-center"><a href="" class="text-center">{{$t('More')}}</a></p>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['route', 'order_route'],
        data() {
            return {
                orders: []
            }
        },
        mounted() {
            axios.get(this.route).then(res => {
                if (res.data) {
                    this.orders = res.data
                }
            })
        },
    }
</script>
