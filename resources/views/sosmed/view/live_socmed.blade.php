<div class="row">
    @foreach($sosmed as $row)
        @if($row->sosmed_id==1)
            <div class="col-lg-3">
                <div class="card card-accent-success">
                    <div class="card-header" bg-info>Twitter</div>
                    <div class="card-body">
                        <a class="twitter-timeline" data-height="600" data-theme="light" data-link-color="#E81C4F" href="https://twitter.com/{{$row->unit_sosmed_name}}?ref_src=twsrc%5Etfw">Tweets by {{$row->unit_sosmed_name}}</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    </div>
                </div>
            </div>
        @endif

        @if($row->sosmed_id==2)
            <div class="col-lg-3">
                <div class="card card-accent-primary">
                    <div class="card-header">Facebook</div>
                    <div class="card-body">
                        <div id="fb-root"></div>
    
                        {!! $row->unit_sosmed_account_id !!}
                    </div>
                </div>
            </div>
        @endif

        @if($row->sosmed_id==3)
            <div class="col-lg-3">
                <div class="card card-accent-warning">
                    <div class="card-header">Instagram</div>
                    <div class="card-body">
                        {!! $row->unit_sosmed_account_id !!}
                    </div>
                </div>
            </div>
        @endif

        @if($row->sosmed_id==4)
            <div class="col-lg-3">
                <div class="card card-accent-danger">
                    <div class="card-header">Youtube</div>
                    <div class="card-body">
                        <iframe src="http://youtube.com/embed/?listType=user_uploads&list={{$row->unit_sosmed_account_id}}" height="600px" frameborder="o"></iframe>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

<!-- Ini untuk script Facebook API -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId            : '326236844797670',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v3.1'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>