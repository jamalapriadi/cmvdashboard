@extends('layouts.app')

@section('content')
    <style>
        .verticalTableHeader {
            text-align:center;
            white-space:nowrap;
            g-origin:50% 50%;
            -webkit-transform: rotate(90deg);
            -moz-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            -o-transform: rotate(90deg);
            transform: rotate(90deg);
            
        }
        .verticalTableHeader p {
            margin:0 -100% ;
            display:inline-block;
        }
        .verticalTableHeader p:before{
            content:'';
            width:0;
            padding-top:110%;/* takes width as reference, + 10% for faking some extra padding */
            display:inline-block;
            vertical-align:middle;
        }
    </style>


    <table class="table table-striped">
        <thead>
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Name</th>
                <th rowspan="2">Type Account</th>
                <th colspan="4">Twitter</th>
                <th colspan="4">Facebook</th>
                <th colspan="4">Instagram</th>
                {{-- <th colspan="4">Youtube</th> --}}
            </tr>
            <tr>
                @for($a=0;$a<3;$a++)
                    <th>Last Day</th>
                    <th>Now</th>
                    <th>Growth</th>
                    <th>Num of Growth</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @php 
                $no=0;
            @endphp
            @foreach($data as $row)
                @php
                    $no++;
                @endphp 
                <tr>
                    <td>{{$no}}</td>
                    <td>{{$row['unit_name']}}</td>
                    <td>{{$row['type_account']}}</td>
                    <td>{{number_format($row['official']['twitter']['last_day'])}}</td>
                    <td>{{number_format($row['official']['twitter']['follower'])}}</td>
                    <td>{{round($row['official']['twitter']['growth'],3)}} %</td>
                    <td>{{number_format($row['official']['twitter']['num_of_growth'])}}</td>
                    <td>{{number_format($row['official']['facebook']['last_day'])}}</td>
                    <td>{{number_format($row['official']['facebook']['follower'])}}</td>
                    <td>{{round($row['official']['facebook']['growth'],3)}} %</td>
                    <td>{{number_format($row['official']['facebook']['num_of_growth'])}}</td>
                    <td>{{number_format($row['official']['instagram']['last_day'])}}</td>
                    <td>{{number_format($row['official']['instagram']['follower'])}}</td>
                    <td>{{round($row['official']['instagram']['growth'],3)}} %</td>
                    <td>{{number_format($row['official']['instagram']['num_of_growth'])}}</td>
                </tr>
                <tr>
                    <td class="verticalTableHeader" rowspan="{{count($row['program'])+1}}">PROGRAM</td>
                </tr>
                @foreach($row['program'] as $program)
                <tr>
                    <td colspan="2">{{$program['name']}}</td>
                    @if(count($program['official'])>0)
                        @if(count($program['official']['twitter'])>0)
                            <td>{{number_format($program['official']['twitter']['last_day'])}}</td>
                            <td>{{number_format($program['official']['twitter']['follower'])}}</td>
                            <td>{{round($program['official']['twitter']['growth'],3)}} %</td>
                            <td>{{number_format($program['official']['twitter']['num_of_growth'])}}</td>
                        @else 
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        @endif

                        @if(count($program['official']['facebook'])>0)
                            <td>{{number_format($program['official']['facebook']['last_day'])}}</td>
                            <td>{{number_format($program['official']['facebook']['follower'])}}</td>
                            <td>{{round($program['official']['facebook']['growth'],3)}} %</td>
                            <td>{{number_format($program['official']['facebook']['num_of_growth'])}}</td>
                        @else 
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        @endif

                        @if(count($program['official']['instagram'])>0)
                            <td>{{number_format($program['official']['instagram']['last_day'])}}</td>
                            <td>{{number_format($program['official']['instagram']['follower'])}}</td>
                            <td>{{round($program['official']['instagram']['growth'],3)}} %</td>
                            <td>{{number_format($program['official']['instagram']['num_of_growth'])}}</td>
                        @else 
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        @endif
                    @endif
                </tr>
                @endforeach

            @endforeach
        </tbody>
    </table>
@stop