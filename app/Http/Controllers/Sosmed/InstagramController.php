<?php
 
namespace App\Http\Controllers\Sosmed;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
 
class InstagramController extends Controller
{
    public function redirectToInstagramProvider()
    {
        return Socialite::with('instagram')->scopes([
            "public_content"])->redirect();
    }
 
    public function handleProviderInstagramCallback()
    {
        $insta = Socialite::driver('instagram')->user();
        $details = [
            "access_token" => $insta->token
        ];
 
        if(Auth::user()->instagram){
            Auth::user()->instagram()->update($details);
        }else{
            Auth::user()->instagram()->create($details);
        }
        return redirect('/');
    }

    public function cek_instagram(){
        $id="https://instagram.com/hotissueindosiar";
    
        $url = $id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        $output;
        $metaPos = strpos($result, "<meta content=");
        $metaPosFollower = strpos($result, "edge_followed_by");
        
        if($metaPos != false)
        {
            $meta = substr($result ,$metaPos,70);
            //meghdare followers
            $followerPos = strpos($meta , "Followers");
            $followers = substr($meta , 15 , $followerPos-15);
            $output['pengikut'] = $followers;
            //meghdare followings
            // $commaPos = strpos($meta , ',');
            $followingPos = strpos($meta, 'Following');
            $followings = substr($meta , $followerPos+10 , $followingPos - ($followerPos+10));
            $output['mengikuti'] = $followings; //mengikuti
            //meghdare posts
            $seccondCommaPos = $followingPos + 10;
            $postsPos = strpos($meta, 'Post');
            $posts = substr($meta, $seccondCommaPos , $postsPos - $seccondCommaPos);
            $output['jumlah_post'] = $posts; //jumlah post
            
            //image finder
            $imgPos = strpos($result, "og:image");
            $image = substr($result , $imgPos+19 , 200);
            $endimgPos = strpos($image, "/>");
            $finalImagePos = substr($result, $imgPos+19 , $endimgPos-2);
            // $output[4] = $finalImagePos;

            //allnumber follower
            $metafollower = substr($result ,$metaPosFollower,70);
            $followerPos = preg_match_all('!\d+!', $metafollower, $matches);
            if(isset($matches)){
                $output['all_follower']=$matches[0][0]; //semua pengikut
            }else{
                $output['all_follower']=0; //semua pengikut
            }
            
            return $output;
        }
        else
        {
            return null;
        }
    }

    public function cek_bahasa()
    {
        $server=\Request::server('HTTP_ACCEPT_LANGUAGE');

        return response()->json($server);
    }

    public function tes_instagram(){
        $instagram = new \InstagramScraper\Instagram();
        $medias = $instagram->getMedias('thecommentnet_', 25);
        
        // Let's look at $media
        $media = $medias[0];
        echo "Media info:\n";
        echo "Id: {$media->getId()}\n";
        echo "Shortcode: {$media->getShortCode()}\n";
        echo "Created at: {$media->getCreatedTime()}\n";
        echo "Caption: {$media->getCaption()}\n";
        echo "Number of comments: {$media->getCommentsCount()}";
        echo "Number of likes: {$media->getLikesCount()}";
        echo "Get link: {$media->getLink()}";
        echo "High resolution image: {$media->getImageHighResolutionUrl()}";
        echo "Media type (video or image): {$media->getType()}";
        $account = $media->getOwner();
        echo "Account info:\n";
        echo "Id: {$account->getId()}\n";
        echo "Username: {$account->getUsername()}\n";
        echo "Full name: {$account->getFullName()}\n";
        echo "Profile pic url: {$account->getProfilePicUrl()}\n";
    }

    public function get_account(){
        $instagram = new \InstagramScraper\Instagram();
        // For getting information about account you don't need to auth:
        $account = $instagram->getAccount('thecommentnet_');
        // Available fields
        echo "Account info:\n";
        echo "Id: {$account->getId()}\n";
        echo "Username: {$account->getUsername()}\n";
        echo "Full name: {$account->getFullName()}\n";
        echo "Biography: {$account->getBiography()}\n";
        echo "Profile picture url: {$account->getProfilePicUrl()}\n";
        echo "External link: {$account->getExternalUrl()}\n";
        echo "Number of published posts: {$account->getMediaCount()}\n";
        echo "Number of followers: {$account->getFollowsCount()}\n";
        echo "Number of follows: {$account->getFollowedByCount()}\n";
        echo "Is private: {$account->isPrivate()}\n";
        echo "Is verified: {$account->isVerified()}\n";
    }
}