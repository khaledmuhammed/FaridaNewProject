<template>
    <div class="row flex">
        <div class="MagicScroll thumbs-list col-sm-3 col-md-2 col-md-offset-1 col-xs-12"
             data-mobile-options="orientation:horizontal; width:100% ;height:100px;items:fit;loop: off;lazyLoad: true;"
             data-options="orientation: vertical;  items:4;loop: off;lazyLoad: true;">
            <a v-for="img in imgs" data-zoom-id="products"
               :href="img.url"
               :data-image="img.thumb_image">
                <img :src="img.tiny_image" class="">
            </a>
        </div>
        <div class="col-sm-8 col-md-8 col-xs-12" v-if="imgs.length > 0">
            <a :href="imgs[current].url"
               class="MagicZoom"
               data-mobile-options="orientation:horizontal; items:fit;lazyLoad: true;"
               data-options="zoomMode: magnifier; variableZoom: true"
               id="products">
                <img :src="imgs[current].thumb_image" />
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props  : ['imgs'],
        data() {
            return {
                current: 0,
            }
        },
        mounted() {},
        methods: {},
    }
</script>

<style lang="sass" scoped>
    @import "~styles/frontend/variables"

    #products
        overflow: hidden
    .MagicScroll-vertical .mcs-item
        display : block
        width : 100%
        margin : 20px auto

    .more
        margin : 10px
        display : block
        text-align : center

    .fade-enter-active, .fade-leave-active
        transition : height .5s

    .fade-enter, .fade-leave
        height : 0

    .mz-thumb img
        box-shadow : none
        opacity : 0.5

    .mz-thumb-selected img
        filter : brightness(100%)
        opacity : 1

    @media #{$mobile}
        .img-navbar
            -webkit-overflow-scrolling : touch
        .flex
            flex-direction : column-reverse
        .thumbs-list
            margin: 20px 0

</style>
