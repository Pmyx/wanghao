<template>
    <div>
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>广告管理</el-breadcrumb-item>
            <el-breadcrumb-item>广告分类</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="hengxian"></div>

        <div>
        <el-button type="success" round size="small" class="create" @click="showModal()">
            <i class="el-icon-plus"></i>新增
        </el-button>
        <el-button type="danger" round size="small" @click="del_all"><i class="el-icon-delete"></i>删除</el-button>
    </div>

        <el-table ref="multipleTable" :data="advert_nodes" style="width: 100%" @selection-change="handleSelectionChange">
            <el-table-column type="selection" v-model="multipleSelection"></el-table-column>
            <el-table-column label="编号" prop="id"></el-table-column>
            <el-table-column label="名称" prop="name">
                <template slot-scope="scope">
                    {{ scope.row.name }}
                </template>
            </el-table-column>
            <el-table-column label="排序">
                <template slot-scope="scope">
                    <el-input v-model="scope.row.sort" v-on:change="change_sort(scope.$index, scope.row)"></el-input>
                </template>
            </el-table-column>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <el-button size="mini" @click="showModal(scope.$index, scope.row) ">编辑</el-button>
                    <el-button size="mini" type="danger" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>


        <!--        新增表单-->
        <el-dialog :title="is_type.name" :visible.sync="dialogFormVisible">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm">
                <el-form-item label="分类名称" prop="name">
                    <el-input v-model="ruleForm.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="排序" prop="sort">
                    <el-input-number v-model="ruleForm.sort" @change="handleChange" :min="1" :max="99" label="描述文字">
                    </el-input-number>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="submitForm('ruleForm')">确 定</el-button>
                <el-button @click="resetForm('ruleForm')">重置</el-button>
            </div>
        </el-dialog>

    </div>
</template>
<script>
    export default {
        data() {
            return {
                advert_nodes: [],     //返回的数据
                //全选框组
                multipleSelection: [],
                //表单元素
                dialogFormVisible: false,
                ruleForm: {
                    name: '',
                    sort: '99'
                },
                is_type: {},//类型
                //表单验证规则
                rules: {
                    name: [
                        {required: true, message: '请输入活动名称', trigger: 'blur'},
                        {min: 3, max: 20, message: '长度在 3 到 20 个字符', trigger: 'blur'}
                    ],
                },
            }
        },
        created() {
            this.init()
        },
        methods: {
            //读接口找出数据
            init() {
                axios.get(`/admin/advert_nodes`).then(res => {
                    //console.log(res)
                    this.advert_nodes = res.data.advert_nodes
                })
            },
            //全选框
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            //编辑的方法
            showModal(index, row) {
                this.dialogFormVisible = true
                //判断index是否为定义。如果未定义则执行新增，否则执行编辑
                if (index == undefined) {
                    this.ruleForm = {
                        name: '',      //清空表单值
                        sort: '99'
                    };
                    this.is_type = {
                        value: 1,
                        name: "新增分类",
                    };
                    //console.log(this.is_type)
                } else {
                    this.ruleForm.name = row.name;
                    this.ruleForm.sort = row.sort;
                    this.ruleForm.id = row.id;
                    this.is_type = {
                        value: 0,
                        name: "编辑分类",
                    };
                    //console.log(this.is_type)
                }


            },
            //删除的方法
            handleDelete(index, row) {
                if (confirm('are you sure?')) {
                    let id = row.id
                    //console.log(id);return;
                    axios.delete(`/admin/advert_nodes/${id}`).then((res) => {
                        this.$notify({
                            title: '成功',
                            message: '删除成功',
                            type: 'success'
                        });
                        this.init();
                    })
                }
            },
            //计数器
            handleChange(value) {
                //console.log(value);
            },
            //表单验证
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        if (this.is_type.value == 1) {
                            //console.log(this.ruleForm);return ;
                            axios.post(`/admin/advert_nodes`, this.ruleForm).then((res) => {
                                //提示消息
                                this.$notify({
                                    title: '成功',
                                    message: '新增成功',
                                    type: 'success'
                                });
                                this.init();
                                this.dialogFormVisible = false;   //关闭模态框
                            })
                        } else {
                            //console.log(this.ruleForm);return ;
                            axios.put(`/admin/advert_nodes/${this.ruleForm.id}`, this.ruleForm).then((res) => {
                                //提示消息
                                this.$notify({
                                    title: '成功',
                                    message: '编辑成功',
                                    type: 'success'
                                });
                                this.init();
                                this.dialogFormVisible = false;   //关闭模态框
                            })
                        }

                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            /**重置表单*/
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
            /**改变排序*/
            change_sort(index, row) {
                //if(row.sort)
                //console.log(row.sort);return;
                axios.patch(`/admin/advert_nodes/change_sort/${row.id}`, {sort: row.sort}).then((res) => {
                    //提示消息
                    this.$notify({
                        title: '成功',
                        message: '排序编辑成功',
                        type: 'success'
                    });
                    this.init();
                })
            },
            /**多选删除*/
            del_all() {
                const length = this.multipleSelection.length;
                if(!length){
                    alert('至少选中一项数据');
                    return false;
                }
                if (confirm('确认删除所选吗？')) {
                    //console.log(this.multipleSelection);return;
                    let checked_id = this.multipleSelection.map((item)=>{
                        return item.id;
                    })
                    axios.post(`/admin/advert_nodes/del_all`,{checked_id:checked_id}).then((res) => {
                        this.$notify({
                            title: '成功',
                            message: '删除成功',
                            type: 'success'
                        });
                        this.init();
                    })
                }


            }
        }
    }
</script>


<style>
    .hengxian {
        margin-top: 20px;
        border-top: 1px solid #eeeeee;
    }

    .create {
        margin: 13px 0;
    }

    .el-table .cell {
        text-align: center;
    }
</style>