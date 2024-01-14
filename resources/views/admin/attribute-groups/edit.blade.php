@extends('adminlte::page')

@section('content')
    <attribute-group label="{{__('Attribute Group Name')}}"
                     add="{{__('Add')}}"
                     save="{{__('Save')}}"
                     delete_label="{{__('Delete')}}"
                     delete_confirm="{{__('Do you want to delete it ?')}}"
                     edit_label="{{__('Attribute Group Edit')}}"
                     update_group_action="{{action('Admin\AttributeGroupController@update',$attributeGroup->id)}}"
                     store_group_attribute_action="{{action('Admin\AttributeController@store')}}"
                     update_group_attribute_action="{{action('Admin\AttributeController@update', '')}}"
                     :attribute_group="{{$attributeGroup}}"
                     attributes_label="{{__('Attributes')}}"
                     attribute="{{__('Attribute')}}"
                     add_attribute="{{__('Add') . ' ' . __('New Attribute')}}">
    </attribute-group>
@endsection
