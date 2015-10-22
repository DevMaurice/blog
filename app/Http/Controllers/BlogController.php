<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Jobs\BlogIndexData;
use App\Post;
use App\Services\RssFeed;
use App\Services\SiteMap;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{

/**
 * @param  Request
 * @return view 
 */
public function index(Request $request)
  {
    $tag = $request->get('tag');
    $data = $this->dispatch(new BlogIndexData($tag));
    $layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';

    return view($layout, $data);
  }

  public function showPost($slug, Request $request)
  {
    $post = Post::with('tags')->whereSlug($slug)->firstOrFail();
    $tag = $request->get('tag');
    if ($tag) {
        $tag = Tag::whereTag($tag)->firstOrFail();
    }

    return view($post->layout, compact('post', 'tag','slug'));
  }
    
  /**
   * @param  RssFeed
   * @return rss feeds
   */
  public function rss(RssFeed $feed)
  {
    $rss = $feed->getRSS();

    return response($rss)
      ->header('Content-type', 'application/rss+xml');
  }

  /**
   * @param  SiteMap
   * @return xml formatted site map
   */
  public function siteMap(SiteMap $siteMap)
  {
    $map = $siteMap->getSiteMap();

    return response($map)
      ->header('Content-type', 'text/xml');
  }
}


