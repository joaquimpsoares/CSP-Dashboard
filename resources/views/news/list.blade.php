@extends('layouts.master')

@section('content')
@include('partials.messages')

<div class="panel panel-inverse">
    <!-- begin panel-heading -->
    <div class="panel-heading">
        <!-- end panel-heading -->
        <div class="panel-body">
            @if(auth()->user()->user_level_id == 1)
            <div class="my-3 row flex-md-row flex-column-reverse">
                <div class="col-md-12">
                    <a href="{{ route('news.create') }}" class="button">
                        <i class="mr-2 fas fa-plus"></i>
                        Add News
                    </a>
                </div>
            </div>
            @endif
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="relative px-4 pt-16 pb-20 bg-gray-50 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8">

                <div class="relative mx-auto max-w-7xl">
                    <div class="text-center">
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            {{ ucwords(trans_choice('messages.announcement', 2)) }}
                        </h2>
                    </div>
                    <div class="grid max-w-lg gap-5 mx-auto mt-12 lg:grid-cols-3 lg:max-w-none">
                        @foreach ($news as $new)
                        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
                            <div class="flex-shrink-0">
                                <img class="object-cover w-full h-48" src="{{$new->image}}" alt="">
                            </div>
                            <div class="flex flex-col justify-between flex-1 p-6 ">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-indigo-600">
                                        <a href="{{route('news.view', $new->id)}}" class="hover:underline">
                                            {{$new->category}}
                                        </a>
                                    </p>
                                    <a href="{{route('news.view', $new->id)}}" class="block mt-2">
                                        <p class="text-xl font-semibold text-gray-900">
                                            {{$new->title}}
                                        </p>
                                        <p class="mt-3 text-base text-justify text-gray-500">
                                            {!! \Illuminate\Support\Str::limit(\Michelf\Markdown::defaultTransform($new->description), 430, $end='...') !!}                                        </p>
                                    </a>
                                </div>
                                @php
                                $user = DB::table('users')->where('id', $new->user_id)->first();
                                @endphp
                                <div class="flex items-center mt-6">
                                    <div class="flex-shrink-0">
                                        <a href="{{route('news.view', $new->id)}}">
                                            <span class="sr-only">Roel Aufderehar</span>
                                            <img class="w-10 h-10 rounded-full" src="{{$user->avatar}}" alt="">
                                        </a>
                                    </div>
                                    <div class="ml-3">

                                        <p class="text-sm font-medium text-gray-900">
                                            <a href="#" class="hover:underline">
                                                {{$user->name}}
                                            </a>
                                        </p>
                                        <div class="flex space-x-1 text-sm text-gray-500">
                                            <time datetime="2020-03-16">
                                                {{$new->created_at}}
                                            </time>
                                            <span aria-hidden="true">
                                                &middot;
                                            </span>
                                            <span>
                                                6 min read
                                            </span>
                                        </div>
                                        <x-a href="{{ route('news.edit', $new->id) }}"  title="@lang('app.edit_customer')" >
                                            Edit
                                        </x-a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



            {{-- <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <thead>
                                        <tr>
                                            <!-- @lang('app.company_name') -->
                                            <th class="min-width-80 text-nowrap"> Image </th>
                                            @if(auth()->user()->user_level_id == 1)
                                            <th class="text-center min-width-250">@lang('app.action')</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($news))
                                        <?php $i=0; ?>
                                        @foreach ($news as $new)
                                        <tr >
                                            <td class="align-middle" onclick="modal({{$i}});" style="cursor: pointer;">
                                                <div class="media-sm">
                                                    <a class="media-left" href="javascript:;">
                                                        @if($new->image != null)
                                                        <img src="<?php if($new->image){echo $new->image;}else{echo "uploads/face.png";} ?>" style="width:100px;height:70px;"/>
                                                        @elseif($new->video)
                                                        <iframe src="{{$new->video}}" width="100p" height="70" frameborder="0" allowfullscreen></iframe>
                                                        @else
                                                        @endif
                                                    </a>
                                                    <div class="media-body" style="padding-left:20px;">
                                                        <h5 class="media-heading">{{$new->title}}</h5>
                                                        <p>{{$new->description}}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            @if(auth()->user()->user_level_id == 1)
                                            <td class="align-middle">
                                                <a href="{{ route('news.edit', $new->id) }}" class="btn btn-icon edit" title="@lang('app.edit_customer')" data-toggle="tooltip" data-placement="top">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="{{ route('news.delete', $new->id) }}" class="btn btn-icon" title="@lang('app.delete_customer')" data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="@lang('app.please_confirm')" data-confirm-text="@lang('app.are_you_sure_delete_customer')" data-confirm-delete="@lang('app.yes_delete_him')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <!-- <a  class="btn btn-icon" title="@lang('app.delete_customer')" data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="@lang('app.please_confirm')" data-confirm-text="@lang('app.are_you_sure_delete_customer')" data-confirm-delete="@lang('app.yes_delete_him')">
                                                    More
                                                </a> -->
                                            </td>

                                            @endif

                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="7"><em>@lang('app.no_records_found')</em></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div id="m" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="closeIcon">&times;</span>
                    <div class="modal-header" style="border-bottom-color:#fff;">
                        <span id="title" data-preserve-html-node="true" style="font-size: 22pt;">Ari Paul</span>
                    </div>

                    <div class="modal-body">
                        <div class="row" style="backgrond:#333333;">
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-12">
                                <img id="speaker_image" src="" style="width:100%; padding:20px;" alt="Avatar">
                                <iframe id="video" src="" width="100%" height="100%" frameborder="0" allowfullscreen style="min-height: 350px"></iframe>

                            </div>
                            <div class="col-md-7">
                                <span id="speaker_description" style="font-color:#d3d3d3;font-size:12pt;overflow:auto;word-wrap:break-word;">
                                    More info coming soon.
                                </span>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12">
                            <button type="button" onclick="closeDialog(this);" style="float:right;" class="btn btn-primary">
                                Close
                            </button>
                        </div>

                    </div>
                </div>
            </div>


            @stop

            @section('scripts')
            <script>

                $("#status").change(function () {
                    $("#customers-form").submit();
                });

                $(document).ready(function() {

                });

                // get the close icon instance
                var span = document.getElementsByClassName("closeIcon")[0];
                span.onclick = function() {
                    // when click close icon, close the modal .
                    var modal = document.getElementById("m");
                    modal.style.display = "none";
                    document.getElementById("video").src='';
                }

                window.onclick = function(event) {
                    // triger this part when tap on the outside of modal.
                    var modal = document.getElementById("m");
                    if (event.target == modal) {
                        // when tap on the outsite of modal, close the modal.
                        modal.style.display = "none";
                        document.getElementById("video").src='';
                    }
                }

                function modal(xx){


                    var news = `{{ json_encode($news)}}`;
                    news     = news.replace( /&quot;/g, '"' ),
                    news = news.replace(/(\r\n|\n|\r)/gm," ");

                    //alert(news);
                    //alert(news.substring(400,489))
                    try {
                        var decodedNews = JSON.parse(news);
                        title = decodedNews.data[xx].title;
                        desc = decodedNews.data[xx].description;
                        image = decodedNews.data[xx].image;
                        video = decodedNews.data[xx].video;
                    }catch(error) {
                        alert(error);
                    }
                    // console.warn(decodedNews);
                    document.getElementById("title").innerHTML=title;
                    document.getElementById("speaker_description").innerHTML=desc;
                    if(image != null && image != ""){
                        document.getElementById("speaker_image").src=image;
                        document.getElementById("speaker_image").style.display = 'block';
                        document.getElementById("video").style.display = 'none';
                    }else if(video != null && video != ""){
                        document.getElementById("video").src=video;
                        document.getElementById("speaker_image").style.display = 'none';
                        document.getElementById("video").style.display = 'block';
                    }

                    var modal = document.getElementById("m");
                    modal.style.display = "block";
                }
                function closeDialog(e){
                    var modal = document.getElementById("m");
                    modal.style.display = "none";
                    document.getElementById("video").src='';

                }


            </script>
            --}}
            @stop
