<template>
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 margin-top">
        <div class="fast-orders-form">
            <div class="form-group col-sm-12">
                <label class="control-label col-sm-3 text-left">الاسم <span class="text-red">*</span></label>
                <div class="col-sm-6">
                    <input type="text" name="name" v-model="name" class="form-control" placeholder="الاسم كامل" />
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="control-label col-sm-3 text-left">الجوال <span class="text-red">*</span></label>
                <div class="col-sm-6">
                    <input type="text" name="mobile" v-model="mobile" class="form-control" placeholder="بالصيغة الدولية : 9665xxxxxxxxxx" />
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label for="countries" class="col-sm-3 control-label text-left">الدولة <span class="text-red">*</span></label>
                <div class="col-sm-6">
                    <select name="country_id" id="countries" class="form-control"
                            v-model="country_id"
                            required @input="city_id = null">
                        <option selected disabled>اختر</option>
                        <option v-for="country in countries" :value="country.id" v-text="country.name_ar"></option>
                    </select>
                </div>
            </div>
            <div class="form-group col-sm-12"
                    v-if="cities.length">
                <label for="cities" class="col-sm-3 control-label text-left">المدينة <span class="text-red">*</span></label>
                <div class="col-sm-6">
                    <select name="city_id" id="cities" class="form-control" required
                            v-model="city_id">
                        <option selected disabled>اختر</option>
                        <option v-for="city in cities"
                                :value="city.id"
                                v-text="city.name_ar"></option>
                    </select>
                    <span class="text-red">(يرجى اختيار مكان السكن وليس المنطقة التابعة)</span>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="control-label col-sm-3 text-left">الحي <span class="text-red">*</span></label>
                <div class="col-sm-6">
                    <input type="text" name="district" v-model="district" class="form-control" />
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="control-label col-sm-3 text-left">كوبون الخصم </label>
                <div class="col-sm-6">
                    <input type="text" name="coupon" v-model="coupon" class="form-control" />
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="control-label col-sm-3 text-left">اختيار المنتجات <span class="text-red">*</span></label>
                <div class="col-sm-6">
                    <template v-for="(product_selected, psi) in products_selected">
                        <div :key="psi">
                            <select class="form-control col-sm-9" v-model="product_selected.name">
                                <option selected disabled value="اختر المنتج">اختر المنتج</option>
                                <template v-for="(product,i) in products">
                                <option :key="i" :value="product['name']">{{product['name']}}</option>
                                </template>
                            </select>
                            <select class="form-control col-sm-3" v-model="product_selected.quantity">
                                <option selected disabled value="الكمية">الكمية</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                            </select>
                        </div>
                    </template>
                    <button class="btn btn-default btn-sm" @click="addProduct()">إضافة منتج</button>
                </div>
            </div>
            <!-- <div class="form-group col-sm-12" v-if="packages.length > 0">
                <label class="control-label col-sm-3 text-left">اختيار الباقات <span class="text-red">*</span></label>
                <div class="col-sm-6">
                    <template v-for="(package_selected, pksi) in packages_selected">
                        <div :key="pksi">
                            <select class="form-control col-sm-9" v-model="package_selected.name">
                                <option selected disabled value="اختر الباقة">اختر الباقة</option>
                                <template v-for="(thePackage,pki) in packages">
                                <option :key="pki" :value="thePackage['name']">{{thePackage['name']}}</option>
                                </template>
                            </select>
                            <select class="form-control col-sm-3" v-model="package_selected.quantity">
                                <option selected disabled value="الكمية">الكمية</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                            </select>
                        </div>
                    </template>
                    <button class="btn btn-default btn-sm" @click="addPackage()">إضافة باقة</button>
                </div>
            </div> -->
            <div class="form-group col-sm-12">
                <label class="control-label col-sm-3 text-left">ملاحظات</label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="details" v-model="details" rows="7" placeholder=""></textarea>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="control-label col-sm-3 text-left">مدة الشحن</label>
                <div class="col-sm-6">
                    <p>التوصيل داخل الرياض : خلال 1 - 3 أيام عمل</p>
                    <p>الشحن خارج الرياض : خلال 3 - 5 أيام عمل</p>
                    <p>الشحن خارج المملكة : خلال 5 - 7 أيام عمل</p>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="control-label col-sm-3 text-left">قيمة الشحن</label>
                <div class="col-sm-6">
                    <p>داخل الرياض : 28 ريال</p>
                    <p>خارج الرياض : 40 ريال</p>
                    <p>رسوم الدفع عند الاستلام : 15 ريال</p>
                </div>
            </div>
            <div class="form-group col-sm-6 col-sm-offset-3">
                <button @click="submit()" class="btn btn-primary btn-block float-left">
                    <strong v-if="!sending">إرسال</strong>
                    <div class="spinner" v-else>
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                    </div>
                </button>
            </div>
            <div class="form-group col-sm-6 col-sm-offset-3">
                <p class="text-green text-center" v-if="successMsg">تم إرسال الطلب بنجاح</p>
                <p class="text-red text-center" v-if="errorMsg">يرجى تعبئة جميع الحقول</p>
                <p class="text-red text-center" v-if="errorSend">يوجد خطأ في الإرسال، يرجى التواصل مباشرة على <a target="_blank" href="https://wa.me/9665XXXXXXXX">+9665XXXXXXXX</a></p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['products', 'packages'],
        data() {
            return {
                name          : '',
                mobile        : '',
                country_id    : '',
                city_id       : '',
                district      : '',
                details       : '',
                coupon        : '',
                successMsg    : false,
                errorMsg      : false,
                errorSend     : false,
                sending       : false,
                countries     : [],
                products_selected: [{'name': 'اختر المنتج', 'quantity': 'الكمية'}],
                packages_selected: [{'name': 'اختر الباقة', 'quantity': 'الكمية'}],
            }
        },
        mounted() {
            this.getCountries()
        },
        computed: {
            cities() {
                if (this.country_id) {
                    return this.countries.find(
                        country => { return country.id === this.country_id}).cities
                } else {
                    return [];
                }
            }
        },
        methods: {
            getCountries() {
                axios.get('/countries').then(res => {
                    this.countries = res.data.countries
                    if (res.data.city_id) {
                        this.city_id = res.data.city_id
                        this.country_id = res.data.country_id
                    }
                })
            },
            addProduct() {
                this.products_selected.push({'name': 'اختر المنتج', 'quantity': 'الكمية'});
            },
            addPackage() {
                this.packages_selected.push({'name': 'اختر الباقة', 'quantity': 'الكمية'});
            },
            detailsContent() {
                if (this.name == '' ||
                    this.mobile == '' ||
                    this.city_id == '' ||
                    this.district == '') {
                    this.errorMsg = true;
                    this.sending  = false;
                    return false;
                }

                if (this.products_selected.length == 1 && 
                this.products_selected[0].name == 'اختر المنتج' && 
                this.products_selected[0].quantity == 'الكمية' && 
                this.packages_selected.length == 1 && 
                this.packages_selected[0].name == 'اختر الباقة' 
                && this.packages_selected[0].quantity == 'الكمية') {
                    this.errorMsg = true;
                    this.sending  = false;
                    return false;
                }
                
                this.details += '<br>';

                this.products_selected.forEach(product => {
                    if (product.name != 'اختر المنتج') {
                        product.quantity = product.quantity != 'الكمية' ? product.quantity : 1
                        this.details += product.name + ' | الكمية: ' + product.quantity
                        this.details += '<br>';
                    }
                });
                
                this.packages_selected.forEach(thePackage => {
                    if (thePackage.name != 'اختر الباقة') {
                        thePackage.quantity = thePackage.quantity != 'الكمية' ? thePackage.quantity : 1
                        this.details += thePackage.name + ' | الكمية: ' + thePackage.quantity
                        this.details += '<br>';
                    }
                });

                if (this.coupon != '') {
                    this.details += '<br><br>';
                    this.details += 'كوبون الخصم: ' + this.coupon;
                }

                return true
            },
            submit() {
                this.sending  = true;
                this.errorMsg = false;
                if(!this.detailsContent())
                    return false
                
                let requestData = {
                    name            : this.name,
                    mobile          : this.mobile,
                    city_id         : this.city_id,
                    district        : this.district,
                    details         : this.details,
                };

                axios.post('fast-orders-store', requestData).then(respond => {
                    console.log(respond.data);
                    this.successMsg = true;
                    this.sending  = false;
                    this.name = ''
                    this.mobile = ''
                    this.country_id = ''
                    this.city_id = ''
                    this.district = ''
                    this.details = ''
                }).catch(error => {
                    console.log(error);
                    this.errorSend = true;
                })
            }
        }
    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables";

    .spinner 
        margin     : 0 auto;
        width      : 50px;
        height     : 24px;
        text-align : center;
        font-size  : 10px;
    

    .spinner > div 
        background-color  : #fff;
        height            : 100%;
        width             : 6px;
        display           : inline-block;

        -webkit-animation : sk-stretchdelay 1.2s infinite ease-in-out;
        animation         : sk-stretchdelay 1.2s infinite ease-in-out;
    

    .spinner .rect2 
        -webkit-animation-delay : -1.1s;
        animation-delay         : -1.1s;
    

    .spinner .rect3 
        -webkit-animation-delay : -1.0s;
        animation-delay         : -1.0s;
    

    .spinner .rect4 
        -webkit-animation-delay : -0.9s;
        animation-delay         : -0.9s;
    

    .spinner .rect5 
        -webkit-animation-delay : -0.8s;
        animation-delay         : -0.8s;
    

    @-webkit-keyframes sk-stretchdelay 
        0%, 40%, 100% 
            -webkit-transform : scaleY(0.4)
        
        20% 
            -webkit-transform : scaleY(1.0)
        
    

    @keyframes sk-stretchdelay 
        0%, 40%, 100% 
            transform         : scaleY(0.4);
            -webkit-transform : scaleY(0.4);
        
        20% 
            transform         : scaleY(1.0);
            -webkit-transform : scaleY(1.0);
        

    @media #{$mobile}

    

</style>