# COD team code template for Laravel 5.4

## Package needed

1. [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)
   
   *  Show debug bar for Developer.   
   *  This package will not loaded for `production` environment.    

2. [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)

  *  Using command `php artisan ide-helper:generate` to create reference file which support IDE like PHP Storm to browser classes.
  *  This package will not loaded for `production` environment.

3. [cviebrock/eloquent-sluggable](https://github.com/cviebrock/eloquent-sluggable)
  
  * Using for auto generate slug field for Eloquent Model :
  
  ```
      use Cviebrock\EloquentSluggable\Sluggable;
      use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
      use Illuminate\Database\Eloquent\Model;
      
      class Post extends Model
      {
          use Sluggable;
          use SluggableScopeHelpers;
      
          public function sluggable()
          {
              return [
                  'slug' => [
                      'source' => 'title'
                  ]
              ];
          }
  ```
  With `SluggableScopeHelpers` we can using `Post::findBySlug($slug)` in frontend.
  
4. [doctrine/dbal](https://github.com/doctrine/dbal)

  * Allow Laravel Migration script `change()` function - change field type - to work.
  
5. [intervention/image](http://image.intervention.io/) 
   
   * Using for work with image, especially `intervention/imagecache`.
   
   * All of our upload image will be located in `public/files` folder, if we want to display a post image in frontend with size 60x60, we first add a block in `config/imagecache.php` :
   ```
      '60x60' => function($image) {
                  return $image->fit(60, 60);
              },
   ```
   and display image link in frontend `url('img/cache/60x60/'.$image)`.

6. [laracasts/flash](https://github.com/laracasts/flash)   
  
   * Using for flash message in our Application.
   
7. [laravel/socialite](https://github.com/laravel/socialite)   
   
   * Using for Google, Facebook Authentication.
   
8. [laravelcollective/html](https://laravelcollective.com/docs/5.3/html)   

   * Using for HTML and Form Facades.
  
9. [maatwebsite/excel](http://www.maatwebsite.nl/laravel-excel/docs/getting-started)
   
   * Excel Export Tools
   
10. [predis/predis](https://laravel.com/docs/5.4/redis) 

   * Work with Redis Driver (Session and Cache)
   
### Install.
   
   * Copy `.env.example` to `.env` and field the database , Redis and Google Authentication.
   * This code shipped with Garena Frontend Authentication too.
   
   * Run `composer install` to install need packages.
   
   * Run `chmod -R 777 public/files`, `chmod -R 777 storage` and `chmod -R 777 bootstrap`.
   
   * Add an administrator to test Google Authentication for admin `php artisan add:admin --email=manhquan.do@ved.com.vn`.
   
   * Access `<site_url>/admin` for testing.
   
   * Access `<site_url>/user` to test Frontend Authentication with Garena.
   
### Usage
   
   * All Controller function for Frontend must be located at `App\Http\Controller\FrontendController.php`.
   
   * Controller Logic Method should be put in `App\Site.php` as static function.
      
   * Add new admin using `php artisan add:admin --email=example@gmail.com`.
   
   * For MySQL performance on Live, please count with conditions first and if condition > 0 then select data. For example :
   
   ```
             $checkExistedCount = Account::where('uid', $gUser['uid'])->count();
     
             if ($checkExistedCount > 0) {
                 $checkExisted = Account::where('uid', $gUser['uid'])->get();
                 $account = $checkExisted->first();
             }
   ```
   * Always using MySQL commandline `SHOW PROCESSLIST` while monitoring test performance.
   
   * When add new content to application, follow those steps below :
      
      1. Create migration and Model using `php artisan make:migration` and `php artisan make:model`.
      2. Add new row to `config/site.php` - which already have example with `users` content. 
      3. No need to create admin router.
      4. Copy `UsersControllers.php` to new Controller and modify table name and validation rules only.
      5. Copy `views/admin/users` directory to new directory and modify those blade files.
      6. When application on production, please set `APP_ENV=production` and `APP_DEBUG=false` in `.env`   
   
   