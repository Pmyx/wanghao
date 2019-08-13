<template>
    <div>
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item><a href="/sites">酷站管理</a></el-breadcrumb-item>
            <el-breadcrumb-item>酷站列表</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="hengxian"></div>

        <el-row class="sousuo">
            <el-col :span="8">
                <div class="controls">
                    <router-link to="/site/create">
                        <el-button type="success" size="small" class="create">新增酷站</el-button>
                    </router-link>
                </div>
            </el-col>

            <el-col :span="16" class="name_s">
                <el-form :inline="true" class="search">
                    <el-form-item label="所属分类">
                        <el-select v-model="search.site_node_id" filterable placeholder="请选择" size="medium">
                            <el-option
                                    v-for="item in site_nodes"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item label="酷站名称">
                        <el-input
                                placeholder="请输入内容"
                                v-model="search.keyword"
                                clearable>
                        </el-input>
                    </el-form-item>

                    <el-form-item>
                        <el-button type="warning" size="medium" icon="el-icon-search" @click="handleSerach">搜索
                        </el-button>
                        <el-button @click="resetSearch">重置</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>


        <el-table ref="multipleTable" :data="sites" style="width: 100%">
            <el-table-column label="编号" prop="id"></el-table-column>
            <el-table-column label="酷站名称" prop="name">
                <template slot-scope="scope">
                    {{ scope.row.name }}
                </template>
            </el-table-column>
            <el-table-column label="所属分类" prop="site_node_id">
                <template slot-scope="scope">
                    {{ scope.row.site_node.name }}
                </template>
            </el-table-column>
            <el-table-column label="酷站图片" prop="photo_id">
                <template slot-scope="scope" prop="photo_id">
                    <a :href="scope.row.url" target="_blank"><img :src="scope.row.photo.image" alt="" class="thumb"></a>
                </template>
            </el-table-column>
            <el-table-column label="是否显示" prop="is_show">
                <template slot-scope="scope">
                    <i :class="scope.row.is_show ? 'el-icon-check' : 'el-icon-close'"
                       @click="handleChangeAttr(scope.$index, scope.row)"></i>
                </template>
            </el-table-column>
            <el-table-column label="排序">
                <template slot-scope="scope">
                    <el-input v-model="scope.row.sort" @change="change_sort(scope.$index, scope.row)"></el-input>
                </template>
            </el-table-column>
            <el-table-column label="创建时间" prop="created_at">
                <template slot-scope="scope">
                    {{ scope.row.created_at|edit_date}}
                </template>
            </el-table-column>

            <el-table-column label="操作">
                <template slot-scope="scope">
                    <router-link :to="{ name: 'SiteEdit', params: { id: scope.row.id }}">
                        <el-button size="mini">编辑</el-button>
                    </router-link>
                    <el-button size="mini" type="danger" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>

        <div class="block el-pagination" style="margin-top: 50px;">
            <span class="el-pagination__total" style="margin-left: 20px;">共 {{page.total}} 条数据</span>
            <el-pagination style="margin-left: 1000px; margin-top: -30px;" background layout="prev, pager, next" :total="page.total" :page-size="page.size" @current-change="handleCurrentChange" :current-page.sync="page.currentPage"></el-pagination>
        </div>

    </div>
</template>
<script>
    export default {
        name: 'site',
        data() {
            return {
                site_nodes: [],
                sites: [],
                search:{
                    keyword: '',
                    site_node_id: '',
                },
                page: {
                    total: 0,
                    size: 0,
                    currentPage: 1,
                    num: 1
                },

            }
        },
        created() {
            this.init()
        },
        //去除时间后面的时分
        filters: {
            edit_date: function (val) {
                return val.substring(0, 10)
            }
        },
        methods: {
            init() {
                axios.get(`/admin/site?page=${this.page.num}&
                keyword=${this.search.keyword}&site_node_id=${this.search.site_node_id}`).then((res) => {
                    //console.log(res);
                    this.sites = res.data.sites.data;
                    this.page.total = res.data.sites.total;
                    this.page.size = res.data.sites.current_page;

                })
                /**加载分类*/
                axios.get(`/admin/site_nodes`).then((res) => {
                    //console.log(res);return;
                    this.site_nodes = res.data.site_nodes

                })
            },
            /**删除*/
            handleDelete(index, row) {
                if (confirm('are you sure?')) {
                    let id = row.id
                    //console.log(id);return;
                    axios.delete(`/admin/site/${id}`).then((res) => {
                        this.$notify({
                            title: '成功',
                            message: '删除成功',
                            type: 'success'
                        });
                        this.init();
                    })
                }
            },
            /**改变属性**/
            handleChangeAttr(index, row) {
                axios.patch(`/admin/site/change_attr/${row.id}`, {is_show: row.is_show}).then((res) => {
                    //提示消息
                    this.$notify({
                        title: '成功',
                        message: '编辑成功',
                        type: 'success'
                    });
                    this.init();
                })
            },


            /**改变排序*/
            change_sort(index, row) {
                //if(row.sort)
                //console.log(row.sort);return;
                axios.patch(`/admin/site/change_sort/${row.id}`, {sort: row.sort}).then((res) => {
                    //提示消息
                    this.$notify({
                        title: '成功',
                        message: '排序编辑成功',
                        type: 'success'
                    });
                    this.init();
                })
            },
            /**搜索*/
            handleSerach() {
                this.init();
            },
            /**重置搜索*/
            resetSearch(){
                    this.search.keyword='',
                    this.search.site_node_id='',
                    this.page.num=1
                    this.init();
            },
            /**分页*/
            handleCurrentChange(val) {
                this.page.num = val;
                this.init()
            },
        }
    }
</script>
<style>
    .create {
        margin: 13px 0;
    }

    .thumb {
        width: 80px;
        height: 40px;
    }

    .el-icon-check {
        color: #5EB95E;
        font-weight: bold;
        cursor: pointer;
    }

    .el-icon-close {
        color: red;
        font-weight: bold;
        cursor: pointer;
    }

    .hengxian {
        margin-top: 20px;
        border-top: 1px solid #eeeeee;
    }

    .name_s {
        margin-top: 15px;
    }

    .el-table .cell {
        text-align: center;
    }
</style>