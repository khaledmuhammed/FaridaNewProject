<template>
    <div>
        <div class="collapse-header">
            <a href="#attributes" class="collapsed" data-toggle="collapse" role="button">{{$t('Product Info')}}</a>
        </div>
        <div class="collapse" id="attributes">
            <div class="table-responsive">
                <table class="table">
                    <tr v-for="attribute in attributes">
                        <td class="title">{{attribute.name}}</td>
                        <td>{{attribute.pivot.text}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    let data = {
        collapsed: false,
    }
    export default {
        props  : ['attributes'],
        data() {
            return {
                collapsed: false,
            }
        },
        mounted() {
            // console.log(this.attributes);
        },
        methods: {},
    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"

    .table
        font-size : 16px
        td
            padding : 10px
            border-top : 1px solid $text-color-light
        tr:last-child td
            border-bottom : 1px solid $text-color-light
        .title
            padding-right : 20px
            border-left : 1px solid $text-color-light

    @media #{$mobile}
        .img-navbar
            -webkit-overflow-scrolling : touch


</style>