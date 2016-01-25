@extends('pdf.pdf')

@section('title')
    Reporte Semanal
@endsection

@section('style')
    <style>
        .tendence {
            color: green;
        }

        .tendence.neg {
            color: red;
        }

        #week td {
            text-align: center;
            vertical-align: middle;
        }

        #WeekReport td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@endsection

@section('script')
@endsection

@section('content')
    <div id="semanal">
        {{ HTML::reportTable($account, 'week') }}
    </div>
@endsection

@section('footer')
@endsection