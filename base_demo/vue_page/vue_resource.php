<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>实验楼--vue-route使用</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/vue_page.css" rel="stylesheet">
    <script src="../js/vue.js"></script>
    <script src="../js/vue-router.js"></script>
    <script src="../js/vue-resource.min.js"></script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <img src="https://static.shiyanlou.com/img/logo_03.png" alt="" height="50">
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><router-link to="/home">首页</router-link></li>
                    <li><router-link to="/courses">课程</router-link></li>
                    <li><router-link to="/paths">路径</router-link></li>
                    <li><router-link to="/bootcamp">训练营</router-link></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <router-link to="/login">登录</router-link>
                    </li>
                    <li>
                        <router-link to="/reg">注册</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<transition name="move">
    <div id="container">
        <router-view :course="course"></router-view>
    </div>
</transition>
</div>
<script type="text/javascript">
const Home = { template: '<div><h1>首页</h1></div>' }
const Courses = { template: '<div><h1>课程</h1><ul class="nav nav-tabs"><li><router-link to="/courses/all">全部课程</router-link></li><li><router-link to="/courses/preview">即将上线</router-link></li><li><router-link to="/courses/develop">开发者</router-link></li></ul><div><router-view :course=course></router-view></div></div>',props:['course'] }
const Paths = { template: '<div><h1>路径</h1></div>' }
const Bootcamp = { template: '<div><h1>训练营</h1></div>' }
const Coursesall = {template:'<div><table class="table table-bordered"><thead><tr><th>序号</th><th>课程</th><th>关注</th></tr></thead><tbody><tr v-for="(item,index) in arrayData"><td>{{index+1}}</td><td>{{item.name}}</td><td>{{item.age}}</td></tr></tbody></table><div class="pager" id="pager"><template v-for="item in pageCount+1"><span v-if="item==1" class="btn btn-default" v-on:click="showPage(pageCurrent-1,$event)">上一页</span><span v-if="item>0&&item<=pageCount-1&&item>=showPagesStart&&item<=showPageEnd&&item<=pageCount" class="btn btn-default" v-on:click="showPage(item,$event)">{{item}}</span><span v-if="item==pageCount" class="btn btn-default" v-on:click="showPage(pageCurrent+1,$event)">下一页</span></template></div></div>',
 data(){
   return {
        courses:[],
        //当前页面
        pageCurrent: 1,
        //分页大小，每页有多少条
        pagesize : 5 ,
        //开始显示的分页按钮
        showPagesStart: 1,
        //结束显示的分页按钮
        showPageEnd: 10,
        //分页数据
        arrayData: [],
    }
},
computed:{
    pageCount: function () {
        return (Math.ceil(this.courses.length/this.pagesize))+1;
    }
},
methods:{
    //方法中传入页码
    showPage: function (pageIndex) {
        //判断页码
        if (pageIndex > 0) {
            if (pageIndex > this.pageCount) {
                pageIndex = this.pageCount;
            }
            // 定义初始数据
            var newPageInfo = [];
            this.$http.get('./data.php').then(function(response) { //response传参，可以是任何值
                // this.courses = (new Function('return (' + response.data + ')'))();
                console.log('('+response.data+')')
                console.log(111)
                this.courses='('+response.data+')';
                for (var i = 0; i < this.pagesize; i++) {
                    newPageInfo[newPageInfo.length] = {
                        name: this.courses[i + (pageIndex - 1)*5].name,
                        age:this.courses[i + (pageIndex - 1)*5].age
                    }
                }
                this.pageCurrent = pageIndex;
                this.arrayData = newPageInfo;
            });
        }

    }
},
created: function (){
    this.showPage(1)
 },
}
const Coursespreview = { template: '<div>preview</div>',props:['course']}
const Coursesdevlop = { template: '<div>devlop</div>'}
const Login = { template: '<div><div class="col-md-offset-3 col-md-6"><form><span>用户登录</span><div class="form-group"><input type="email" class="form-control" placeholder="用户名或电子邮件"><i class="fa fa-user"></i></div> <div class="form-group help"><input type="password" class="form-control" placeholder="密　码"><i class="fa fa-lock"></i><a href="#" class="fa fa-question-circle"></a> <div class="form-group"><button class="btn btn-md btn-primary btn-block" type="submit">登录</button></div></form></div></div></div>' }
const Reg = { template: '<div><div class="col-md-offset-3 col-md-6"><form><span>用户注册</span><div class="form-group"><input type="email" class="form-control" placeholder="用户名或电子邮件"><i class="fa fa-user"></i></div> <div class="form-group help"><input type="password" class="form-control" placeholder="密　码"><i class="fa fa-lock"></i><a href="#" class="fa fa-question-circle"></a> <div class="form-group"><button class="btn btn-md btn-primary btn-block" type="submit">注册</button></div></form></div></div></div>' }

const routes = [
    {path: '/home', component: Home},
    {path: '/courses', component: Courses, children:[
        {path:'all', component:Coursesall},
        {path:'preview', component:Coursespreview},
        {path:'develop', component:Coursesdevlop},
    ]},
    {path: '/paths', component: Paths},
    {path: '/bootcamp', component: Bootcamp},
    {path: '/login', component: Login},
    {path: '/reg', component: Reg},
]

var router = new VueRouter({
    routes
})

const app = new Vue({
    router,
    el:'#app',
    data:{
      course:[
            {coursetitle:'新手指南之玩转实验楼',coursecontent:'新手指南之玩转实验楼',coursehit:76471},
            {coursetitle:'Linux 基础入门',coursecontent:'Linux 基础入门',coursehit:93388},
            {coursetitle:'C语言实现大数计算器',coursecontent:'C语言实现大数计算器',coursehit:167},
            {coursetitle:'C++实现智能指针',coursecontent:'C++实现智能指针',coursehit:163},
            {coursetitle:'PHP 封装分页类',coursecontent:'PHP 封装分页类',coursehit:140}
          ]
      },
}).$mount('#app')
</script>
</body>
</html>
