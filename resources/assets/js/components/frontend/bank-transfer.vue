<template>
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 margin-top">
        <div class="form">
            <div class="banktransfer-form" v-if="!successMsg">
                <div class="form-group col-sm-12">
                    <label class="control-label col-sm-3 text-left">{{$t('Account Owner')}} <span class="text-red">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" name="account_owner" v-model="account_owner" class="form-control" />
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label class="control-label col-sm-3 text-left">{{$t('Account Number')}} <span class="text-red">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" name="account_number" v-model="account_number" class="form-control" />
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label class="control-label col-sm-3 text-left">{{$t('Bank Name')}} <span class="text-red">*</span></label>
                    <div class="col-sm-6">
                        <select name="bank_name" v-model="bank_name" class="form-control">
                            <option value="" disabled selected>{{$t('Select')}}</option>
                            <option value="مصرف الراجحي">{{$t('AlRajhi Bank')}}</option>
                            <option value="مصرف الإنماء">{{$t('Alinma Bank')}}</option>
                            <option value="سامبا">{{$t('Samba Bank')}}</option>
                            <option value="البنك الأهلي">{{$t('National Commercial Bank')}}</option>
                            <option value="بنك الرياض">{{$t('Riyad Bank')}}</option>
                            <option value="بنك الجزيرة">{{$t('Al Jazeera Bank')}}</option>
                            <option value="بنك البلاد">{{$t('Bank Albilad')}}</option>
                            <option value="البنك العربي الوطني">{{$t('Arab national Bank')}}</option>
                            <option value="بنك ساب">{{$t('SABB')}}</option>
                            <option value="البنك الأول">{{$t('AlAwwal Bank')}}</option>
                            <option value="البنك السعودي الفرنسي">{{$t('Banque Saudi Fransi')}}</option>
                            <option value="البنك السعودي للاستثمار"></option>
                            <option value="بنك آخر">{{$t('Other')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label class="control-label col-sm-3 text-left">{{$t('Amount transferred')}} <span class="text-red">*</span></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <input type="text" name="amount" v-model="amount" class="form-control" v-on:keypress="isNumber()" />
                            <span class="input-group-addon">SAR</span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label class="control-label col-sm-3 text-left">{{$t('Date of transfer')}} <span class="text-red">*</span></label>
                    <div class="col-sm-6">                
                        <div class="input-group">
                            <div class="FormDate">
                                <input
                                class="FormDate__input FormDate__input--day"
                                type="text"
                                v-model="day"
                                :placeholder="$t('Day')" :maxlength="2"
                                v-on:keypress="isNumber()">
                                <span class="FormDate__divider">/</span>
                                <input
                                class="FormDate__input FormDate__input--month"
                                type="text"
                                v-model="month"
                                :placeholder="$t('Month')" :maxlength="2"
                                v-on:keypress="isNumber()">
                                <span class="FormDate__divider">/</span>
                                <input
                                class="FormDate__input FormDate__input--year"
                                v-model="year"
                                type="text"
                                :placeholder="$t('Year')" :maxlength="4"
                                v-on:keypress="isNumber()">
                            </div>
                            <span class="input-group-addon">{{$t('Gregorian')}}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label class="control-label col-sm-3 text-left">{{$t('Notes')}}</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="notes" v-model="notes"></textarea>
                    </div>
                </div>
                <input type="hidden" name="order_id" v-model="order_id" />
                <div class="form-group col-sm-6 col-sm-offset-3">
                    <button @click="submit()" class="btn btn-primary btn-block float-left">{{$t('Send')}}</button>
                </div>
            </div>
            <div class="form-group col-sm-6 col-sm-offset-3">
                <p class="text-darkgray text-center" v-if="sending">{{$t('Sending')}} ...</p>
                <p class="text-green text-center" v-if="successMsg">{{$t('Sent successfully')}}</p>
                <p class="text-red text-center" v-if="errorMsg">{{$t('Please fill in the required fields')}}</p>
                <p class="text-red text-center" v-if="errorSend">{{$t('There is a sending error, please communicate us directly to the mail')}} faridahflowers@gmail.com</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['order_id'],
        data() {
            return {
                account_owner  : '',
                account_number : '',
                bank_name      : '',
                amount         : '',
                notes          : '',
                day            : null,
                month          : null,
                year           : null,
                successMsg     : false,
                errorMsg       : false,
                errorSend      : false,
                sending        : false,
            }
        },
        methods: {
            submit() {
                this.sending  = true;
                this.errorMsg = false;
                if (this.account_owner == '' ||
                    this.account_number == '' ||
                    this.bank_name == '' ||
                    this.amount == '' ||
                    this.date == '' ||
                    this.order_id == '') {
                    this.errorMsg = true;
                    this.sending  = false;
                    return false;
                }
                let requestData = {
                    account_owner     : this.account_owner,
                    account_number    : this.account_number,
                    bank_name         : this.bank_name,
                    amount            : this.amount,
                    date              : this.date,
                    notes             : this.notes,
                    order_id          : this.order_id,
                };

                axios.post('/bankTransfer_send', requestData).then(respond => {
                    console.log(respond.data);
                    this.successMsg = true;
                    this.errorMsg = false;
                    this.sending  = false;
                    this.account_owner = ''
                    this.account_number = ''
                    this.bank_name = ''
                    this.amount = ''
                    this.notes = ''
                    this.year = ''
                    this.day = ''
                    this.month = ''
                }).catch(error => {
                    console.log(error);
                    this.errorSend = true;
                })
            },
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            }
        },
        mounted() {
            // if (this.day < 10) this.day = '0'+this.day;
        },
        computed: {
            date() {
                if (this.year && this.month && this.day) {
                    let D = this.day < 10 ? '0'+this.day : this.day
                    let M = this.month < 10 ? '0'+this.month : this.month
                    return this.year +'-'+ M +'-'+ D;
                }
                return '';
            }
        }
    }
</script>
<style scoped lang="scss">
    @import "~styles/frontend/variables";

    .FormDate {
        $spacing: 0.75em;

        display: inline-flex;
        position: relative;
        overflow: hidden;
        border: 1px solid #aaa9ab;
        border-radius: 0.25em;
        border-bottom-left-radius: 0;
        border-top-left-radius: 0;
        width: 100%;
        height: 36px;

        // 1. Hide the spinner button in Chrome, Safari and Firefox.
        &__input {
            padding: $spacing;
            padding-right: $spacing / 2;
            padding-left: $spacing / 2;
            border: none;
            text-align: center;
            -moz-appearance: textfield; // 1

            &::-webkit-inner-spin-button {
            display: none; // 1
            }

            &:first-child {
            padding-left: $spacing;
            }

            &:last-child {
            padding-right: $spacing;
            }

            &:focus {
            outline: none;
            }

            &--day,
            &--month {
            width: 3em;
            }

            &--year {
            width: 4em;
            }
        }

        &__divider {
            padding-top: $spacing;
            padding-bottom: $spacing;
            pointer-events: none;
        }
    }

    .input-group-addon:last-child {
        border-left: 1px solid #aaa9ab;
    }

    @media #{$mobile}{

    }

</style>