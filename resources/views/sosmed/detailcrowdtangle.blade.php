@extends('layouts.coreui.main')

@section('content')
    <div class="card card-default">
        <div class="card-header">Detail Crowdtangle</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Page Name</th>
                        <th>{{$model->page_name}}</th>
                    </tr>
                    <tr>
                        <th>User Name</th>
                        <th>{{$model->user_name}}</th>
                    </tr>
                    <tr>
                        <th>Page ID</th>
                        <th>{{$model->page_id}}</th>
                    </tr>
                    <tr>
                        <th>URL</th>
                        <th>{{$model->url}}</th>
                    </tr>
                    <tr>
                        <th>Begining of Interval</th>
                        <th>{{$model->beginning_of_interval}}</th>
                    </tr>
                    <tr>
                        <th>Complete</th>
                        <th>{{$model->complete}}</th>
                    </tr>
                    <tr>
                        <th>Page Likes</th>
                        <th>{{$model->page_likes}}</th>
                    </tr>
                    <tr>
                        <th>Page Like Growth</th>
                        <th>{{$model->page_like_growth}}</th>
                    </tr>
                    <tr>
                        <th>Post Count</th>
                        <th>{{$model->post_count}}</th>
                    </tr>
                    <tr>
                        <th>Total Interaction</th>
                        <th>{{$model->total_interactions}}</th>
                    </tr>
                    <tr>
                        <th>Interaction Growth</th>
                        <th>{{$model->interaction_growth}}</th>
                    </tr>
                    <tr>
                        <th>Interaction Rate</th>
                        <th>{{$model->interaction_rate}}</th>
                    </tr>
                    <tr>
                        <th>Comments</th>
                        <th>{{$model->comments}}</th>
                    </tr>
                    <tr>
                        <th>Shared</th>
                        <th>{{$model->shares}}</th>
                    </tr>
                    <tr>
                        <th>Total Reaction Including Like</th>
                        <th>{{$model->total_reactions_including_likes}}</th>
                    </tr>
                    <tr>
                        <th>Likes</th>
                        <th>{{$model->likes}}</th>
                    </tr>
                    <tr>
                        <th>Angry</th>
                        <th>{{$model->angry}}</th>
                    </tr>
                    <tr>
                        <th>Haha</th>
                        <th>{{$model->haha}}</th>
                    </tr>
                    <tr>
                        <th>Wow</th>
                        <th>{{$model->wow}}</th>
                    </tr>
                    <tr>
                        <th>Sad</th>
                        <th>{{$model->sad}}</th>
                    </tr>
                    <tr>
                        <th>Love</th>
                        <th>{{$model->love}}</th>
                    </tr>
                    <tr>
                        <th>Photo Posts</th>
                        <th>{{$model->photo_posts}}</th>
                    </tr>
                    <tr>
                        <th>Photo Interaction</th>
                        <th>{{$model->photo_interactions}}</th>
                    </tr>
                    <tr>
                        <th>Photo Interaction Rate</th>
                        <th>{{$model->photo_interaction_rate}}</th>
                    </tr>
                    <tr>
                        <th>Link Posts</th>
                        <th>{{$model->link_posts}}</th>
                    </tr>
                    <tr>
                        <th>Link Interaction</th>
                        <th>{{$model->link_interactions}}</th>
                    </tr>
                    <tr>
                        <th>Link Interaction Rate</th>
                        <th>{{$model->link_interaction_rate}}</th>
                    </tr>
                    <tr>
                        <th>Status Post</th>
                        <th>{{$model->status_posts}}</th>
                    </tr>
                    <tr>
                        <th>Status Interaction</th>
                        <th>{{$model->status_interactions}}</th>
                    </tr>
                    <tr>
                        <th>Status Interaction Rate</th>
                        <th>{{$model->status_interaction_rate}}</th>
                    </tr>
                    <tr>
                        <th>Facebook Video Post Excluding Live</th>
                        <th>{{$model->facebook_video_posts_excluding_live}}</th>
                    </tr>
                    <tr>
                        <th>Facebook Video Interaction Excluding Live</th>
                        <th>{{$model->facebook_video_interactions_excluding_live}}</th>
                    </tr>
                    <tr>
                        <th>Facebook Video Interaction Rate Excluding Live</th>
                        <th>{{$model->facebook_video_interaction_rate_excluding_live}}</th>
                    </tr>
                    <tr>
                        <th>Facebook Live Post</th>
                        <th>{{$model->facebook_live_video_posts}}</th>
                    </tr>
                    <tr>
                        <th>Facebook Live Interactions</th>
                        <th>{{$model->facebook_live_interactions}}</th>
                    </tr>
                    <tr>
                        <th>Facebook Live Interaction Rate</th>
                        <th>{{$model->facebook_live_interaction_rate}}</th>
                    </tr>
                    <tr>
                        <th>Owned Facebook video Posts Video and Live</th>
                        <th>{{$model->owned_facebook_video_posts_fb_video_and_live}}</th>
                    </tr>
                    <tr>
                        <th>Owned Facebook video views Video and Live</th>
                        <th>{{$model->owned_video_views_fb_video_and_live}}</th>
                    </tr>
                    <tr>
                        <th>Owned Facebook video views from page post Video and Live</th>
                        <th>{{$model->owned_video_views_from_page_posts_fb_video_and_live}}</th>
                    </tr>
                    <tr>
                        <th>Owned Video Views</th>
                        <th>{{$model->owned_video_views_fb_video}}</th>
                    </tr>
                    <tr>
                        <th>Owned Video Views Live</th>
                        <th>{{$model->owned_video_views_fb_live}}</th>
                    </tr>
                    <tr>
                        <th>Owned Video Views From Share</th>
                        <th>{{$model->owned_video_views_from_shares_fb_video_and_live}}</th>
                    </tr>
                    <tr>
                        <th>Owned Video Views Share by page not including in owned Video</th>
                        <th>{{$model->videos_shared_by_page_not_included_in_owned_videos}}</th>
                    </tr>
                    <tr>
                        <th>Owned Video Views on video share by page</th>
                        <th>{{$model->video_views_on_videos_shared_by_page}}</th>
                    </tr>
                    <tr>
                        <th>Total video time</th>
                        <th>{{$model->total_video_time}}</th>
                    </tr>
                    <tr>
                        <th>Video unknown owned video views</th>
                        <th>{{$model->videos_unknown_owned_video_views}}</th>
                    </tr>
                    <tr>
                        <th>Videos unknown owned video views from page posts</th>
                        <th>{{$model->videos_unknown_owned_video_views_from_page_posts}}</th>
                    </tr>
                    <tr>
                        <th>Videos unknown owned facebook videos</th>
                        <th>{{$model->videos_unknown_owned_facebook_videos}}</th>
                    </tr>
                    <tr>
                        <th>Videos unknown videos shared by page niov</th>
                        <th>{{$model->videos_unknown_videos_shared_by_page_niov}}</th>
                    </tr>
                    <tr>
                        <th>Videos unknown video views on videos shared by page</th>
                        <th>{{$model->videos_unknown_video_views_on_videos_shared_by_page}}</th>
                    </tr>
                    <tr>
                        <th>Videos 0 15 seconds owned video views</th>
                        <th>{{$model->videos_0_15_seconds_owned_video_views}}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    

    <div id="divModal"></div>
@stop