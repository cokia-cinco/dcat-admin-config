# Dcat Admin Config

致敬原作者([github.com/Ghost-die/dcat-config](https://github.com/Ghost-die/dcat-config)),本插件于原作者插件进行修改

1. 导入插件

   ```
   composer require cin/dcat-config
   ```

2. 项目目录/config/admin.php->database配置数据库名

   ```
   'database'=>[
   	'config_table' => 'config',
   ]
   ```

3. 更新并开启拓展

4. 于拓展的设置中添加基础配置项(存储于admin_seeting表中)

5. 支持的类型有

   ```
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
   'number' => '数字',
   'rate' => '费率',
   'array'=>'数组'
   ```

   