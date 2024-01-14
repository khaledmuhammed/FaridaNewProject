<template>
    <ul class="nav navbar-nav navbar-right">
        <template v-for="category in categories">
            <li>
                <a :href="'/categories/'+category.id" v-tippy="{
                    html: '#cat-'+category.id,
                    reactive : true,
                    interactive : true,
                    placement : 'bottom-end',
                    theme : 'categories',
                    animateFill : false,
                    distance : 0
                }">{{category.theName}}</a>
            </li>
            <ul :id="'cat-'+category.id" class="sub-category">
                <template v-for="subCategory in category.categories">
                    <li class="category" @mouseover="show('cat-'+subCategory.id)"
                        @mouseleave="hide('cat-'+subCategory.id)">
                        <a :href="'/categories/'+subCategory.id">
                            {{subCategory.theName}}
                            <span v-if="subCategory.categories.length > 0" class="caret"></span>
                        </a>
                        <ul :ref="'cat-'+subCategory.id" class="sub-category nested">
                            <li class="category" v-for="subCategory2 in subCategory.categories">
                                <a :href="'/categories/'+subCategory2.id">{{subCategory2.name}}</a>
                            </li>
                        </ul>
                    </li>
                </template>
            </ul>
        </template>
    </ul>
</template>

<script>

    export default {
        props  : ['categories'],
        methods: {
            show(category) {
                this.$refs[category][0].style.display = 'block';
            },
            hide(category) {
                this.$refs[category][0].style.display = 'none';
            }
        }
    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"
    li
        position : relative

    a
        color : $text-color-light
        text-decoration : none
        font-weight : bold

    .sub-category
        list-style : none
        line-height : 20px
        padding : 0 !important
        margin : 0 !important
        color : #fff
        .category
            font-size : 16px
            cursor : pointer
            text-align : right
            margin : 0
            padding : 15px
            &:hover
                background-color : #4b0d13
        .nested
            display : none
            position : absolute
            top : 0
            right : 100%
            white-space : nowrap
            background-color : #4b0d13
            z-index : +1
        .caret
            border : 4px solid transparent
            border-right-color : $text-color-light
            float : left
            margin-top : 6px
            line-height : 20px
            margin-right : 15px

</style>
