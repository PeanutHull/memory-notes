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
            "sideBar.background": "#3d3b3d",
            "sideBarSectionHeader.background": "#3d3b3d"
        }
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
        }
    ]
     ```