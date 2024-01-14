<template>
    <div v-if="positionables.length">
        <div v-for="positionable in positionables">
            <banner v-if="positionable.positionable_type.includes('Banner')" :positionable="positionable"></banner>
            <featured-products :checkout_route="checkout_route"
                               v-if="positionable.positionable_type.includes('FeaturedProduct')"
                               :positionable="positionable"></featured-products>
        </div>
    </div>
</template>

<script>
    export default {
        props  : ['name', 'checkout_route'],
        data() {
            return {
                positionables: [],
            }
        },
        mounted() {
            axios.get('/positionables/' + this.name).then(res => {
                if (res.data[0]) {
                    this.positionables = res.data
                }
            })
        },
        methods: {}
    }
</script>
