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
    </style>
@endsection

@section('script')
@endsection

@section('content')
    {{ HTML::reportTable($account, 'week') }}
@endsection

@section('footer')
@endsection