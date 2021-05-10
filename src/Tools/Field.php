<?php

namespace Dcat\Admin\DcatConfig\Tools;

use Illuminate\Support\Str;

class Field
{
    protected $fieldData;

    protected $form;

    public function __construct($fieldData, $form)
    {
        $this->fieldData = $fieldData;
        $this->form = $form;
    }

    public static function make($fieldData, $form)
    {
        return new self($fieldData, $form);
    }

    /**
     * @param \Dcat\Admin\Form\Field $field
     * @param $rule
     * @return \Dcat\Admin\Form\Field
     */
    public function rule(\Dcat\Admin\Form\Field $field, $rules)
    {
        foreach ((array)$rules as $rule){
            if ($rule === 'required')
            {
                $field->required();
            }
            if (Str::contains($rule,'min:')){
                [$r,$num] = explode(':',$rule);
                $field->minLength($num);
            }
            if (Str::contains($rule,'max:')){
                [$r,$num] = explode(':',$rule);
                $field->maxLength($num);
            }
        }
        return $field;
    }

    public function text()
    {
        $field = $this->form->text($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);
//        dd($field);
        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function select()
    {
        $field = $this->form->select($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name'])->options($this->option());
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function multipleSelect()
    {
        $field = $this->form->multipleSelect($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name'])->options($this->option());
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function listbox()
    {
        $field = $this->form->listbox($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name'])->options($this->option());
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function textarea()
    {
        $field = $this->form->textarea($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function radio()
    {
        $field = $this->form->radio($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name'])->options($this->option());
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function checkbox()
    {
        $field = $this->form->checkbox($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name'])->options($this->option());
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function email()
    {
        $field = $this->form->email($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function password()
    {
        $field = $this->form->password($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function url()
    {
        $field = $this->form->url($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function ip()
    {
        $field = $this->form->ip($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function mobile()
    {
        $field = $this->form->mobile($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function color()
    {
        $field = $this->form->color($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function time()
    {
        $field = $this->form->time($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function date()
    {
        $field = $this->form->date($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function datetime()
    {
        $field = $this->form->datetime($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function file()
    {
        $field = $this->form->file($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name'])->autoUpload()->url(admin_url('files'));
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function image()
    {
        $field = $this->form->image($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name'])->autoUpload()->url(admin_url('files'));
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function multipleFile()
    {
        $field = $this->form->multipleFile($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name'])->autoUpload()->url(admin_url('files'));

        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function multipleImage()
    {
        $field = $this->form->multipleImage($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name'])->autoUpload()->url(admin_url('files'));
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function editor()
    {
        $field = $this->form->editor($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    //protected function markdown()
    //{
    //    $field = $this->form->markdown($this->fieldData['tab'].'.'.$this->fieldData['tab'], $this->fieldData['name']);
    //    //$field = $this->rule($field, $this->fieldData['rule']);
    //
    //    return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '');
    //}

    public function map()
    {
        $field = $this->form->map($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function number()
    {
        $field = $this->form->number($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function rate()
    {
        $field = $this->form->rate($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name']);
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function tags()
    {
        $field = $this->form->tags($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name'])->options($this->option());
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function arrays()
    {
        $field = $this->form->array($this->fieldData['tab'].'-'.$this->fieldData['key'], $this->fieldData['name'], function ($form
        ) {
            $form->text('key');
            $form->text('value');
        });
        $field = $this->rule($field, $this->fieldData['rule']);

        return $field->help($this->fieldData['help'], $this->fieldData['help'] ? 'feather icon-help-circle' : '')->value($this->fieldData['value']);
    }

    public function option()
    {
        $array = array();
        foreach (json_decode($this->fieldData['options']) as $key=>$value){
            list($k,$v) = explode(":",$value);
            $array[$k] = $v;
        }
        return $array;
    }
}
