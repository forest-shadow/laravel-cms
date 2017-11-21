<?php
use App\Post;
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/post/{id}/{name}/{author}', 'PostController@show_post');

Route::get('/contact', function() {
    $people = ['Edwin', 'Jose', 'James', 'Peter', 'Maria'];

   return view('contact', compact('people'));
});



/*
|--------------------------------------------------------------------------
| Routes for practice raw sql queries
|--------------------------------------------------------------------------
*/
Route::get('/insert', function() {
    DB::insert('insert into posts(title, content) values(?,?)',
        [
            'PHP with Laravel',
            'Laravel is the best thing that has happens with PHP'
        ]
    );
});

//Route::get('/read', function() {
//   $results = DB::select('select * from posts where id = ?', [1]);
//
//   foreach($results as $post) {
//       return $post->title;
//   }
//});

//Route::get('/update', function() {
//    $updated = DB::update('update posts set title="Updated title" where id = ?', [1]);
//
//    return $updated;
//});
//
//Route::get('/delete', function() {
//    $deleted = DB::delete('delete from posts where id = ?', [1]);
//
//    return $deleted;
//});


/*
|--------------------------------------------------------------------------
| Eloquent/ORM
|--------------------------------------------------------------------------
*/

Route::get('/read', function() {
    $posts = Post::all();

    foreach($posts as $post) {
        return $post->title;
    }
});

Route::get('/find', function() {
    $post = Post::find(2);

    return $post->title;
});

Route::get('/findwhere', function() {
    $posts = Post::where('id', '>', 1)->orderBy('id', 'desc')->get();

    return $posts;
});

Route::get('/findmore', function() {
    $posts = Post::where('users_count', '<', 50)->firstOrFail();
});

Route::get('/basicinsert', function() {
    $post = new Post;

    $post->title = 'New Eloquent title insert';
    $post->content = 'Wow eloquent is really cool, look at this content';

    $post->save();
});

Route::get('/basicinsert2', function() {
    $post = Post::find(2);

    $post->title = 'New Eloquent title insert 2';
    $post->content = 'Wow eloquent is really cool, look at this content';

    $post->save();
});

Route::get('/create', function() {
    Post::create(['title' => 'The create method', 'content' => 'Wow, I\'m learning alot with Edwin Diaz']);
});

Route::get('/update', function() {
    Post::where('id', 2)->where('is_admin', 0)->update(['title' => 'New PHP Title', 'content' => 'I love my instructor Edwin.']);
});

Route::get('/delete', function() {
    $post = Post::find(2);

    $post->delete();
});

Route::get('/delete1', function() {
    Post::destroy(3, 4);
});


/*
|--------------------------------------------------------------------------
| Eloquent/ORM: Soft Delete
|--------------------------------------------------------------------------
*/
Route::get('/softdelete', function() {
    Post::find(3)->delete();
});

Route::get('/readsoftdelete', function() {
    $post = Post::withTrashed()->get();

//    $post = Post::onlyTrashed()->get();
    return $post;
});

Route::get('/restore', function() {
    Post::withTrashed()->where('is_admin', 0)->restore();
});

Route::get('/deletesoftdeleted', function() {
    Post::onlyTrashed()->forceDelete();
});

/*
|--------------------------------------------------------------------------
| Eloquent/ORM:
|--------------------------------------------------------------------------
*/
Route::get('/user/{id}/post', function($id) {
    return User::find($id)->post;
});

Route::get('/post/{id}/user', function($id) {
    return Post::find($id)->user->name;
});