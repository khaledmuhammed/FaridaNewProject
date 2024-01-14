<template>
    <div>
        <chrome-picker v-model="color"/>
        <input type="hidden" name="color" v-model="color.hex">
    </div>

</template>

<script>
    import {Chrome} from 'vue-color'

    export default {
        components: {
            'chrome-picker': Chrome,
        },
        props     : ['old'],
        data      : function () {
            return {
                color: '#C0382B'
            }
        },
        mounted() {
            this.old ? this.color = this.old : ''
        },
        methods   : {},
    }
</script>

<style>

</style>
