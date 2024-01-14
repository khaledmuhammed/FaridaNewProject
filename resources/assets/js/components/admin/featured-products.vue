<template>
    <div>
        <div class="form-group">
            <label class="control-label col-sm-2">نوع المنتجات المميزة</label>
            <div class="col-sm-10">
                <input type="radio" v-model="type" value="category" id="type-category">
                <label class="control-label" for="type-category" style="cursor: pointer;">قسم</label>
                <br>
                <input type="radio" v-model="type" value="products" id="type-products">
                <label class="control-label" for="type-products" style="cursor: pointer;">منتجات</label>
            </div>
        </div>

        <div v-if="type == 'category'" class="form-group">
            <label for="products" class="control-label col-sm-2">القسم</label>
            <div class="col-sm-10">
                <multiselect v-model="category"
                            :options="categories"
                            :clear-on-select="false"
                            placeholder="القسم"
                            :close-on-select="true"
                            label="name_ar"
                            :showLabels="false"
                            :searchable="true">
                <span slot="noResult">لا يوجدأقسام</span>
            </multiselect>
            <span v-if="categoryError" style="color:red">يجب ان تختار القسم</span>
            <input type="hidden" name="category" :value="category ? category.id : 0"/>
            </div>
        </div>

        <div v-else :class="['form-group', {'has-error':productsError}]">
            <label for="products" class="control-label col-sm-2">المنتجات</label>
            <div class="col-sm-10">
                <product-select name="products"
                                :multiple="true"
                                :selected="oldProducts">
                </product-select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:["productsError","categoryError","oldCategory", "oldProducts", "categories"],
    data(){
        return {
            type: this.oldCategory ? 'category' : 'products',
            category:this.oldCategory
        }
    }
}
</script>

<style scoped>
</style>