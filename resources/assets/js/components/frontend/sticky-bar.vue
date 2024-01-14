<template>
    <div>
        <div class="sticky">
            <div class="visible-xs">
                <div class="hamburger" @click="$root.$refs.sidebar.showSideMenu = true">&#9776;</div>
            </div>
            <ul class="nav navbar-nav hidden-xs">
                <li>
                    <a href="/">{{$t('Home')}}</a>
                </li>
                <li v-for="superCategory in superCategories" class="dropdown">
                    <a :href="'/categories/'+superCategory.id">{{superCategory.theName}}</a>
                    <ul class="dropdown-content">
                        <li v-for="category in superCategory.categories"><a :href="'/categories/'+category.id">{{category.theName}}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name   : "sticky-bar",
        props  : ['superCategories'],
        methods: {

        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/frontend/variables";
    .sticky {
        position         : fixed;
        background-color : $brand-primary;
        z-index          : 10;
        width            : 100%;
        top              : 0;
        right            : 0;
        display          : flex;
        justify-content  : right;
        align-items      : center;
        padding          : 0 60px;
        .navbar-nav {
            float: none;
        }

        .nav {
            justify-content : space-evenly;
            padding         : 0;
            li {
                margin : 10px;
            }
            & > li > a {
                padding   : 5px;
                margin    : 0;
                font-size : 13px;
                color : $brand-info;
                &:hover, &:focus {
                    background-color : transparent;
                    margin-bottom    : -2px;
                    // border-bottom    : 2px solid $brand-warning;

                }
            }
            .dropdown {
                position : relative;
    
                .dropdown-content {
                    display          : none;
                    position         : absolute;
                    background-color : #fff;
                    min-width        : 160px;
                    box-shadow       : 0 0 8px 0 rgba(0, 0, 0, 0.2);
                    z-index          : 2;
                    top              : 30px;
                    list-style       : none;
                    padding          : 10px;
    
                    li {
                        padding : 5px;
                        margin: 0;
    
                        a {
                            font-size : 13px;
                            color : $brand-info;
                        }
                    }
                }
    
                &:hover .dropdown-content {
                    display : block;
                }
            }
        }
        .hamburger {
            font-size : 30px;
            position  : absolute;
        }
    }

    @media #{$mobile}{
        .sticky {
            padding : 0 10px;
        }
    }


</style>