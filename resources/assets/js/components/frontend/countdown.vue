<template>
    <div class="countdown">
        <div class="block" v-if="two_digits(days) !== '00'">
            <p class="digit">{{ two_digits(days) }}</p>
            <p class="text">يوم</p>
        </div>
        <div class="block">
            <p class="digit">{{ two_digits(hours) }}</p>
            <p class="text">ساعة</p>
        </div>
        <div class="block">
            <p class="digit">{{ two_digits(minutes) }}</p>
            <p class="text">دقيقة</p>
        </div>
        <div class="block">
            <p class="digit">{{ two_digits(seconds) }}</p>
            <p class="text">ثانية</p>
        </div>
    </div>
</template>
<script>
    export default {

        mounted() {
            window.setInterval(() => {
                this.now = Math.trunc((new Date()).getTime() / 1000);
            }, 1000);

        },

        props: ['value'],

        data() {
            return {
                now : Math.trunc((new Date()).getTime() / 1000),
                date: Math.trunc(Date.parse(this.convertDateForIos(this.value)) / 1000)
            }
        },

        computed: {
            seconds() {
                return (this.date - this.now) % 60;
            },

            minutes() {
                return Math.trunc((this.date - this.now) / 60) % 60;
            },

            hours() {
                return Math.trunc((this.date - this.now) / 60 / 60) % 24;
            },

            days() {
                return Math.trunc((this.date - this.now) / 60 / 60 / 24);
            }
        },

        methods: {
            two_digits: function (value) {
                if (value.toString().length <= 1) {
                    return "0" + value.toString();
                }
                return value.toString();
            },
            convertDateForIos(date) {
                let arr = date.split(/[- :]/);
                date    = new Date(arr[0], arr[1] - 1, arr[2], arr[3], arr[4], arr[5]);
                return date;
            }
        }
    }

</script>
<style scoped>
    .countdown {
        align-items     : center;
        bottom          : 0;
        display         : flex;
        justify-content : center;
        left            : 0;
        position        : relative;
        right           : 0;
        top             : 0;
    }

    .block {
        display        : flex;
        flex-direction : column;
        margin         : 6px;
    }

    .text {
        color         : #5a5099;
        font-size     : 16px;
        font-weight   : 400;
        margin-top    : 0;
        margin-bottom : 10px;
        text-align    : center;
    }

    .digit {
        color       : #0c0c0c;
        font-size   : 19px;
        font-weight : 100;
        margin      : 0;
        text-align  : center;
    }
</style>
