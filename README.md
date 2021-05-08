# Dcat Admin Extension

1. 使用composer导入

   ```shell
   composer require cin/dcat-config
   ```

2. 项目目录/config/admin.php里面的database添加数据库配置

   ```php
   'database'=>[
   	'config_table' => 'config'
   ]
   ```

3. 配置缓存

   ```shell
   php artisan config:cache
   ```

4. 开启拓展


