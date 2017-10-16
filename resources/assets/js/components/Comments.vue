<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <a
                class="btn is-naked delete-button"
                @click="ShowCommentForm"
                v-text="text"
        ></a>
        <!-- Access Token Modal -->
        <div class="modal fade" :id=dialog tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">
                            评论列表
                        </h4>
                    </div>
                    <div class="modal-body">
                        {{ comments.length }}个评论
                        <div v-if="comments.length > 0">
                            <div class="media"  v-for="comment in comments">
                                <div class="media-left">
                                    <a href="">
                                        <img class="media-object img-circle" width="30" height="30" :src="comment.user.avatar">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">{{ comment.user.name }}</h4>
                                    {{ comment.body }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <input type="text" class="form-control" v-model="body" />
                        <button type="button" class="btn btn-primary" @click="store">
                            评论
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:[
            'type','model','count'
        ],
        data(){
            return {
                body :'',
                comments : [],
                total : this.count
            }
        },
        computed:{
            dialog() {
                return 'comments-dialog-' + this.type + '-' + this.model
            },
            dialogId() {
                return '#' + this.dialog
            },
            text() {
                return this.total + '个评论'
            }
        },
        methods:{
            store(){
                axios.post('/api/comment',{'type':this.type,'model':this.model,'body':this.body}).then(response => {
                    console.log(response.data);
                    let comment = {
                        user:{
                            name : Zhihu.name,
                            avatar : Zhihu.avatar
                        },
                        body: response.data.body
                    }
                    this.comments.push(comment)
                    this.body = ''
                    this.total ++
                })
            },
            ShowCommentForm(){
                this.getComments()
                $(this.dialogId).modal('show')
            },
            getComments(){
                axios.get('/api/' + this.type +'/' + this.model + '/comments').then(response => {
                    console.log(response.data);
                    this.comments = response.data;
                })
            }
        }
    }

</script>
