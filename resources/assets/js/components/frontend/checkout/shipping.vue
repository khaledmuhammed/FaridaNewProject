<template>
  <div>
    <div class="step-header" :class="{'step-success' : $store.state.checkout.shipping}">
      <span class="step-num">2</span>
      <span class="step-title">{{$t('Shipping Methods')}}</span>
    </div>
    <div class="form-horizontal">
      <div class="radio col-sm-12 col-xs-12 no-padding" v-for="method in shippingMethods">
        <label class="">
          <input
            :value="method.id"
            type="radio"
            v-model="shipping"
            :disabled="!$store.state.checkout.address && !$store.state.checkout.guest_info.city_id"
          />
          <span class="flex">
            <span>{{method.theName}} &nbsp; &nbsp;</span>
            <!-- <span class="price text-primary" v-if="shippingPrice > 0"> *{{shippingPrice}} ريال  </span> -->
            <span class="price text-primary" v-if="shippingPrice > 0 && method.id == 2">*{{shippingPrice}} ريال</span>
            <!-- <span class="price text-primary" v-else>
              <div class="spinner" v-if="isLoading">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
              </div>
            </span> -->
          </span>
        </label>
        <!-- <span class="text-left col-sm-4 col-xs-4 no-padding" v-if="method.id == 1"><img src="/images/smsa.png" width="50" /></span>
                <span class="text-left col-sm-4 col-xs-4 no-padding" v-if="method.id == 2"><img src="/images/fastlo.png" width="50" /></span>
        <span class="text-left col-sm-4 col-xs-4 no-padding" v-if="method.id == 3"><img src="/images/fastlo.png" width="50" v-if="city_id && city_id == 1" /> <img src="/images/smsa.png" width="50" v-if="city_id && city_id != 1" /></span>-->
      </div>
      <div style="margin: 20px 0 0 0;" class="col-sm-12 col-xs-12 no-padding">
        <div class="form-group">
          <label for="date" class="col-sm-3">تاريخ التوصيل</label>
          <div class="col-sm-9">
            <datetime
              id="date"
              v-model="$store.state.checkout.shippingDate"
              @input = "$store.state.checkout.shippingTime = ''"
              :min-datetime="minShippingDate"
              :max-datetime="maxShippingDate"
              :phrases="{ok: 'تأكيد', cancel: 'إلغاء'}"
              :disabled="!$store.state.checkout.address && !$store.state.checkout.guest_info.city_id"
            ></datetime>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3">وقت التوصيل</label>
          <div class="col-sm-9">
            <datetime
              type="time"
              v-model="$store.state.checkout.shippingTime"
              :min-datetime = "minTime"
              :max-datetime = "maxTime"
              :format="{ hour: 'numeric', minute: '2-digit'}"
              :phrases="{ok: 'تأكيد', cancel: 'إلغاء'}"
              :minute-step="5"
              :disabled="!$store.state.checkout.address && !$store.state.checkout.guest_info.city_id || $store.state.checkout.shippingDate == ''"
               use12-hour
              @close ="checkTime"
            ></datetime>
            <small class="text-red">التوصيل بعد ساعتين كحد أدنى<br/> متاح من الساعة 3 وحتى 11 مساءً</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["free_shipping_limit"],
  data() {
    return {
      shippingMethods    : [],
      isLoading          : false,
      shippingPrice      : 0,
      shippingDate       : "",
      shippingTime       : "",
      minShippingDate    : "",
      maxShippingDate    : "",
      errMsg             : false
    };
  },
  mounted() {
    this.minDate(new Date());
    this.maxDate();
    axios.get("shipping-methods").then(res => {
      // console.log(res.data);
      this.shippingMethods = res.data;
    });
  },
  computed: {
    shipping: {
      get() {
        return this.$store.state.checkout.shipping;
      },
      set(value) {
        let price = value == 2 ? this.shippingPrice : 0;
        // let price = this.shippingMethods.find(method => {return method.id === value}).price
        // console.log(price);
        // Check if shipping price is free
        let cart = this.$root.$refs.cart.getCartItems();

        // console.log(cart)
        let shipping_free = false;
        cart.forEach(item => {
          if (item.shipping_free == 1) {
            shipping_free = true;
            return;
          }
        });

        // Search country id
        let country_id = "";
        if (this.$store.state.checkout.address) {
          country_id = this.$root.$refs.address.addresses.find(address => {
            return address.id === this.$store.state.checkout.address;
          }).city.country_id;
        } else if (this.$store.state.checkout.guest_info.country_id) {
          country_id = this.$store.state.checkout.guest_info.country_id;
        }

        // Set shipping price is free
        if (shipping_free == true && country_id == 1) {
          // 1 = Saudi Arabia
          price = 0;
        } else if (
          this.$store.state.cart.prices.totalPrice >=
            this.free_shipping_limit &&
          country_id == 1
        ) {
          price = 0;
        }

        this.$store.commit("updateShipping", {
          value,
          price
        });
        // this.updateShippingPrice()
        this.$root.$refs.payment.updatePaymentMethods();
      }
    },
    city_id() {
      if (this.$store.state.checkout.address) {
        return this.$root.$refs.address.addresses.find(address => {
          return address.id === this.$store.state.checkout.address;
        }).city_id;
      } else if (this.$store.state.checkout.guest_info.city_id) {
        return this.$store.state.checkout.guest_info.city_id;
      }

      return false;
    },
    country_id() {
      if (this.$store.state.checkout.address) {
        return this.$root.$refs.address.addresses.find(address => {
          return address.id === this.$store.state.checkout.address;
        }).city.country_id;
      } else if (this.$store.state.checkout.guest_info.country_id) {
        return this.$store.state.checkout.guest_info.country_id;
      }

      return false;
    },
    minTime(){
      if (this.$store.state.checkout.shippingDate == '') return null;
      const shippingDate = new Date(this.$store.state.checkout.shippingDate)
      const threePM = new Date()
      threePM.setHours(15,0,0,0)
      if(this.isToday(shippingDate)){
        const afterAnHourAndThirty = new Date( Date.now() + 5400000)
        return threePM > afterAnHourAndThirty ? threePM.toISOString() : afterAnHourAndThirty.toISOString()
      }else{
        return threePM.toISOString()
      }
    },
    maxTime(){
      const t = new Date()
      t.setHours(23,0,0,0)
      return t.toISOString()
    },
  },
  methods: {
    isToday(date){
      const today = new Date()
      return date.getDate() == today.getDate() && date.getMonth() == today.getMonth() && date.getFullYear() == today.getFullYear()
    },
    minDate(date) {
      if (date.getHours() == 23) {
        this.minShippingDate = new Date(
          Date.now() + 1 * 24 * 60 * 60 * 1000
        ).toISOString();
      } else {
        this.minShippingDate = date.toISOString();
      }
    },
    checkTime(){
      const minTime = new Date(this.minTime)
      const maxTime = new Date(this.maxTime)
      const shippingTime = new Date(this.$store.state.checkout.shippingTime)
      if(minTime > shippingTime || maxTime < shippingTime){
        setTimeout(() => {
          this.$store.state.checkout.shippingTime = ""
        }, 0)
      }
    },
    maxDate() {
      this.maxShippingDate = new Date(
        Date.now() + 60 * 24 * 60 * 60 * 1000
      ).toISOString();
    },

    updateShippingPrice() {
      // shipping 2 = Delivery in riyadh
      if (this.$store.state.checkout.receiver_info.receiver_district_id || this.$store.state.checkout.guest_info.district_id) {
        if (this.$store.state.checkout.receiver_info.another_reciver_checked) {
          this.shippingPrice = this.$root.$refs.receiver.district_zone.shipping_price;
          return;
        }
        this.shippingPrice = this.$root.$refs.guest.district_zone.shipping_price;
        return;
      }
      if (this.$store.state.checkout.address) {
        this.shippingPrice = this.$root.$refs.address.addresses.find(address => {
          return address.id === this.$store.state.checkout.address;
        }).district.districtZoneShippingPrice;
        return;
      }
    },
    getAddressShippingMethods() {

      if (this.$store.state.checkout.receiver_info.receiver_city_id && this.$store.state.checkout.receiver_info.another_reciver_checked) { // get city from receiver_info
        axios.get("/shipping-methods/city/" + this.$store.state.checkout.receiver_info.receiver_city_id).then(res => {
          this.shippingMethods = res.data;
          this.$store.state.checkout.shipping = null;
          // this.shipping                       = res.data[0].id;
        });
      } else {
        if (this.$store.state.checkout.address) { // get city from address
          axios.get("/shipping-methods/address/" + this.$store.state.checkout.address).then(res => {
              this.shippingMethods = res.data;
              this.$store.state.checkout.shipping = null;
              this.updateShippingPrice();
              // this.shipping                       = res.data[0].id
            });
        } else if (this.$store.state.checkout.guest_info.city_id) { // get city from guest_info
          axios.get("/shipping-methods/city/" + this.$store.state.checkout.guest_info.city_id).then(res => {
            this.shippingMethods = res.data;
            this.$store.state.checkout.shipping = null;
            // this.shipping                       = res.data[0].id
          });
        }
      }
    }
  }
};
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"

    .control-label.required:after
        content: "*"
        color: red

    .help-block
        font-size: 12px

    form
        padding: 15px

    label
        margin-bottom : 10px

    small
        color: #bbb

    .spinner
        margin     : 0 auto
        width      : 50px
        height     : 24px
        text-align : center
        font-size  : 10px

    .spinner > div
        background-color  : $brand-primary
        height            : 100%
        width             : 6px
        display           : inline-block

        -webkit-animation : sk-stretchdelay 1.2s infinite ease-in-out
        animation         : sk-stretchdelay 1.2s infinite ease-in-out

    .spinner .rect2
        -webkit-animation-delay : -1.1s
        animation-delay         : -1.1s

    .spinner .rect3
        -webkit-animation-delay : -1.0s
        animation-delay         : -1.0s

    .spinner .rect4
        -webkit-animation-delay : -0.9s
        animation-delay         : -0.9s

    .spinner .rect5
        -webkit-animation-delay : -0.8s
        animation-delay         : -0.8s

    @-webkit-keyframes sk-stretchdelay
        0%, 40%, 100% 
            -webkit-transform : scaleY(0.4)

        20% 
            -webkit-transform : scaleY(1.0)

    @keyframes sk-stretchdelay
        0%, 40%, 100%
            transform         : scaleY(0.4)
            -webkit-transform : scaleY(0.4)

        20%
            transform         : scaleY(1.0)
            -webkit-transform : scaleY(1.0)
</style>