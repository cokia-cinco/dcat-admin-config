<?php

namespace Ghost\DcatConfig\Tools;

use Dcat\Admin\Actions\Action;
use Dcat\Admin\Form;
use Dcat\Admin\Widgets\Form as WidgetsForm;
use Ghost\DcatConfig\DcatConfigServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Builder
{
    /**
     * @var \Dcat\Admin\Form
     */
    protected $form;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $model;

    protected $tab;

    protected $data;

    protected $option = [
        'text' => '文本',
        'select' => '下拉选框单选',
        'multipleSelect' => '下拉选框多选',
        'listbox' => '多选盒',
        'textarea' => '长文本',
        'radio' => '单选',
        'checkbox' => '多选',
        'email' => '邮箱',
        'password' => '密码',
        'url' => '链接',
        'ip' => 'IP',
        'mobile' => '手机',
        'color' => '颜色选择器',
        'time' => '时间',
        'date' => '日期',
        'datetime' => '时间日期',
        'file' => '文件上传',
        'image' => '图片上传',
        'multipleImage' => '多图上传',
        'multipleFile' => '多文件上传',
        'editor' => '富文本编辑器',
        //'markdown' => 'Markdown',
        'number' => '数字',
        'rate' => '费率',
        'arrays' => "数组",
    ];

    protected $input;

    public function __construct($form)
    {
        $this->form = $form;
        $this->form->disableDeleteButton();
        $this->form->disableViewButton();
        $this->form->disableCreatingCheck();
        $this->form->disableListButton();
        $this->form->disableEditingCheck();
        $this->form->disableViewCheck();
        $this->tab = $this->getTab();
        $this->model = $this->getModel();
    }

    /**
     * @return $this
     */
    public function form()
    {
        $configData = $this->model->get()->groupBy("tab")->toArray();
        $tabData = $this->tab->toArray();
        $this->form->title(DcatConfigServiceProvider::trans('dcat-config.builder.config'));
        $this->form->action(admin_url('config.do'));

        collect(array_merge($tabData,$configData))->each(function ($value, $item) use ($tabData) {
            $this->form->tab($tabData[$item], function () use ($value, $item) {
                if (is_array($value)) {
                    collect($value)->each(function ($item) {
                        $item = collect($item)->toArray();
                        Field::make($item,$this->form)->{$item['element']}();
                    });
                }
            });
        });

        $this->form->tools([new Create()]);

        return $this;
    }

    /**
     * @param $str
     *
     * @return false|string[]
     */
    protected function textToArray($str)
    {
        return explode("\n", str_replace("\r\n", "\n", $str));
    }

    /**
     * @param $id
     * @return $this
     */
    public function putEdit($id)
    {
        $request = request()->all();
        $array = array(
            'tab'=>$request['tab'],
            'name'=>$request['name'],
            'element'=>$request['element'],
            'rule'=>$request['rule'],
            'help'=>$request['help'],
            'updated_at'=>time(),
            'options'=>collect($this->textToArray($request['options']))->each(function ($item){
                $item = explode(":",$item);
            })->toJson(),
        );
        $this->getModel()->where("id",$request['id'])->update($array);
        return $this;
    }

    /**
     * @return $this
     */
    public function update(): Builder
    {
        $request = \request()->except('_token');
        foreach ($request as $key => $value) {
            $tabKey = explode('-',$key);
            if (count($tabKey)>1){
                $this->getModel()->where("tab",$tabKey[0])->where("key",$tabKey[1])->update(["value"=>$value]);
            }
        }
        return $this;
    }

    /**
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        $attributeData = request()->get('attribute');
        $attribute = collect($attributeData)->map(function ($item,$index) {
            if (!$item['_remove_']){
                $attr = array();
                if (false === strpos($item['options'], ':')) {
                    $item['options'] = json_encode(array());
                } else {
                    $item['options'] = collect($this->textToArray($item['options']))->each(function ($item){
                        $item = explode(":",$item);
                    })->toJson();
                }
                $item['created_at'] = date("Y-m-d H:i:s",time());
                $item['updated_at'] = date("Y-m-d H:i:s",time());
                $item = array_merge($item,array("tab"=>request()->get('tab')));
                unset($item['_remove_']);
                return $item;
            }
        })->filter(function ($item){
            return !is_null($item);
        })->all();
        if(!$this->model->insert($attribute)){

        }
        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        $tab = collect($this->config('tab'))->pluck('value', 'key');
        $this->model = $this->model->where('key', $id)->first();
        if (null === $this->model) {
            return $this;
        }
        $this->form->hidden('_method')->value('put');
        $this->form->hidden('id')->required()->value($this->model->id);
        $this->form->radio('tab', DcatConfigServiceProvider::trans('dcat-config.builder.groups'))->options($tab)->default($this->model->tab);
        $this->form->text('self_key', DcatConfigServiceProvider::trans('dcat-config.builder.key'))->required()->value($this->model->key);
        $this->form->text('name', DcatConfigServiceProvider::trans('dcat-config.builder.name'))->required()->value($this->model->name);
        $this->form->radio('element', DcatConfigServiceProvider::trans('dcat-config.builder.element'))->required()->when([
            'select',
            'multipleSelect',
            'listbox',
            'radio',
            'checkbox',
        ], function ($form) {
            $form->textarea('options', DcatConfigServiceProvider::trans('dcat-config.builder.option'))->value(function (
            ) {
                $text = '';
                foreach (json_decode($this->model->options) as  $v) {
                    $text .= $v."\r\n";
                }
                return $text;
            })->placeholder("例如:\r\nkey1:value1\r\nkey2:value2");
        })->options($this->option)->value($this->model->element)->default('text');
        $this->form->textarea('rule', DcatConfigServiceProvider::trans('dcat-config.builder.rule'))->value(function (
        ) {
            $d = $this->model->rule;
            $text = '';
            foreach ((array) $d as $k => $v) {
                $text .= $v."\r\n";
            }
            return $text;
        });
        $this->form->text('help', DcatConfigServiceProvider::trans('dcat-config.builder.help'))->value($this->model->help);
        return $this;
    }

    protected function order()
    {
        $res = collect($this->model)->last();

        return $res ? $res['order'] : 0;
    }

    /**
     * @return $this
     */
    public function create()
    {
        $tab = collect($this->config('tab'))->pluck('value', 'key');
        $this->form->action(admin_url('config/addo'));
        $this->form->radio('tab', DcatConfigServiceProvider::trans('dcat-config.builder.groups'))->options($tab)->default($tab->keys()->first());
        $this->form->array('attribute', DcatConfigServiceProvider::trans('dcat-config.builder.attribute'), function (WidgetsForm $form) {
            $form->text('key', DcatConfigServiceProvider::trans('dcat-config.builder.key'))->required()->help('请输入字母/数字/点/下划线');
            $form->text('name', DcatConfigServiceProvider::trans('dcat-config.builder.name'))->required();
            $form->radio('element', DcatConfigServiceProvider::trans('dcat-config.builder.element'))->required()->when([
                'select',
                'multipleSelect',
                'listbox',
                'radio',
                'checkbox',
            ], function (WidgetsForm $form) {
                $form->textarea('options', DcatConfigServiceProvider::trans('dcat-config.builder.option'))->placeholder("例如:\r\nkey1:value1\r\nkey2:value2");
            })->options($this->option)->default('text');
            $form->textarea('rule', DcatConfigServiceProvider::trans('dcat-config.builder.rule'))->placeholder("例如:\r\nrequired\r\nmax:1\r\nmin:1\r\n");
            $form->text('help', DcatConfigServiceProvider::trans('dcat-config.builder.help'));
        });

        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function destroy($id)
    {
        $this->model->where("key",$id)->delete();
        return $this;
    }

    /**
     * @return \Dcat\Admin\Form
     */
    public function getForm(): Form
    {
        return $this->form;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    protected function config($key, $default = null)
    {
        return DcatConfigServiceProvider::setting($key, $default);
    }

    private function getModel(){
        return DB::table(config('admin.database.config_table'));
    }

    private function getTab(){
        return collect($this->config('tab'))->pluck('value', 'key');
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
//        dd(collect(admin_setting_array("ghost::admin_config")));
        return collect(admin_setting_array("ghost::admin_config"));
    }

    /**
     * @return \Dcat\Admin\Support\Setting|mixed
     */
    public function save()
    {
        dd($this->model);
        return admin_setting(["ghost::admin_config" => $this->model]);
    }
}
