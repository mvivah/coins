@extends('layouts.app')
    @section('content')
        <div class="col-md-6 col-sm-12">
            @if(isset($query))
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    @if(count($query)>0)
                        <table class="table table-striped">
                        <thead></thead>
                            @foreach ($query as $result)
                                <tr>
                                    <td>{{$result->$tableName}}</td><td>{{$result->$whereColumn}}</td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Sorry!</strong> Your query retuned no results.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="col-md-6 col-sm-12">
                    {!! $queryChart->container() !!}
                    {!! $queryChart->script() !!}
                </div>
            </div>
            @else
            Nothing was sent
            @endif
        </div>
    @endsection