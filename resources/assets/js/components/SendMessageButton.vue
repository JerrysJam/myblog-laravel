<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <button
                class="btn btn-default pull-right"
                style="margin-top: -36px"
                @click="ShowSendMessageForm"
        >发送私信</button>
        <!-- Access Token Modal -->
        <div class="modal fade" id="ShowSendMessageForm" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">
                            发送私信
                        </h4>
                    </div>
                    <div class="modal-body">
                        <textarea name="body" cols="30" rows="10" class="form-control" v-model="body" v-if="!status"></textarea>
                        <div class="alert alert-success" v-if="status">
                            <strong>发送成功</strong>
                        </div>
                    </div>
                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="store">
                            发送私信
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
            'user'
        ],
        data(){
            return {
                body : '',
                status : false
            }
        },
        methods:{
            store(){
                axios.post('/api/message/store',{'user':this.user, 'body':this.body}).then(response=>{
                    console.log(response.data);
                    this.status = response.data.status;
                    this.body = '';
                    setTimeout(function(){
                        $('#ShowSendMessageForm').modal('hide');
                    },2000);
                })
            },
            ShowSendMessageForm(){
                $('#ShowSendMessageForm').modal('show');
            }
        },
    }

</script>
