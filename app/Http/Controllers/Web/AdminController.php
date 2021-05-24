<?php

namespace app\Http\Controllers\Web;

use App\News;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

// use app\News;

/**
 * Class UsersController
 * @package Tagydes\Http\Controllers
 */
class AdminController extends Controller
{

    public function news(Request $request)
    {

        $news = News::get();

        return view('news.list', compact('news'));
    }

    public function viewNews(News $news)
    {

        $new = News::find($news)->first();
        return view('news.view', compact('new'));

    }

    public function createNews(Request $request)
    {

        if($request->has('title')){
            // get image
            $title = $request->input('title');
            $desc = $request->input('description');
            $file = $request->file('image');
            $video = $request->input('video');

            if($file){
                $fileName =  $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $realPath = $file->getRealPath();
                $fileSize = $file->getSize();
                $fileMimeType = $file->getMimeType();
                $destinationPath = 'uploads';
                $file->move($destinationPath,$file->getClientOriginalName());

                $news = new News();
                $news->title = $title;
                $news->description = $desc;
                $news->image = 'uploads/'.$fileName;
                $news->video = str_replace('watch?v=', 'embed/', $video);;
                // $news->save();
                Auth::user()->news()->save($news);
            }else{
                $news = new News();
                $news->title = $title;
                $news->description = $desc;
                // $news->user_id = Auth::user()->id;
                $news->video = str_replace('watch?v=', 'embed/', $video);;
                // dd(Auth::user());
                Auth::user()->news()->save($news);
                // $news->save();
            }
            return redirect('news');
        }else{
            return view('news.add');
        }
    }


    public function editNews(News $news)
    {
        return view('news.edit',compact('news'));
    }

    public function deleteNews(News $news){

        News::where('id', $news->id)->delete();
        return redirect('news')->withSuccess(trans('deleted'));
    }

    public function updateNews(Request $request){
        $id = $request->input('id');
        $file = $request->file('image');
        $data = [];
        if($file){
            $fileName =  $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $realPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $fileMimeType = $file->getMimeType();
            $destinationPath = 'uploads';
            $file->move($destinationPath,$file->getClientOriginalName());
            $data = ['title'=>$request->input('title') , 'description' => $request->input('description') , 'video' => $request->input('video') , 'image' => 'uploads/'.$fileName ];
        }else{
            $data = ['title'=>$request->input('title') , 'description' => $request->input('description') , 'video' => $request->input('video')];
        }
        News::where('id', $id)->update($data);
        return redirect('news')->withSuccess(trans('app.reseller_updated'));
    }

}
