<template>
<h3>配置信息</h3>
<p>服务端地址: <input type="text" v-model="remoteAddress"></p>
<p>存储文件夹: <input type="text" v-model="remoteDir" > </p>
<p>查询文件夹: <input type="text" v-model="queryDir"></p>
<p>查看文件夹: <input type="text" v-model="seeDir"></p>
<button @click="saveSetting">更改</button>
<hr>
<h3>上传图片</h3>
<input type="file" accept="image/*" @change="onFileChange">
<button @click="uploadImage">上传</button>
<div v-if="uploadStatus">{{ uploadStatus }}</div>
<hr>
<h3>查看图片</h3>
<img :src="imgUrl()" v-if="nowSee">
<hr>
<h3>图片列表</h3>
<button @click="getFiles">刷新</button>
<div v-if="getFilesStatus">状态: {{ getFilesStatus }}</div>
<div v-for="item in files">{{ item }}<button @click="seePic(item)">选择</button> </div>
</template>

<script setup>
import axios  from "axios";
import {ref} from 'vue';
const remoteAddress=ref(localStorage.getItem('remoteAddress'))
const remoteDir=ref(localStorage.getItem('remoteDir'))
const queryDir=ref(localStorage.getItem('queryDir'))
const getFilesStatus=ref(null);
const files=ref([])
const nowSee=ref(null);
const seeDir=ref(localStorage.getItem('seeDir'))
const file = ref(null);
const uploadStatus =ref(null);
const onFileChange=(e)=>{
    file.value=e.target.files[0]
}
const uploadImage = ()=>{
    if (!file.value) {
        uploadStatus.value='无法上传空文件'
        return
    }
    const formData=new FormData()
    formData.append('fileToUpload',file.value)
    formData.append('uploadDir',remoteDir.value)
    axios.post(remoteAddress.value+'/upload.php',formData,{
        headers:{
            'Content-Type':'multipart/form-data'
        }
    }).then(response=>{
        uploadStatus.value=response.data.message
    }).catch(error=>{
        uploadStatus.value="上传失败"+error.message
    })
}
const getFiles=()=>{
    
    axios.post(remoteAddress.value+'/getFiles.php',{'queryDir':queryDir.value},{headers:{'Content-Type':'application/json'}}).then(response=>{
        getFilesStatus.value=response.data.status
        if(response.data.status=='success'){
            files.value=response.data.files
        }
    }).catch(error=>{
        getFilesStatus.value='获取文件失败: '+error.message
    })
}
const saveSetting=()=>{
    localStorage.setItem('remoteDir',remoteDir.value)
    localStorage.setItem('remoteAddress',remoteAddress.value)
    localStorage.setItem('queryDir',queryDir.value)
    localStorage.setItem('seeDir',seeDir.value)
}
const seePic=(item)=>{
    nowSee.value=item
    console.log(item)
}
const imgUrl=()=>{
    return remoteAddress.value+'/'+seeDir.value+'/'+nowSee.value
}
</script>

<style scoped>

</style>