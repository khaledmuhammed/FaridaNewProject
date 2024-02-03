<template>
    <div class="">

        <div class="sidebar" :class="{active:showSideMenu}">
            <ul>
                <li><a href="/"><span>{{$t('Home')}}</span></a></li>
                <li v-for="category in categories"
                    :id="'cat-'+category.id">
                    <template v-if="category.categories_active.length">
                        <a role="button"
                        :href="'#category-'+category.id"
                        data-toggle="collapse" 
                        :aria-controls="'category-'+category.id"
                        aria-expanded="false">
                            {{category.theName}}
                        </a>
                        <div :id="'category-'+category.id"
                            class="collapse"
                            :aria-labelledby="'cat-'+category.id">
                            <ul>
                                <li v-for="subCategory in category.categories_active">
                                    <a :href="'/categories/'+subCategory.id">{{subCategory.theName}}</a>
                                </li>
                            </ul>
                        </div>
                    </template>
                    <template v-else>
                        <a role="button" :href="'/categories/'+category.id">
                            {{category.theName}}
                        </a>
                    </template>
                </li>
                <li><a href="/packages"><span>{{$t('Subscriptions')}}</span></a></li>
                <!-- <li><a href="/contact-us"><span>{{$t('Contact Us')}}</span></a></li> -->
                <!-- <li><a href="/offers"><span>العروض</span></a></li>
                <li><a href="/"><span>تجدوننا هنا</span></a></li> -->
            </ul>
        </div>
        <div class="sidebar-background" v-if="showSideMenu" @click="showSideMenu = false"></div>
    </div>
</template>

<script>

    export default {
        props     : ['categories'],
        components: {},
        data() {
            return {
                showSideMenu: false,
            }
        }
    }
</script>
<style scoped lang="scss">
    @import "~styles/frontend/variables";

    .sidebar-background {
        position   : fixed;
        z-index    : 999;
        width      : 100%;
        height     : 100%;
        background : rgba(128, 128, 128, 0.56);
    }

    .sidebar {
        position     : fixed;
        z-index      : 1000;
        width        : max-content;
        min-width    : 200px;
        background   : #fff;
        right        : -100%;
        color        : $brand-primary;
        height       : 100%;
        overflow-y   : auto;
        padding-top  : 20px;
        padding-left : 20px;
        padding-right : 20px;
        transition   : all 0.4s ease;

        &.active {
            right : -1%;
        }

        a {
            color : $brand-primary;

        }
        ul {
            list-style : none;
            li {
                line-height : 3;
                ul {
                    padding-right: 10px;
                    li {
                        a {
                            color : #555;
                            text-decoration: none;
                        }
                    }
                }
            }
        }
    }

</style>