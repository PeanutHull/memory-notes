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