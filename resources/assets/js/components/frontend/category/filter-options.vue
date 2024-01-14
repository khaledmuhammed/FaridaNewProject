<template>
    <div>
        <div :id="`att-`+filter.id" :class="collapse">
            <template v-if="filter.options.length" v-for="(option,i) in filter.options">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" @change="filterProducts()" v-model="selected_options"
                               :value="option.id">
                        {{option.name_ar}}
                    </label>
                </div>
            </template>
        </div>
        <hr>
    </div>
</template>

<script>

    export default {
        props  : ['filter'],
        data() {
            return {
                selected_options: []
            }
        },
        computed: {
            collapse() {
                const isMobile = window.matchMedia("only screen and (max-width: 760px)")
                return isMobile.matches ? 'collapse' : ''
            }
        },
        methods: {
            filterProducts() {
                this.$parent.filterProducts(this.filter.id, this.selected_options)
            }
        }
    }
</script>
<style lang="sass" scoped>
    .checkbox
        font-size : 13px

        .checkbox-container .checkbox_label
            padding-right : 1rem !important

</style>