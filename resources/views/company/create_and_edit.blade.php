@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-body">
                    <h2 class="text-center">
                        <i class="glyphicon glyphicon-edit"></i>
                        @if($company->id)
                            Edit Entity Company
                        @else
                            Add Entity Company
                        @endif
                    </h2>

                    <hr>

                    @include('common.error')

                    @if($company->id)
                        <form action="{{ route('.company.update', $company->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            @else
                                <form action="{{ route('company.store') }}" method="POST" accept-charset="UTF-8">
                                    @endif

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" value="{{ old('name', $company->name ) }}" placeholder="company name" required/>
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="contact" value="{{ old('contact', $company->contact ) }}" placeholder="Email" required/>
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="stock" value="{{ old('stock', $company->stock ) }}" placeholder="Total Stock" required/>
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="worth" value="{{ old('worth', $company->worth ) }}" placeholder="Current market value" />
                                    </div>

                                    <div class="well well-sm">
                                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> save</button>
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </div>

@endsection