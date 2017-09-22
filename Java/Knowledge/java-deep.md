### JVM
1. 原理
1. 重难点
   - 编译、加载、执行原理过程
   - 内存管理
   - GC：Garbage Collection，垃圾回收
1. GC
   - 理解：哪些对象要被回收，什么时候回收，如何回收
   - JVM运行时主要的内存组成
     1. 程序计数器
### 函数式编程
1. 分类
   - Guava
### 设计模式
1. 建造者模式
   - 理解：就是用一个建造类建造一个类让对象更方便建造
   - 特点
     1. 良好封装性，使用者可以不用了解内部组成就创建可使用的对象
     1. 建造者独立，被建造类容易扩展
   - 实例：建造几个王者荣耀英雄
     1. 被建造类
        ```java
        public class HeroConfig{
            HeroBuilder mbuilder = null;
            // 英雄的三个技能
            private String firstSkill;
            private String secondSkill;
            private String thirdSkill;
            private String TPeffect = "无回城特效";

            public HeroConfig(HeroBuilder builder) {
                mbuilder = builder;
                init();
            }
            private void init() {
                if(mbuilder.firstSkill != null) {
                    firstSkill = mbuilder.firstSkill;
                }
                if(mbuilder.secondSkill != null) {
                    secondSkill = mbuilder.secondSkill;
                }
                if(mbuilder.thirdSkill != null) {
                    thirdSkill = mbuilder.thirdSkill;
                }
                if(mbuilder.TPeffect != null) {
                    TPeffect = mbuilder.TPeffect;
                }
            }
            @Override
            public String toString() {
                return "技能1-->" + firstSkill + " 技能2-->" + secondSkill + " 技能2-->" + thirdSkill + " 回城特效-->" + TPeffect;
            }
        }
        ```
     1. 建造者(即建造执行者)
        ```java
        public static class HeroBuilder{
            // 英雄的三个技能
            private String firstSkill;
            private String secondSkill;
            private String thirdSkill;
            private String TPeffect; // 回城效果

            // 英雄的三个技能是必选的，回城的特效是可选的，所以构造方法只设置三个技能
            public HeroBuilder(String firstSkill, String secondSkill, String thirdSkill) {
                this.firstSkill = firstSkill;
                this.secondSkill = secondSkill;
                this.thirdSkill = thirdSkill;
            }

            public HeroConfig create() {
                HeroConfig mHeroConfig = new HeroConfig(this);
                return mHeroConfig;
            }

            public HeroBuilder builderTPeffect(String effect) {
                this.TPeffect = effect;
                return this; // 实现链式调用
            }
        }
        ```
     1. 使用，来建造类
        ```java
        HeroConfig.HeroBuilder("","","").BuilXX("").create();
        HeroConfig 韩信 = new HeroConfig.HeroBuilder("无情冲锋","背水一战","国士无双").BuilTPeffect("金光闪闪").create();
        ```