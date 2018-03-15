@extends('layouts.sosmed')

@section('title')
    Dashboard
@endsection

@section('extra-style')

@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h6 class="panel-title text-center">HIGHLIGHT <span style="color:red">Sosmed</span>
            </h6>
        </div>

        <div class="panel-body">
            <form onsubmit="return false;">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <input class="form-control"/>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="control-label">Compared To</label>
                            <input class="form-control"/>
                        </div>
                    </div>
                </div>
            </form>

            <h3>Report Highlights as of {{date('H')}} day ( {{date('d M Y')}}) compred to ( {{date('d M Y')}} )</h3>
            <hr>

            <dd>
                <dl>1. Official Account All TV By Total Followers
                    <ul>
                        <li>Twitter #1 Metro
                            <ul>
                                <li>1. Metro</li>
                            </ul>
                        </li>
                        <li>Facebook #1 Metro</li>
                        <li>Instagram #1 Metro</li>
                    </ul>
                    <br>
                </dl>
                <dl>2. Group Official Account by Total Followers
                    <ul>
                        <li>Twitter #1 Metro</li>
                        <li>Facebook #1 Metro</li>
                        <li>Instagram #1 Metro</li>
                    </ul>
                    <br>
                </dl>
                <dl>3. Group Overall Accounts ( Official + Program ) by Total Followers
                    <ul>
                        <li>Twitter #1 Metro</li>
                        <li>Facebook #1 Metro</li>
                        <li>Instagram #1 Metro</li>
                    </ul>
                    <br>
                </dl>
                <dl>4. Program Accounts ALL TV by Additional Followers from yesterday
                    <ul>
                        <li>Twitter #1 Metro</li>
                        <li>Facebook #1 Metro</li>
                        <li>Instagram #1 Metro</li>
                    </ul>
                    <br>
                </dl>
                <dl>5. 4TV's Followers Achievement below 50%
                    <ul>
                        <li>Twitter #1 Metro</li>
                        <li>Facebook #1 Metro</li>
                        <li>Instagram #1 Metro</li>
                    </ul>
                    <br>
                </dl>
            </ul>
            
        </div>
    </div>
    
@endsection

@push('extra-script')
    <script>
        $(function(){
            function addKoma(nStr)
            {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }

            
        })
    </script>
@endpush