import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '../components/Home'
import NoticeNode from '../components/admin/notice_nodes/Home'   //新闻分类
import Notice from '../components/admin/notice/Home'   //酷站列表
import NoticeCreate from '../components/admin/notice/Create'   //酷站列表
import NoticeEdit from '../components/admin/notice/Edit'   //酷站列表

import SiteNode from '../components/admin/site_nodes/Home'   //酷站分类
import Site from '../components/admin/site/Home'   //酷站列表
import SiteCreate from '../components/admin/site/Create'   //酷站列表
import SiteEdit from '../components/admin/site/Edit'   //酷站列表

import Advert from '../components/admin/advert/Home'   //广告列表
import AdvertCreate from '../components/admin/advert/Create'   //新增广告列表
import AdvertEdit from '../components/admin/advert/Edit'   //编辑广告列表
import AdvertNode from '../components/admin/advert_nodes/Home'   //广告分类
Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    //新闻分类
    {
        path: '/notice_nodes',
        name: 'notice_nodes',
        component:NoticeNode,
    },
    //新闻列表路由
    {
        path: '/notice',
        name: 'notice',
        component:Notice,
    },
    //新增新闻列表
    {
        path: '/notice/create',
        name: 'NoticeCreate',
        component:NoticeCreate,
    },
    //编辑新闻列表
    {
        path: '/notice/Edit/:id',
        name: 'NoticeEdit',
        component:NoticeEdit,
    },
    //酷站列表路由
    {
        path: '/site',
        name: 'site',
        component:Site,
    },
    //新增酷站列表
    {
        path: '/site/create',
        name: 'SiteCreate',
        component:SiteCreate,
    },
    //编辑酷站列表路由
    {
        path: '/site/Edit/:id',
        name: 'SiteEdit',
        component:SiteEdit,
    },

    //酷站分类路由
    {
        path: '/site_nodes',
        name: 'site_nodes',
        component:SiteNode,
    },
    //广告列表
    {
        path: '/advert',
        name: 'advert',
        component:Advert,
    },
    //新增广告路由
    {
        path: '/advert/create',
        name: 'AdvertCreate',
        component:AdvertCreate,
    },
    //编辑广告列表路由
    {
        path: '/advert/Edit/:id',
        name: 'AdvertEdit',
        component:AdvertEdit,
    },

    //广告分类
    {
        path: '/advert_nodes',
        name: 'advert_nodes',
        component:AdvertNode,
    },
];

const router = new VueRouter({
    routes
});

export default router;