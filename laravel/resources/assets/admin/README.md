# 目录结构

- scss 样式表
- components 组件，不包含其他组件，可根据组件类型建立文件夹
    - base 基本组件，类似原生组件，不涉及项目业务逻辑判断，可以直接与其他项目共用
    - widget 部件组件，由多个组件组合成
    - feature 功能组件，根据业务情况由多个组件组合成
    - layout 布局组件
    - page 页面组件，特定页面需要用到的组件，如样式
    - form 表单组件，表单填写
    - dialog 对话框内容
- config 全局配置
    - bootstrap.js 全局依赖配置
    - router.js 路由配置
    - parameter.js 全局参数配置，如男:m,女:f
- directives 指令，用于原生dom操作
- filters 过滤，用于格式化变量输出
- pages 路由展示的页面
    - index.vue 无样式路由入口
- store 全局状态控制(需要vuex)
- app.js 程序入口
- app.vue 路由入口


# 注意事项

- 为避免组件过于复杂，不方便后期维护，避免往组件传数组且在组件里循环
- 基于js语言特性，应避免选择节点过长的变量
