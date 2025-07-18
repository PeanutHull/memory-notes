### cursor
1. cursor主题设置
   - 认识
     1. 主题样式
        - 样式组成
          1. TextMate 语法高亮
          1. Semantic Highlighting  语义化高亮
        - 样式叠加顺序：语义化高亮 (Semantic) > 扩展注入样式 > TextMate 规则 > 主题默认
   - settings.json中添加以下配置：
    ```json
    {
        "go.toolsManagement.autoUpdate": true,
        "editor.fontSize": 13,
        "editor.lineHeight": 21.5,
        "editor.tokenColorCustomizations": {
            "textMateRules": [
                {
                    "scope": [
                        "string.quoted.double.go",
                        "string.quoted.single.go",
                        "source.go",
                        "source.php",
                        "string.quoted.single.php",
                    ],
                    "settings": {
                        "foreground": "#ABB2BF"
                    }
                },
            ],
        },
        "editor.semanticTokenColorCustomizations": {
            "rules": {
                "parameter": {
                    "foreground": "#D19A66",
                },
                "namespace": {
                    "foreground": "#ABB2BF",
                    "fontStyle": ""
                },
                "string": {
                    "foreground": "#ABB2BF"
                },
                "comment": {
                    "fontStyle": ""
                },
                "variable": {
                    "foreground": "#98C379"
                },
                "variable.readonly": {
                    "foreground": "#D19A66"
                },
                "variable.defaultLibrary": {
                    "foreground": "#E06C75"
                },
            }
        },
        "gopls": {
            "ui.semanticTokens": true
        },
        "editor.fontFamily": "JetBrains Mono, Menlo, Monaco, 'Courier New', monospace",
        "workbench.colorTheme": "One Dark Pro",
        "workbench.iconTheme": "material-icon-theme",
        "material-icon-theme.activeIconPack": "vue",
        "workbench.colorCustomizations": {
            "sideBar.background": "#3d3d3b",
            "sideBarSectionHeader.background": "#3d3b3d",
            // 搜索匹配项的背景色
            "editor.findMatchBackground": "#FFFF00",
            "editor.findMatchHighlightBackground": "#ffff00ec",
            // 当前搜索匹配项的背景色
            "editor.findMatchBorder": "#FF0000",
        },
        "diffEditor.hideUnchangedRegions.enabled": true,
        "php.validate.executablePath": "/opt/homebrew/etc/php/8.2/",
        "php.executablePath": "/opt/homebrew/etc/php/8.2/",
    }
     ```
   - keybindings.json中添加以下配置：
     ```json
    // 将键绑定放在此文件中以覆盖默认值auto[]
    [
        {
            "key": "ctrl+u",
            "command": "editor.action.transformToLowercase"
        },
        {
            "key": "shift+cmd+u",
            "command": "-workbench.action.output.toggleOutput",
            "when": "workbench.panel.output.active"
        },
        {
            "key": "shift+cmd+u",
            "command": "editor.action.transformToCamelcase"
        },
        {
            "key": "ctrl+cmd+v",
            "command": "markdown.showPreview",
            "when": "!notebookEditorFocused && editorLangId == 'markdown'"
        },
        {
            "key": "shift+cmd+v",
            "command": "-markdown.showPreview",
            "when": "!notebookEditorFocused && editorLangId == 'markdown'"
        },
        {
            "key": "cmd+i",
            "command": "composerMode.agent"
        },
        {
            "key": "alt+cmd+numpad_multiply",
            "command": "editor.action.inspectTMScopes"
        },
        {
            "key": "cmd+e",
            "command": "-composer.showBackgroundAgentHistory",
            "when": "backgroundComposerEnabled || showBackgroundAgentHistoryAction"
        },
        {
            "key": "alt+up",
            "command": "-editor.action.smartSelect.grow",
            "when": "editorTextFocus"
        },
        {
            "key": "cmd+e",
            "command": "editor.action.smartSelect.grow"
        },
        {
            "key": "shift+cmd+d",
            "command": "-workbench.view.debug",
            "when": "viewContainer.workbench.view.debug.enabled"
        },
        {
            "key": "shift+cmd+d",
            "command": "editor.action.deleteLines",
            "when": "editorTextFocus && !editorReadonly"
        },
        {
            "key": "cmd+backspace",
            "command": "-editor.action.deleteLines",
            "when": "editorTextFocus && !editorReadonly"
        },
        {
            "key": "ctrl+d",                                                        // 下边是调试用的快捷键，贼好用
            "command": "-deleteRight",
            "when": "textInputFocus"
        },
        {
            "key": "ctrl+r",
            "command": "-workbench.action.tasks.reRunTask",
            "when": "taskCommandsRegistered && !terminalFocus"
        },
        {
            "key": "ctrl+r",
            "command": "-go.test.previous",
            "when": "editorLangId == 'go'"
        },
        {
            "key": "ctrl+r",
            "command": "-workbench.action.quickOpenNavigateNextInRecentFilesPicker",
            "when": "inQuickOpen && inRecentFilesPicker"
        },
        {
            "key": "ctrl+r",
            "command": "-workbench.action.openRecent"
        },
        {
            "key": "ctrl+d",
            "command": "workbench.action.debug.start",
            "when": "debuggersAvailable && debugState == 'inactive'"
        },
        {
            "key": "f5",
            "command": "-workbench.action.debug.start",
            "when": "debuggersAvailable && debugState == 'inactive'"
        },
        {
            "key": "ctrl+r",
            "command": "workbench.action.debug.run",
            "when": "debuggersAvailable && debugState != 'initializing'"
        },
        {
            "key": "ctrl+f5",
            "command": "-workbench.action.debug.run",
            "when": "debuggersAvailable && debugState != 'initializing'"
        },
        {
            "key": "f6",
            "command": "-workbench.action.debug.pause",
            "when": "debugState == 'running'"
        },
        {
            "key": "ctrl+c",
            "command": "workbench.action.debug.stepOver",
            "when": "debugState == 'stopped'"
        },
        {
            "key": "f10",
            "command": "-workbench.action.debug.stepOver",
            "when": "debugState == 'stopped'"
        },
        {
            "key": "ctrl+x",
            "command": "workbench.action.debug.stepInto",
            "when": "debugState != 'inactive'"
        },
        {
            "key": "f11",
            "command": "-workbench.action.debug.stepInto",
            "when": "debugState != 'inactive'"
        },
        {
            "key": "ctrl+s",
            "command": "workbench.action.debug.stepOut",
            "when": "debugState == 'stopped'"
        },
        {
            "key": "shift+f11",
            "command": "-workbench.action.debug.stepOut",
            "when": "debugState == 'stopped'"
        },
        {
            "key": "shift+f9",
            "command": "-editor.debug.action.toggleInlineBreakpoint",
            "when": "editorTextFocus"
        },
        {
            "key": "ctrl+a",
            "command": "editor.debug.action.toggleBreakpoint",
            "when": "debuggersAvailable && disassemblyViewFocus || debuggersAvailable && editorTextFocus"
        },
        {
            "key": "f9",
            "command": "-editor.debug.action.toggleBreakpoint",
            "when": "debuggersAvailable && disassemblyViewFocus || debuggersAvailable && editorTextFocus"
        },
        {
            "key": "ctrl+b",
            "command": "workbench.action.debug.stop",
            "when": "inDebugMode && !focusedSessionIsAttach"
        },
        {
            "key": "shift+f5",
            "command": "-workbench.action.debug.stop",
            "when": "inDebugMode && !focusedSessionIsAttach"
        },
        {
            "key": "ctrl+v",
            "command": "workbench.action.debug.continue",
            "when": "debugState == 'stopped'"
        },
        {
            "key": "f5",
            "command": "-workbench.action.debug.continue",
            "when": "debugState == 'stopped'"
        },
        {
            "key": "ctrl+z",
            "command": "workbench.action.debug.restart",
            "when": "inDebugMode"
        },
        {
            "key": "shift+cmd+f5",
            "command": "-workbench.action.debug.restart",
            "when": "inDebugMode"
        },
        {
            "key": "ctrl+q",
            "command": "editor.debug.action.editBreakpoint"
        },
        {
            "key": "ctrl+e",
            "command": "editor.debug.action.goToPreviousBreakpoint"
        },
        {
            "key": "cmd+d",
            "command": "editor.action.copyLinesDownAction",
            "when": "editorTextFocus && !editorReadonly"
        },
        {
            "key": "shift+alt+down",
            "command": "-editor.action.copyLinesDownAction",
            "when": "editorTextFocus && !editorReadonly"
        },
        {
            "key": "shift+alt+down",
            "command": "editor.action.moveLinesDownAction",
            "when": "editorTextFocus && !editorReadonly"
        },
        {
            "key": "alt+down",
            "command": "-editor.action.moveLinesDownAction",
            "when": "editorTextFocus && !editorReadonly"
        },
        {
            "key": "shift+alt+up",
            "command": "editor.action.moveLinesUpAction",
            "when": "editorTextFocus && !editorReadonly"
        },
        {
            "key": "alt+up",
            "command": "-editor.action.moveLinesUpAction",
            "when": "editorTextFocus && !editorReadonly"
        }
    ]
     ```
1. cursor编程设置
   - 认识：把ai变成可信的工程伙伴
     1. AI是工具，不是魔法：给足够上下文、清晰约束、微粒度任务，就能成为可靠的协作伙伴
   - 知识库模板：为ai提供上下文，是AI的《员工手册》
     1. 举例
        ```json
        docs/
        └─ ai-template/
           ├─ 01_tech_stack.md          # 语言 / 框架 / 版本
           ├─ 02_architecture.md        # 架构分层 / 目录结构
           ├─ 03_coding_rules.md        # 命名、异常、日志、SQL 安全
           ├─ 04_business_glossary.md   # 领域术语
           └─ 99_prompt_snippets.md     # 常用提示词片段
        ```
   - 规则体系：设置通用、场景rules
     1. 举例
        ```json
        1. 遵循 docs/ai-template/03_coding_rules.md。
        2. 信息不足时先提问，不得臆测。
        3. SQL安全
         - [强制] 仅用参数化查询
         - [强制] 密码字段存 bcrypt hash
        ```
   - 多模型协作：让不同模型独立生成，用第三款模型做diff评论，合并交集，由人类确认冲突
   - 任务清单驱动：使用Markdown task‑list，AI可自动勾选已完成项
1. cursor的功能
   - Memories：记住对话信息并在未来交流过程中引用，按项目和个人级别存储，可在设置中管理。
     1. 如强制记住php的版本号
1. wiki
   - 其他编辑器
     1. Augment：插件形式，上下文很强，复杂项目很给力，比cursor好用
     1. claude code
     1. Roo Code：完全免费，对token的使用非常透明会有显示
     1. Windsurf
### vs code
1. 单词的分隔符设置：`editor.wordSeparators`
   - 认识：设置哪些字符被视为单词分隔符，影响光标移动、选择等操作