### GTK
1. 认识：开源的也是c编写，同时也移植到了macOS和windows上，现在都是GTK+，目前有v3和v4版本，支持c、js、python、go，python资料最多
   - 布局：xml方式，使用GtkBuilder，结构：interface-object...
   - 样式：css
   - glade：RAD（rapid application develop，快速应用开发）工具，能够为gtk+和gnome桌面环境开发界面，就是所见即所得
   - 配置方式
     1. 环境变量
     1. 配置文件：settings.ini
     1. 代码修改
   - 内存管理
     1. ref引用计数
     1. 浮动引用：防止造成内存泄露，就是弄个标记原来的加1，给减1了，为0正好不用管了
   - 到时候写的时候找东西抄，就像抄主题一样
1. 组成
   - GtkWindow
   - GtkGrid
   - GtkTreeView：可以展示列表和层级
   - GtkListStore
1. 原始操作
    ```c
    #include <stdio.h>
    #include <gtk/gtk.h>

    static void print_hello(GtkWidget *widget, gpointer data) {
        g_print("Hello World\n");
    }

    static void activate(GtkApplication *app, gpointer user_data) {
        // 创建窗体
        GtkWidget *window = gtk_application_window_new(app);
        gtk_window_set_title(GTK_WINDOW(window), "HelloWorld");
        gtk_window_set_default_size(GTK_WINDOW(window), 200, 200);

        // 创建按钮
        GtkButtonBox *button_box = gtk_button_box_new(GTK_ORIENTATION_HORIZONTAL);
        gtk_container_add(GTK_CONTAINER(window), button_box);
        GtkButton *button = gtk_button_new_with_label("Hello World");
        gtk_container_add(GTK_CONTAINER(button_box), button);

        // 绑定事件
        g_signal_connect(button, "clicked", G_CALLBACK(print_hello), NULL);
        g_signal_connect_swapped(button, "clicked", G_CALLBACK(gtk_window_close), window);

        gtk_widget_show_all(window);
    }

    int main(int argc, char **argv) {
        // 创建应用
        GtkApplication *app = gtk_application_new("com.bennyhuo.clang", G_APPLICATION_FLAGS_NONE);
        // 添加事件
        g_signal_connect(app, "activate", G_CALLBACK(activate), NULL);
        // 运行
        int status = g_application_run(app, argc, argv);
        // 解引用
        g_object_unref(app);

        return status;
    }
    ```
1. 使用xml
    ```c
    #include <stdio.h>
    #include <gtk/gtk.h>
    #include <stdlib.h>

    int main(int argc, char **argv) {
        GError *error = NULL;

        // 初始化gtk
        gtk_init(&argc, &argv);

        GtkBuilder *builder = gtk_builder_new();
        // 通过xml加载布局
        if (gtk_builder_add_from_file(builder, "builder.ui", &error) == 0){
            g_printerr("Error loading file: %s\n", error->message);
            g_clear_error(&error);
            return 1;
        }

        g_object_unref(builder);

        gtk_main();

        return 0;
    }
    ```
1. 使用glade
    ```c
    #include <stdio.h>
    #include <gtk/gtk.h>
    #include <stdlib.h>

    // 为glade编写的函数
    G_MODULE_EXPORT void print_hello2(GtkWidget *widget, GtkTextBuffer *data) {
        GtkTextIter start;
        GtkTextIter end;
        gtk_text_buffer_get_start_iter(data, &start);
        gtk_text_buffer_get_end_iter(data, &end);
        g_print("Hello2 : %s\n", gtk_text_buffer_get_text(data, &start, &end, FALSE));
    }

    int main(int argc, char **argv) {
        GError *error = NULL;

        gtk_init(&argc, &argv);

        GtkBuilder *builder = gtk_builder_new();
        if (gtk_builder_add_from_file(builder, "builder2.ui", &error) == 0){
            g_printerr("Error loading file: %s\n", error->message);
            g_clear_error(&error);
            return 1;
        }

        gtk_main();

        // 解引用放在后边，要不glade加载不出来
        g_object_unref(builder);

        return 0;
    }
    ```
1. 使用css
    ```
    #include <stdio.h>
    #include <gtk/gtk.h>
    #include <stdlib.h>

    int main(int argc, char **argv) {
        GError *error = NULL;

        gtk_init(&argc, &argv);

        // 加载css
        GtkCssProvider *css_provider = gtk_css_provider_new();

        if(gtk_css_provider_load_from_path(css_provider, "builder3.css", &error) == 0) {
            g_printerr("Error loading css file: %s\n", error->message);
            g_clear_error(&error);
            return 1;
        }

        // 使用xml
        GtkBuilder *builder = gtk_builder_new();
        if (gtk_builder_add_from_file(builder, "builder3.ui", &error) == 0){
            g_printerr("Error loading builder file: %s\n", error->message);
            g_clear_error(&error);
            return 1;
        }

        // 应用css
        GObject *window = gtk_builder_get_object(builder, "window");
        gtk_style_context_add_provider_for_screen(gtk_window_get_screen(GTK_WINDOW(window)),
                                                    (GtkStyleProvider *) css_provider, GTK_STYLE_PROVIDER_PRIORITY_USER);

        gtk_main();

        g_object_unref(builder);

        return 0;
    }
    ```
1. 配置
    ```c
    int main(int argc, char **argv) {
        putenv("GTK_CSD=1");
        g_object_set(gtk_settings_get_default(), "gtk-theme-name", "Desert-1.2", NULL);     // 设置主题
    }
    ```
### 运维
1. 打包发布：将依赖的动态库、静态库、资源文件都放到需要的目录下，然后搭配安装制作工具发布包
### wiki
1. 面向对象设计理念
   - 在c中实现面向对象比较麻烦，定义多个属性父类(属性可以有多个)，再定义唯一一个覆写父类行为的class(行为都相同)
   - 由于结构体的第一个元素位置和结构体的起始位置相同，利用这个可以实现继承
   - gtk的继承关系：GObject->GInitiallyUnowned->GtkWidget->GtkContainer->GtkBin->GtkButtion->GtkToggleButton
1. wiki
   - 问题
     1. 怎么告诉gtk进行ui刷新，ui刷新的成本有多高？
     1. gtk会不停监听事件变化