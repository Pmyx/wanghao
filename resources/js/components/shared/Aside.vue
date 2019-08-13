<template>
    <el-menu
            default-active="/"
            class="el-menu-vertical-demo"
            :router="true"
            background-color="#545c64"
            text-color="#fff"
            active-text-color="#ffd04b">

        <el-menu-item index="/">
            <span slot="title">
                <i class="el-icon-s-home"></i>首&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;页
            </span>
        </el-menu-item>
        <el-submenu index="1">
            <template slot="title">
                <i class="el-icon-shopping-cart-full"></i>
                <span>新闻管理</span>
            </template>
            <el-menu-item-group>
                <el-menu-item index="/notice"><i class="el-icon-s-goods"></i>新闻列表</el-menu-item>
                <el-menu-item index="/notice_nodes"><i class="el-icon-date"></i>新闻分类</el-menu-item>
            </el-menu-item-group>
        </el-submenu>

        <el-submenu index="2">
            <template slot="title">
                <i class="el-icon-shopping-cart-full"></i>
                <span>酷站管理</span>
            </template>
            <el-menu-item-group>
                <el-menu-item index="/site"><i class="el-icon-s-goods"></i>酷站列表</el-menu-item>
                <el-menu-item index="/site_nodes"><i class="el-icon-date"></i>酷站分类</el-menu-item>
            </el-menu-item-group>
        </el-submenu>

        <el-submenu index="3">
            <template slot="title">
                <i class="el-icon-shopping-cart-full"></i>
                <span>广告管理</span>
            </template>
            <el-menu-item-group>
                <el-menu-item index="/advert"><i class="el-icon-s-goods"></i>广告列表</el-menu-item>
                <el-menu-item index="/advert_nodes"><i class="el-icon-date"></i>广告分类</el-menu-item>
            </el-menu-item-group>
        </el-submenu>
    </el-menu>
</template>