<table id="memoirs" class='table table-bordered table-hover '>
    {{-- <tr>
        <th>#</th>
        <td>{{$option->id}}</td>
    </tr> --}}
    <tr>
        <th>اسم الخيار</th>
        <td>{{$option->name}}</td>
    </tr>
    <tr>
        <th>رمز الخيار</th>
        <td>{{$option->product_code}}</td>
    </tr>
    <tr>
        <th>السعر الأساسي</th>
        <td>{{$option->original_price}}</td>
    </tr>
    <tr>
        <th>السعر المخفض</th>
        <td>{{$option->price_after_discount}}</td>
    </tr>
    <tr>
        <th>الكمية</th>
        <td>{{$option->quantity}}</td>
    </tr>
    {{-- <tr>
        <th>Searched</th>
        <td>{{$option->searched}}</td>
    </tr>
    <tr>
        <th>Bought</th>
        <td>{{$option->bought}}</td>
    </tr> --}}
    <tr>
        <th>متاح؟</th>
        <td>@if($option->availability == 1)
                <span class="label label-success">نعم</span> @else
                <span class="label label-danger">لا</span> @endif
        </td>
    </tr>
    <tr>
        <th>تاريخ الإتاحة</th>
        <td>{{$option->availability_date}}</td>
    </tr>
</table>
