<template>
    <div>
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item><a href="/sites">酷站列表</a></el-breadcrumb-item>
            <el-breadcrumb-item>新增酷站</el-breadcrumb-item>
        </el-breadcrumb>
        <hr>
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">

            <el-form-item label="所属分类">
                <el-select prop="site_node_id" filterable placeholder="请选择" size="medium" v-model="ruleForm.site_node_id">
                    <el-option
                            v-for="item in site_nodes"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>


            <el-form-item label="酷站名称" prop="name">
                <el-input v-model="ruleForm.name"></el-input>
            </el-form-item>

            <el-form-item label="缩略图" prop="photo_id">
                <el-upload
                        class="avatar-uploader"
                        action="/photos"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload">
                    <img v-if="imageUrl" :src="imageUrl" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
            </el-form-item>

            <el-form-item label="是否显示" prop="is_show">
                <el-switch v-model="ruleForm.is_show"></el-switch>
            </el-form-item>

            <el-form-item label="酷站地址" prop="url">
                <el-input v-model="ruleForm.url"></el-input>
            </el-form-item>

            <el-form-item label="简单描述" prop="desc">
                <el-input type="textarea" v-model="ruleForm.desc"></el-input>
            </el-form-item>

            <el-form-item label="排序" prop="sort">
                <el-input-number v-model="ruleForm.sort" @change="handleChange" :min="1" :max="99" label="描述文字">
                </el-input-number>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
                <el-button @click="resetForm('ruleForm')">重置</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                site_nodes:[],     //分类
                imageUrl:'',
                ruleForm: {
                    site_node_id:'',
                    name: '',
                    photo_id:'',
                    desc: '',
                    is_show: true,
                    url:'',
                    sort:'',
                },
                rules: {
                    name: [
                        { required: true, message: '请输入酷站名称', trigger: 'blur' },
                    ],
                    url: [
                        {required: true, message: '请填写酷站地址'},
                    ],
                    desc: [
                        { required: true, message: '请填写简单描述', trigger: 'blur' }
                    ]
                }
            };
        },
        created(){
            this.init()
        },
        methods: {
            /** 查分类*/
            init() {
                axios.get(`/admin/site_nodes`).then((res) => {
                    //console.log(res);return;
                    this.site_nodes = res.data.site_nodes
                })
            },
            /** 上传图片*/
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG) {
                    this.$message.error('上传头像图片只能是 JPG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            },
            handleAvatarSuccess(res, file) {
                this.imageUrl = res.image_url;
                this.ruleForm.photo_id = res.photo_id;
            },
            /**计数器*/
            handleChange(value) {
                //console.log(value);
            },
            /** 表单验证*/
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.post(`/admin/site`, this.ruleForm).then((res) => {
                            //提示消息
                            this.$notify({
                                title: '成功',
                                message: '新增成功',
                                type: 'success'
                            });
                            this.$router.push({name: 'site'})
                        })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            }
        }
    }
</script>
<style>
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>
