<template>
    <div>
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item><a href="/advert">广告列表</a></el-breadcrumb-item>
            <el-breadcrumb-item>新增广告</el-breadcrumb-item>
        </el-breadcrumb>
        <hr>
        <el-form :model="advert" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">

            <el-form-item label="所属分类">
                <el-select prop="advert_node_id" filterable placeholder="请选择" size="medium" v-model="advert.advert_node_id">
                    <el-option
                            v-for="item in advert_nodes"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>


            <el-form-item label="广告名称" prop="name">
                <el-input v-model="advert.name"></el-input>
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

            <el-form-item label="广告地址" prop="url">
                <el-input v-model="advert.url"></el-input>
            </el-form-item>

            <el-form-item label="简单描述" prop="desc">
                <el-input type="textarea" v-model="advert.desc"></el-input>
            </el-form-item>

            <el-form-item label="排序" prop="sort">
                <el-input-number v-model="advert.sort" @change="handleChange" :min="1" :max="99" label="描述文字">
                </el-input-number>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm')">保存修改</el-button>
                <el-button @click="resetForm('ruleForm')">重置</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                advert_nodes:[],     //分类
                imageUrl:'',
                advert: {
                    advert_node_id:'',
                    name: '',
                    photo_id:'',
                    desc: '',
                    url:'',
                    sort:'',
                },
                rules: {
                    name: [
                        { required: true, message: '请输入广告名称', trigger: 'blur' },
                    ],
                    url: [
                        {required: true, message: '请填写广告地址'},
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
                let id = this.$route.params.id
                axios.get(`/admin/advert/${id}/edit`).then((res) => {
                    //console.log(res);return;
                    this.advert = res.data
                    this.imageUrl =res.data.photo.image
                })
                axios.get(`/admin/advert_nodes`).then((res) => {
                    //console.log(res);return;
                    this.advert_nodes = res.data.advert_nodes
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
                //console.log(file);return;
                this.imageUrl = file.response.image_url;
                this.advert.photo_id = file.response.photo_id;
            },
            /**计数器*/
            handleChange(value) {
                //console.log(value);
            },
            /** 表单验证*/
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        //console.log(this.advert);return ;
                        axios.put(`/admin/advert/${this.advert.id}`, this.advert).then((res) => {
                            //提示消息
                            this.$notify({
                                title: '成功',
                                message: '编辑成功',
                                type: 'success'
                            });
                            this.$router.push({name: 'advert'})
                            //console.log(res);
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
