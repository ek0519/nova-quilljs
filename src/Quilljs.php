<?php

namespace Ek0519\Quilljs;

use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Trix\PendingAttachment;

class Quilljs extends Trix
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'quilljs';


    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        $this->tooltip();
        $this->height();
        $this->paddingBottom();
        $this->fullWidth();
        $this->maxFileSize(2);
        $this->config();
    }
    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(
        NovaRequest $request,
        $requestAttribute,
        $model,
        $attribute
    ) {
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = $request[$requestAttribute];

            if (! isset($model->id)) {
                $quilljs = $this;
                $modelClass = get_class($model);
                if(method_exists($modelClass, 'created')) {
                    call_user_func_array("$modelClass::created", [
                        function ($object) use ($quilljs, $request) {
                            $quilljs->persistImages($request, $object);
                        }
                    ]);
                }
            } else {
                $this->persistImages($request, $model);
            }
        }
    }

    public function persistImages(NovaRequest $request, $object)
    {
        if ($request->persisted && $images = json_decode($request->persisted)) {
            if (!empty($images)) {
                $this->persistedImg($images, $object);
            }
        }
    }

    public function persistedImg(array $images, $model)
    {
        foreach ($images as $image) {
            $pending = PendingAttachment::where('draft_id', $image)->first();
            if ($pending) {
                $pending->persist($this, $model);
            }
        }
    }

    public function tooltip(bool $value=false)
    {
        return $value == true ? $this->withMeta(['tooltip'=> config('tooltip') ?? []]) : null;
    }

    public function config(array $options=[])
    {
        if (empty($options)) {
            $options = config('quilljs');
        }
        return $this->withMeta(['options'=> $options]);
    }

    public function placeholder($text)
    {
        return $this->withMeta(['placeholder'=> $text]);
    }

    public function height(int $value=300)
    {
        return $this->withMeta(['height' => $value]);
    }

    public function paddingBottom(int $value=0)
    {
        return $this->withMeta(['paddingBottom' => $value]);
    }

    public function fullWidth(bool $value=true)
    {
        return $this->withMeta(['stacked' => $value]);
    }

    public function maxFileSize(int $value = 2)
    {
        return $this->withMeta(['maxFileSize' => $value]);
    }

    public function uploadUrlSplit(string $value='')
    {
        return $this->withMeta(['split' => $value]);
    }
}
