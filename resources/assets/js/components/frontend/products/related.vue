<template>
    <div>
        <div class="collapse-header">
            <a href="#related" class="collapsed" data-toggle="collapse" role="button">{{$t('Related Products')}}</a>
        </div>
        <div class="collapse" id="related">
            <v-products :items="related_products" :auth="auth" size="3"></v-products>
        </div>
    </div>
</template>

<script>
    let data = {
        collapsed: false,
    }
    export default {
        props  : ['related_products', 'auth'],
        data() {
            return {
                collapsed: false,
            }
        },
        mounted() {
        },
        methods: {}
    }
</script>
<style lang="sass" scoped>
    /*@import "~styles/frontend/variables"*/


</style>