<template>
  <div>
    <div class="row receiver_checkbox" >
      
        <label>
          <input
            type="checkbox"
            v-model="$store.state.checkout.receiver_info.another_reciver_checked"
            style="margin: 0 10px"
            @change="updateShippingMethods()"
          />
          إرسال الطلب لشخص آخر
        </label>
      
    </div>
    <div v-if="$store.state.checkout.receiver_info.another_reciver_checked">
      <form class="form-horizontal">
        <div class="form-group">
          <label for="receiver_name" class="col-md-2 required">اسم مستلم الطلب</label>

          <div class="col-md-4">
            <input
              id="receiver_name"
              type="text"
              class="form-control"
              name="receiver_name"
              v-model="$store.state.checkout.receiver_info.receiver_name"
              required
              autofocus
            />
            <template>
              <span class="help-block"></span>
            </template>
          </div>
        </div>
        <div :class="`form-group ${errors['receiver_info.receiver_mobile']? ' has-error' : '' }`">
          <label for="receiver_mobile" class="col-md-2 required">رقم الجوال</label>

          <div class="col-md-4">
            <input
              id="receiver_mobile"
              type="text"
              class="form-control"
              name="receiver_mobile"
              v-model="$store.state.checkout.receiver_info.receiver_mobile"
              required
              autofocus
            />

            <template v-if="errors['receiver_info.receiver_mobile']">
              <span class="help-block">{{ errors['receiver_info.receiver_mobile'][0] }}</span>
            </template>
          </div>
        </div>
        <div class="form-group">
          <label for="receiver_city_id" class="col-md-2 required">المدينة</label>
          <div class="col-md-4">
            <select
              name="city_id"
              id="receiver_city_id"
              class="form-control"
              @change="updateShippingMethods()"
              v-model="$store.state.checkout.receiver_info.receiver_city_id"
              required
            >
              <option selected disabled value="select">اختر</option>
              <template v-for="(city, indexC) in cities">
                <option v-if="city.id == 1" selected :value="city.id" v-text="city.name_ar" :key="indexC"></option>
              </template>
            </select>
            <template>
              <span class="help-block"></span>
            </template>
          </div>
        </div>
        <div v-if="districts.length" class="form-group">
          <label for="districts" class="col-md-2 required">الحي</label>
          <div class="col-md-4">
            <select
              name="receiver_district_id"
              id="district"
              class="form-control"
              required
              v-model="$store.state.checkout.receiver_info.receiver_district_id"
              @change="districtSelected()"
            >
              <option selected disabled>اختر</option>
              <option v-for="district in districts" :value="district.id" v-text="district.name_ar"></option>
            </select>
            <template v-if="errors['receiver_info.receiver_district_id']">
              <span class="help-block">{{ errors['receiver_info.receiver_district_id'][0] }}</span>
            </template>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      another_reciver: false,
      form: {
        another_reciver_checked   : false,
        receiver_name             : "",
        receiver_mobile           : "",
        receiver_city_id          : "",
        receiver_district_id      : ""
      },
      countries: [],
      errors: []
    };
  },
  mounted() {
    this.getCountries();
    this.$store.state.checkout.receiver_info.country_id = 1; // 1 = Saudi Arabia
  },
  computed: {
    cities() {
      if (this.$store.state.checkout.receiver_info.country_id) {
        return this.countries.find(country => {
          return (
            country.id === this.$store.state.checkout.receiver_info.country_id
          );
        }).cities;
      }
      return [];
    },
    districts() {
      if (
        this.$store.state.checkout.receiver_info.receiver_city_id &&
        this.cities.length
      ) {
        return this.cities.find(city => {
          return (
            city.id ===
            this.$store.state.checkout.receiver_info.receiver_city_id
          );
        }).districts;
      }
      return [];
    },
    district_zone() {
      if (this.districts.length) {
        return this.districts.find(district => {
          return (
            district.id ===
            this.$store.state.checkout.receiver_info.receiver_district_id
          );
        }).district_zone;
      }
    }
  },
  methods: {
    getCountries() {
      axios.get("/countries").then(res => {
        this.countries = res.data.countries;
      });
    },
    showLogin() {
      this.$root.showLogin = true;
    },
    updateShippingMethods() {
      this.$root.$refs.shipping.getAddressShippingMethods();
    },
    districtSelected() {
      if (this.$store.state.checkout.receiver_info.receiver_district_id) {
        this.$root.$refs.shipping.updateShippingPrice();
      }
    }
  }
};
</script>


<style lang="scss" scoped>
/*@import "~styles/frontend/variables";*/

.receiver_checkbox{
  margin-top: 10px;
  margin-bottom: 25px;
}

.control-label.required:after {
  content: "*";
  color: red;
}

.help-block {
  font-size: 12px;
}

form {
  padding: 15px;
}
</style>