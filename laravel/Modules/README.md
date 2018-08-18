# 模块系统

使用 [Laravel-Modules https://github.com/nWidart/laravel-modules](https://github.com/nWidart/laravel-modules) 依赖实现，具体使用看[官方文档](https://nwidart.com/laravel-modules/v3/introduction)

## 快速入门
1. 启用模块 `php artisan module:enable xxx`
2. 发布配置 `php artisan module:publish-config xxx`

### 所有 php artisan module:xxx 命令 
```text
  module:disable              Disable the specified module.
  module:dump                 Dump-autoload the specified module or for all module.
  module:enable               Enable the specified module.
  module:install              Install the specified module by given package name (vendor/name).
  module:list                 Show list of all modules.
  module:make                 Create a new module.
  module:make-command         Generate new Artisan command for the specified module.
  module:make-controller      Generate new restful controller for the specified module.
  module:make-event           Create a new event class for the specified module
  module:make-factory         Create a new model factory for the specified module.
  module:make-job             Create a new job class for the specified module
  module:make-listener        Create a new event listener class for the specified module
  module:make-mail            Create a new email class for the specified module
  module:make-middleware      Create a new middleware class for the specified module.
  module:make-migration       Create a new migration for the specified module.
  module:make-model           Create a new model for the specified module.
  module:make-notification    Create a new notification class for the specified module.
  module:make-policy          Create a new policy class for the specified module.
  module:make-provider        Create a new service provider class for the specified module.
  module:make-request         Create a new form request class for the specified module.
  module:make-resource        Create a new resource class for the specified module.
  module:make-rule            Create a new validation rule for the specified module.
  module:make-seed            Generate new seeder for the specified module.
  module:make-test            Create a new test class for the specified module.
  module:migrate              Migrate the migrations from the specified module or from all modules.
  module:migrate-refresh      Rollback & re-migrate the modules migrations.
  module:migrate-reset        Reset the modules migrations.
  module:migrate-rollback     Rollback the modules migrations.
  module:migrate-status       Status for all module migrations
  module:publish              Publish a module's assets to the application
  module:publish-config       Publish a module's config files to the application
  module:publish-migration    Publish a module's migrations to the application
  module:publish-translation  Publish a module's translations to the application
  module:route-provider       Create a new route service provider for the specified module.
  module:seed                 Run database seeder from the specified module or from all modules.
  module:setup                Setting up modules folders for first use.
  module:unuse                Forget the used module with module:use
  module:update               Update dependencies for the specified module or for all modules.
  module:use                  Use the specified module.

```