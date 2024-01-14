@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Question</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($question, ['action' => ['Admin\QuestionController@update', $question->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('product_id') ? 'has-error' :  ''}}">
                        {!! Form::label('product_id', 'Product', ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!!  Form::select('product_id',$products , $question->product_id, ['placeholder' => 'select','class' => 'form-control'])  !!}
                            @if($errors->first('product_id'))
                                <div class="help-block">{{$errors->first('product_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('text') ? 'has-error' :  ''}}">
                        {!! Form::label('text', 'Text', ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('text', $question->text, ['class' => 'form-control','required'=>'required' , 'placeholder'=>'text ' ]) !!}
                            @if($errors->first('text'))
                                <div class="help-block">{{$errors->first('text')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10">
                        <button type="submit" class="btn btn-info btn-block btn-flat">Save</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
