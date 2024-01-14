<template>
    <div>
        <!-- <div class="collapse-header" v-bind:class="{'collapsed' : collapsed}" v-on:click="collapsed = !collapsed">
            <span></span>
        </div> -->
        <div class="collapse-header">
            <a href="#rating" class="collapsed" data-toggle="collapse" role="button">التقييمات</a>
        </div>
        <div class="collapse" id="rating">
            <vue-stars name="main-rating" :value="rate_avg" hover-color="#0294e9" active-color="#0294e9"
                       shadow-color="#fff"
                       readonly></vue-stars>
            <span class="num-of-ratings">({{ratings.length}})</span>
            <div class="col-xs-12">
                <div class="col-sm-6 col-md-4">

                    <div class="row">
                        <div class="rating-label ">5 نجوم</div>
                        <div class="pull-right col-xs-8">
                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                     :style="{width: ratings.filter(rate=>{ return rate.rating === 5}).length / ratings.length * 100 +'%'}">
                                </div>
                            </div>
                        </div>
                        <span class="pull-left">({{ratings.filter(rate=>{ return rate.rating === 5}).length}})</span>
                    </div>
                    <div class="row">
                        <div class="rating-label ">4 نجوم</div>
                        <div class="pull-right col-xs-8">
                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                     :style="{width: ratings.filter(rate=>{ return rate.rating === 4}).length / ratings.length * 100 +'%'}">
                                </div>
                            </div>
                        </div>
                        <span class="pull-left">({{ratings.filter(rate=>{ return rate.rating === 4}).length}})</span>
                    </div>
                    <div class="row">
                        <div class="rating-label ">3 نجوم</div>
                        <div class="pull-right col-xs-8">
                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                     :style="{width: ratings.filter(rate=>{ return rate.rating === 3}).length / ratings.length * 100 +'%'}">
                                </div>
                            </div>
                        </div>
                        <span class="pull-left">({{ratings.filter(rate=>{ return rate.rating === 3}).length}})</span>
                    </div>
                    <div class="row">
                        <div class="rating-label ">2 نجوم</div>
                        <div class="pull-right col-xs-8">
                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                     :style="{width: ratings.filter(rate=>{ return rate.rating === 2}).length / ratings.length * 100 +'%'}">
                                </div>
                            </div>
                        </div>
                        <span class="pull-left">({{ratings.filter(rate=>{ return rate.rating === 2}).length}})</span>
                    </div>
                    <div class="row">
                        <div class="rating-label ">1 نجمة</div>
                        <div class="pull-right col-xs-8">
                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                     :style="{width: ratings.filter(rate=>{ return rate.rating === 1}).length / ratings.length * 100 +'%'}">
                                </div>
                            </div>
                        </div>
                        <span class="pull-left">({{ratings.filter(rate=>{ return rate.rating === 1}).length}})</span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-md-offset-3 text-center">
                    <div v-if="newComment">
                        <div class="visible-sm-inline-block visible-md-inline-block visible-lg-inline-block visible-xs-block">
                            <p class="rate-it">قيم المنتج</p>
                            <vue-stars v-model="userRate" name="rate-it" hover-color="#0294e9" active-color="#0294e9"
                                       shadow-color="#fff"></vue-stars>
                            <p><a class="btn btn-outline btn-default " v-model="comment" v-if="!rateIt"
                                  @click="rateIt = !rateIt">إضافة تعليق</a></p>
                        </div>
                        <div class="visible-sm-inline-block visible-md-inline-block visible-lg-inline-block visible-xs-block"
                             v-if="rateIt">
                            <div>
                            <textarea class="form-control comment" v-model="comment" name="comment" id="x"
                                      rows="3"></textarea></div>
                            <div><span class=" btn btn-primary btn-block text-secondary  " @click="sendRate">
                                <p class="">إرسال</p></span></div>
                        </div>
                    </div>
                    <div v-if="!newComment" class="user-comment">
                        <p>شكراً لك على تقييمك.</p>
                        <vue-stars :value="userRate" name="rate-result" hover-color="#bf1e2e" active-color="#bf1e2e"
                                   shadow-color="#fff" readonly></vue-stars>
                        <p class="text-center comment">{{comment}}</p>

                    </div>
                </div>
            </div>
            <hr>
            <div class="user-rating" v-for="(rating,index) in ratings">
                <vue-stars :name="'rate-'+index" :value="rating.rating" hover-color="#bf1e2e" active-color="#bf1e2e"
                           shadow-color="#fff" readonly></vue-stars>
                <p class="user-name">{{rating.user.first_name + " " + rating.user.last_name}}
                    <a class="pull-left" href="#"><span class="glyphicon-flag glyphicon"></span></a></p>
                <p class="comment">{{rating.comment}}</p>
            </div>
        </div>
    </div>
    <!--
        <div v-if="!collapsed" class="col-sm-4 product text-center" v-for="rating in ratings">
        </div>
    -->
</template>

<script>
    export default {
        props  : ['ratings', 'rate_avg', 'product_id'],
        data() {
            return {
                collapsed : true,
                rateIt    : false,
                comment   : "",
                userRate  : 0,
                newComment: true
            }
        },
        mounted() {
            // console.log(this.ratings);
        },
        methods: {
            sendRate() {
                axios.post('/rate', {
                    comment   : this.comment,
                    product_id: this.product_id,
                    rating    : this.userRate
                }).then((response) => {
                    this.newComment = false
                    // console.log(response.data)
                })//Todo : make error catching behavior

            }
        },
    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"
    .rating-label
        float : right
        margin : 0 8px

    .rate-it
        font-size : 20px
        color : $brand-secondary
        font-weight : bold

    .progress
        height : 2px
        margin : 14px 0

    .num-of-ratings
        font-size : 16px
        line-height : 25px

    .user-rating
        margin : 0 20px 0 0
        .vue-stars
            margin : 0
            font-size : 22px
        .comment
            margin : 10px 0 20px
        .glyphicon-flag
            color : #fff
            text-shadow : 0 0 2px black
            font-size : 15px

    .user-comment
        .comment
            font-size : 20px
        .vue-stars
            font-size : 20px
            margin : 0

    .vue-stars
        align-self : left
        font-size : 25px
        direction : rtl
        margin : 10px 20px 10px 10px

    .comment
        padding-left : 10px
        margin-bottom : 10px
        resize : none


</style>
