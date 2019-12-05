# Laravel Nova Quilljs editor Field

A Laravel Nova implementation of the [Quill editor for Vue.js](https://github.com/surmon-china/vue-quill-editor)

## Installation

Install via composer
```
composer require ek0519/quilljs
```

## Image upload

This Nova field provides native attachments driver which works similar to [Trix File Uploads](https://nova.laravel.com/docs/2.0/resources/fields.html#trix-field).

To use this attachments driver, publish and run the migration(also publish quilljs config to set [toolbar](https://quilljs.com/docs/modules/toolbar/)):

```
php artisan vendor:publish --provider="Ek0519\Quilljs\FieldServiceProvider"
php artisan migrate
```

Then, allow users to upload images, just like with Trix field, chaining the withFiles method onto the field's definition. When calling this method, you should pass the name of the filesystem disk that images should be stored on(in this example, we use **public**, please use this command `php artisan storage:link` ):

```
use Ek0519\Quilljs\Quilljs;

Quilljs::make('content')
        ->withFiles('public')
        ->placeholder('please enter here')
        ->rules('required'),

```

## Customizing Quilljs Toolbar

If you want to change toolbar's setting, you can change quilljs.php in config folder, referrence quilljs's web site https://quilljs.com/docs/modules/toolbar

```
return [
    ["bold", "italic", "underline", "strike"],
    ["blockquote", "code-block"],
    [ ['header'=> 1 ], ['header'=> 2]],
    [['list'=> "ordered" ], ['list'=> "bullet" ]],
    [[ 'script'=> "sub" ], [ 'script'=> "super" ]],
    [[ 'indent'=> "-1" ], [ 'indent'=> "+1" ]],
    [[ 'direction'=> "rtl" ]],
    [[ 'size'=> ["small", false, "large", "huge"] ]],
    [[ 'header'=> [1, 2, 3, 4, 5, 6, false] ]],
    [[ 'color'=> [] ], [ 'background'=> [] ]],
    [[ 'font'=> [] ]],
    [[ 'align'=> [] ]],
    ["clean"],
    ["link", "image", "video"]
];
```

## Video embed

Only support **Youtube** **Facebook**

### Youtube

* Example url https://www.youtube.com/watch?v=rgHqK6Dge4w

![](https://i.imgur.com/qNYYk91.png)

### Facebook

* Example Url https://www.facebook.com/standnewshk/videos/272770540314346/UzpfSTEzODQ4NjU1NDY6MTAyMjEzMDE0MDExMDk2MDM/

![](https://i.imgur.com/lqDj6Y4.png)

