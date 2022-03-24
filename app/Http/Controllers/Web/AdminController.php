<?php

namespace app\Http\Controllers\Web;

use App\News;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use app\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

// use app\News;

/**
* Class UsersController
* @package Tagydes\Http\Controllers
*/
class AdminController extends Controller
{
    use UserTrait;

    public function news(Request $request)
    {
        $user = $this->getUser();
        $news = News::orderBy('created_at', 'desc')->paginate(5);
        return view('news.list', compact('news'));
    }

    public function viewNews(News $news)
    {
        return view('news.view', compact('news'));
    }

    public function createNews(Request $request)
    {

        if($request->has('title')){
            $user = $this->getUser();

            $user = $this->getUser();
            $title      = $request->input('title');
            $desc       = $request->input('description');
            $category   = $request->input('category');
            $file       = $request->file('image');
            $video      = $request->input('video');
            $expire_at  = $request->input('date');
            $language   = $request->input('language');
            $provider   = $request->input('provider') == 'on' ? 1 : 0;
            $reseller   = $request->input('reseller') == 'on' ? 1 : 0;
            $customer   = $request->input('customer') == 'on' ? 1 : 0;

            if($file){
                $fileName =  $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $realPath = $file->getRealPath();
                $fileSize = $file->getSize();
                $fileMimeType = $file->getMimeType();
                $destinationPath = 'uploads';
                $file->move($destinationPath,$file->getClientOriginalName());

                $news = new News();

                if($user->provider){
                    $news->provider_id  = $user->provider->id;
                }
                if($user->reseller){
                    $news->reseller_id  = $user->reseller->id;
                }
                $news->title        = $title;
                $news->description  = $desc;
                $news->expires_at   = $expire_at;
                $news->provider     = $provider;
                $news->language     = $language;
                $news->reseller     = $reseller;
                $news->customer     = $customer;
                $news->image = 'uploads/'.$fileName;
                $news->video = str_replace('watch?v=', 'embed/', $video);;
                Auth::user()->news()->save($news);
            }else{
                $news = new News();
                if($user->provider)
                {
                    $news->provider_id  = $user->provider->id;
                }
                if($user->reseller)
                {
                    $news->reseller_id  = $user->reseller->id;
                }
                $news->title        = $title;
                $news->description  = $desc;
                $news->expires_at   = $expire_at;
                $news->provider     = $provider;
                $news->reseller     = $reseller;
                $news->customer     = $customer;
                $news->video = str_replace('watch?v=', 'embed/', $video);;
                Auth::user()->news()->save($news);
            }
            return redirect('news');
        }else{

            $news = News::get();
            return view('news.add',compact('news'));
        }
    }


    public function editNews(News $news)
    {
        $user = $this->getUser();
        if($user->id == $news->user_id){
            return view('news.edit',compact('news'));
        }
    }

    public function deleteNews(News $news)
    {

        News::where('id', $news->id)->delete();

        return redirect('news')->withSuccess(trans('deleted'));
    }

    public function updateNews(Request $request, News $news)
    {

        $file       = $request->file('image');
        $title      = $request->input('title');
        $desc       = $request->input('description');
        $category   = $request->input('category');
        $file       = $request->file('image');
        $video      = $request->input('video');
        $expires_at = $request->input('date');
        $language   = $request->input('language');
        $provider   = $request->input('provider') == 'on' ? 1 : 0;
        $reseller   = $request->input('reseller') == 'on' ? 1 : 0;
        $customer   = $request->input('customer') == 'on' ? 1 : 0;


        $data = [];
        if($file){
            $fileName           =  $file->getClientOriginalName();
            $extension          = $file->getClientOriginalExtension();
            $realPath           = $file->getRealPath();
            $fileSize           = $file->getSize();
            $fileMimeType       = $file->getMimeType();
            $destinationPath    = '/uploads';

            $file->move(public_path().$destinationPath,$file->getClientOriginalName());

            $data = [
                'title'         => $title,
                'description'   => $desc,
                'video'         => $video,
                'expires_at'    => $expires_at,
                'category'      => $category,
                'provider'      => $provider,
                'reseller'      => $reseller,
                'language'      => $language,
                'customer'      => $customer,
                'image'         => 'uploads/'.$fileName,
            ];
        }else{
            $data = [
                'title'         => $title,
                'description'   => $desc,
                'video'         => $video,
                'expires_at'    => $expires_at,
                'category'      => $category,
                'provider'      => $provider,
                'language'      => $language,
                'reseller'      => $reseller,
                'customer'      => $customer,
            ];
        }

        News::where('id', $news->id)->update($data);
        return redirect('news')->withSuccess(trans('app.reseller_updated'));
    }

}
