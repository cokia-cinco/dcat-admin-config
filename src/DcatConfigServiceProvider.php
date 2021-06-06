<?php

namespace Dcat\Admin\DcatConfig;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Illuminate\Support\Facades\DB;

class DcatConfigServiceProvider extends ServiceProvider
{
    // 定义菜单
    protected $menu = [
        [
            'title' => 'Config',
            'uri' => 'config',
            'icon' => 'fa-toggle-off', // 图标可以留空
        ],
    ];

	public function init()
	{
		parent::init();
        foreach (DB::table(config('admin.database.config_table'))->get() as $config) {
            config([$config->key => $config->value]);
        }
	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
