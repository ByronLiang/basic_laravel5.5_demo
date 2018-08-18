# 目录结构

- components 组件，不包含其他组件，可根据组件类型建立文件夹
    - base 基本组件，不涉及项目业务逻辑判断，可供多个项目复用
    - feature 功能组件，根据业务情况由多个组件组合成,多个页面共用
    - page 页面组件，特定页面需要用到的组件，如样式
- config 全局配置
    - bootstrap.js 全局依赖配置
    - parameter.js 全局参数配置，如男:m,女:f
- directives 指令，用于原生dom操作
- filters 过滤，用于格式化变量输出
- app.js 程序入口


# 注意事项

- editorconfig 插件 http://editorconfig.org/#download
- 为避免组件过于复杂，不方便后期维护，避免往组件传数组且在组件里循环
- 基于js语言特性，应避免过长的变量 如：bad => a.b.c
