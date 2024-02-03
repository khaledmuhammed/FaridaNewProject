<template>
    <div class="has-feedback">
        <modal>
            <div slot="header">
                <span class="btn pull-left btn-lg" @click="closeModal">                        <span
                            class="glyphicon glyphicon-remove"></span>
                    </span>
            </div>
            <div slot="body" class="form-horizontal">
        <div v-if="active" class="details col-xs-12">
            <transition-group name="list" tag="div">
                <div v-for="item in result" class="row result" :key="'item'+item.id">
                    <div class="col-xs-12">
                        <a v-bind:href="'/'+route+'/'+item.id" class="media">
                            <div class="media-left">
                                <img class="media-object" :src="item.thumbnail"
                                     onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';">
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading" v-html="item.html"></h5>
                                <!--
                                                                <vue-stars :value="item.rating" hover-color="#bf1e2e" active-color="#bf1e2e"
                                                                           shadow-color="#fff" readonly></vue-stars>
                                -->
                                <p class="price">{{item.finalPrice}} {{$t('SAR')}} </p>
                            </div>
                        </a>
                    </div>
                </div>
            </transition-group>
        </div>
        <i class="form-control-feedback fi flaticon-search text-primary" ></i>
        <input v-model="query" class="form-control search-input " name="search" type="text" :placeholder="$t('Search')" autocomplete="off">
        
    </div>
    <div class="text-left" slot="footer"></div>
    </modal>
    </div>
</template>

<script>
    export default {
        props   : ['route'],
        data    : function () {
            return {
                query : "",
                result: []
            }
        },
        computed: {
            active: function () {
                return (this.query != "");
            }
        },
        watch   : {
            query: function (value) {
                if (value === "") return [];
                var vm = this
                axios.post('/autocomplete', {
                    query: vm.query
                }).then((response) => {
                    this.result = response.data
                    var query   = vm.query.toLowerCase()
                    response.data.forEach(function (element) {
                        var part1    = element.theName.slice(0, element.theName.toLowerCase().indexOf(query))
                        var part2    = element.theName.slice(element.theName.toLowerCase().indexOf(query),
                            element.theName.toLowerCase().indexOf(query) + query.length)
                        var part3    = element.theName.slice(element.theName.toLowerCase().indexOf(query) + query.length)
                        element.html = part1 + '<b class="text-danger">' + part2 + '</b>' + part3
                    });
                })
            }
        },
        methods:{
            closeModal() {
                this.$root.showSearch = false
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import '~styles/frontend/variables';


    

    a:hover {
        text-decoration : none;
    }

    .form-control {
        font-size : 18px;
        padding: 25px;
        border-radius: 50%;
        border:2px solid #000;
    }

    .search-input {
        padding-right: 50px;
    }
    .search-input::placeholder {
        
    }
    .form-control-feedback {
        position: relative;
        top: 45px !important;
        right: 5px;
        z-index: 3;
    }

    div {
        z-index : 2;
    }

    input {
        z-index  : 2;
        position : relative;
        border: 1px solid #dedede;
    }

    .details {
        position           : absolute;
        width              : 76%;
        background-color   : #ffffff;
        -webkit-box-shadow : 1px 1px 10px rgba(0, 0, 0, 0.1);
        box-shadow         : 0 0 6px rgba(0, 0, 0, 0.33);
        margin             : 0;
        border-radius      : 15px;
        top                : 130px;
    }

    .result {
        height      : 120px;
        display     : flex;
        align-items : center;
    }

    .media {
        margin-bottom : 5px;
        display: flex;
        align-items: center;
        img {
            background-color : #eee;
            height           : 75px;
            width            : 75px;
            object-fit: cover;
            border-radius    : 5px;
        }
    }

    .list-item {
        transition : all .5s;
        position   : relative;
    }

    .list-enter-active, .list-leave-active {
        transition : all .5s;
    }

    .list-enter, .list-leave-to {
        opacity   : 0;
        transform : translateX(10px);
    }

    .list-leave-active {
        position : absolute;
    }

    .list-move {
        transition : transform .7s;
    }
</style>
