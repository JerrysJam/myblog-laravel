<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <button
            class="btn btn-default"
            v-bind:class="{ 'btn-primary' : voted}"
            v-text="text"
            v-on:click="Voted"
    ></button>
</template>

<script>
    export default {
        props:[
            'answer','count'
        ],
        mounted(){
        axios.get('/api/answer/'+ this.answer + '/votes/users' ).then(response=>{
            console.log(response.data);
            this.voted = response.data.voted;
        })
    },
    data(){
        return {
            voted: false
        }
    },
    computed:{
        text(){
            return this.count;
        }
    },
    methods:{
        Voted(){
            axios.post('/api/answer/vote',{'answer':this.answer}).then(response=>{
                console.log(response.data);
                this.voted = response.data.voted;
                response.data.voted ? this.count ++ : this.count --;
            })
        }
    },
    }

</script>
