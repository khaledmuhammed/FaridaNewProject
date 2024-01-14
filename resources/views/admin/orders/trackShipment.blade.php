@extends('adminlte::page') @section('content_header')
    <h1>تتبع الشحنة رقم {{$aramexID}} - للطلب رقم #{{$order_id}}</h1>
@endsection @section('content')
    <div class="row">
        <div class="col-xs-12">
            <section class="invoice">
                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>المكان</th>
                            <th>ملاحظات</th>
                        </thead>
                        <tbody>
                        @foreach($trackShipment as $track)
                            <tr>
                                <td>{{date("Y-m-d H:i:s", preg_replace( '/[^0-9]/', '', explode('+', $track->UpdateDateTime)[0] ) / 1000)}}</td>
                                <td>{{$track->UpdateDescription}}</td>
                                <td>{{$track->UpdateLocation}}</td>
                                <td>{{$track->Comments}}</td>
                            </tr>           
                        @endforeach 
                        </tbody>
                    </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->                
            </section>
        </div>
    </div>
@endsection
