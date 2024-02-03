<template>
    <div v-if="positionables.length">
        <div v-for="positionable in positionables">

            <banner v-if="positionable.positionable_type.includes('Banner')" :positionable="positionable"></banner>

            <div 
                 v-if="positionable.positionable_type.includes('FeaturedProduct')">
                <featured-products :checkout_route="checkout_route" :positionable="positionable" :size="size"></featured-products>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props  : ['name', 'checkout_route', 'needs_container', 'size'],
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
            }).catch(err => {
            })
        },
        methods: {}
    }
</script>
