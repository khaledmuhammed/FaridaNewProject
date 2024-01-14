<template>
    <div>
        <div class="panel">
            <div class="panel-body">
                <div v-for="filter in filters">
                    <p class="filter-title" :data-toggle="collapse" :data-target="`#att-`+filter.id">
                        {{filter.name_ar}}
                    </p>
                    <filter-options :filter="filter"></filter-options>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import FilterOptions from "./filter-options";

    export default {
        components: {FilterOptions},
        props     : ['filters'],
        data() {
            return {
                selected_options: {}
            }
        },
        computed: {
            collapse() {
                const isMobile = window.matchMedia("only screen and (max-width: 760px)")
                return isMobile.matches ? 'collapse' : ''
            }
        },
        mounted() {
        },
        methods   : {
            filterProducts(filter_id, options) {
                this.selected_options[filter_id] = options
                this.$root.$refs.products.filterProducts(this.selected_options)
            }
        }
    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"

    .filter-title
        font-size : 14px
        margin-bottom : 25px
        color : $brand-secondary
        font-family : Bold

    .panel-body > div
        padding-right : 10px

    .collapsed:after
        content : "" !important
        position : initial !important

    #rating
        text-align : center
        font-size : 30px

    .panel

    @media screen and (max-width : 767px)
        .panel
            margin-top : 20px

</style>