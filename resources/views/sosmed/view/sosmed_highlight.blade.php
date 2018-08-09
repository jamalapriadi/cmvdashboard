@php 
    $data=array();
@endphp
@foreach($group as $key=>$row)
    @if($row->id==4)
        @foreach($tambahanInews as $ins)
            @if($ins->id=="TOTAL")
                @php 
                    $data[]=array(
                        'id'=>$row->id,
                        'unit_name'=>$row->unit_name,
                        'tw'=>1,
                        'growth_twitter'=>$ins->growth_tw." %",
                        'tw_sekarang'=>$ins->tw_sekarang,
                        'rank_tw'=>$ins->tw_sekarang,
                        'num_of_growth_tw'=>$ins->num_of_growth_tw,
                        'fb'=>2,
                        'growth_fb'=>$ins->growth_fb." %",
                        'fb_sekarang'=>$ins->fb_sekarang,
                        'rank_fb'=>$ins->fb_sekarang,
                        'num_of_growth_fb'=>$ins->num_of_growth_fb,
                        'ig'=>3,
                        'growth_ig'=>$ins->growth_ig,
                        'ig_sekarang'=>$ins->ig_sekarang,
                        'rank_ig'=>$ins->ig_sekarang,
                        'num_of_growth_ig'=>$ins->num_of_growth_ig
                    );
                @endphp
            @endif
        @endforeach
    @else 
        @php 
            $data[]=array(
                'id'=>$row->id,
                'unit_name'=>$row->unit_name,
                'tw'=>1,
                'growth_twitter'=>$row->growth_tw." %",
                'tw_sekarang'=>$row->tw_sekarang,
                'rank_tw'=>$row->tw_sekarang,
                'num_of_growth_tw'=>$row->num_of_growth_tw,
                'fb'=>2,
                'growth_fb'=>$row->growth_fb." %",
                'fb_sekarang'=>$row->fb_sekarang,
                'rank_fb'=>$row->fb_sekarang,
                'num_of_growth_fb'=>$row->num_of_growth_fb,
                'ig'=>3,
                'growth_ig'=>$row->growth_ig." %",
                'ig_sekarang'=>$row->ig_sekarang,
                'rank_ig'=>$row->ig_sekarang,
                'num_of_growth_ig'=>$row->num_of_growth_ig
            );
        @endphp
    @endif
@endforeach

@php 
    return $data;
@endphp