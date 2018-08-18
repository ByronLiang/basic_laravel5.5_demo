# 目录结构

- abstracts 辅助工具
    - _functions.scss 函数
    - _minxins.scss 混合宏
    - _placeholders.scss 占位符
    - _variables.scss 全局变量
- base 模板文件
    - _reset.scss 样式重置
- layout 布局， 存放网站主体（头部、尾部、导航栏、侧边栏...）的样式、栅格系统等
    - _grid.scss     # 网格系统
    - _header.scss   # Header
    - _footer.scss   # Footer
- components 组件，基本上是所有的独立模块
- pages 特定页面样式
- vendors_reset 重置第三方库， 如mint
- vendors.scss 引入第三方库
- app.scss 入口文件


# 注意事项

- [base.css](http://basscss.com/) 在vendors.scss按需引入 


# 参考

- [Sass Guidelines](https://sass-guidelin.es/zh/#sass)
