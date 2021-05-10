<?php

namespace Dcat\Admin\DcatConfig\Http\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\DcatConfig\DcatConfigServiceProvider;
use Dcat\Admin\DcatConfig\Tools\Builder;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Tooltip;
use Illuminate\Routing\Controller;
use Dcat\Admin\Layout\Row;
use Illuminate\Support\Facades\DB;

class DcatConfigController extends Controller
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $breadcrumb;

    /**
     * @return array|string|null
     */
    protected function title()
    {
        return $this->title ?: DcatConfigServiceProvider::trans('dcat-config.title');
    }

    /**
     * @return array
     */
    protected function breadcrumb(): array
    {
        return $this->breadcrumb ?: [
            'text' => DcatConfigServiceProvider::trans('dcat-config.title'),
            'url' => admin_url('config'),
            //			        'icon'  => 'fa-toggle-off', // 图标可以留空
        ];
    }

    /**
     * @return array|string|null
     */
    protected function description()
    {
        return $this->description ?: DcatConfigServiceProvider::trans('dcat-config.description');
    }

    /**
     * @param \Dcat\Admin\Layout\Content $content
     * @return \Dcat\Admin\Layout\Content
     */
    public function index(Content $content): Content
    {

        Tooltip::make('.dd-toggle')->top();

        return $content->title($this->title())->description($this->description())->breadcrumb($this->breadcrumb())->body(function (
            Row $row
        ) {
            $row->column(8, $this->form());
            $row->column(4, $this->grid());
        });
    }

    public function edit($id, Content $content)
    {
        $form = (new Builder(Form::make()))->edit($id)->getForm();

        return $content->title($this->title())->description($this->description())->breadcrumb($this->breadcrumb())->body(function (
            Row $row
        ) use ($form) {
            $row->column(8, $form);
            $row->column(4, $this->grid());
        });
    }

    public function putEdit($id)
    {

        $form = Form::make();

        return (new Builder($form))->putEdit($id)->getForm()->response()->redirect(admin_url('config'))->success(trans('admin.save_succeeded'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {

        $form = Form::make();

        return (new Builder($form))->destroy($id)->getForm()->response()->refresh()->success(trans('admin.delete_succeeded'));
    }

    /**
     * @return \Dcat\Admin\Http\JsonResponse
     */
    public function update(): \Dcat\Admin\Http\JsonResponse
    {
        $form = Form::make();

        return (new Builder($form))->update()->getForm()->response()->refresh()->success(trans('admin.save_succeeded'));
    }

    /**
     * @param Content $content
     *
     * @return Content
     */
    public function add(Content $content): Content
    {
        return $content->title($this->title())->description($this->description())->breadcrumb($this->breadcrumb())->body(function (
            Row $row
        ) {
            $row->column(8, $this->create());
            $row->column(4, $this->grid());
        });
        //->body($this->create());
    }

    /**
     * @return \Dcat\Admin\Http\JsonResponse
     */
    public function addo(): \Dcat\Admin\Http\JsonResponse
    {
        return (new Builder(Form::make()))->store()->getForm()->response()->redirect(admin_url('config'))->success(trans('admin.save_succeeded'));
    }

    /**
     * @return \Dcat\Admin\Form|null
     */
    protected function form(): ?Form
    {
        return (new Builder(Form::make()))->form()->getForm();
    }

    /**
     * @return \Dcat\Admin\Form|null
     */
    protected function create(): ?Form
    {
        return (new Builder(Form::make()))->create()->getForm();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function grid()
    {

        $tab = collect(DcatConfigServiceProvider::setting('tab'))->pluck('value', 'key')->toArray();

        $array = $this->getModel()->get();
        $data = array();
        foreach ($this->getModel()->get() as $index => $item) {
            foreach ($tab as $k=>$v){
                if ($k==$item->tab){
                    $data[$v][] = array("id"=>$item->id,"key"=>$item->key,"name"=>$item->name);
                }
            }
        }
        return view('cin.dcat-config::tree', ['data' => $data]);
    }

    private function getModel(){
        return DB::table(config('admin.database.config_table'));
    }
}
