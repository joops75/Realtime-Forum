<template>
    <v-dialog
        v-model="dialog"
        fullscreen
        hide-overlay
    >
        <v-card>
            <v-container>
                <v-card color="blue-grey darken-2" class="white--text">
                    <v-card-title>
                        <div>
                            <div class="headline">
                                {{ question.title }}
                            </div>
                            <span class="grey--text">Posted by {{ question.username }} {{ question.created_at }}</span>
                        </div>
                    </v-card-title>

                    <v-card-text v-html="getMd(question.body)"></v-card-text>
                </v-card>

                <v-card-title>
                    <div class="headline">{{ mode }} Reply</div>
                </v-card-title>

                <v-form @submit.prevent="handleSubmit">
                    <vue-simplemde v-model="reply.body" />
                    
                    <v-card-actions>
                        <v-btn icon type="submit">
                            <v-icon color="teal">save</v-icon>
                        </v-btn>
                        
                        <v-btn icon @click="dialog = false">
                            <v-icon>cancel</v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data() {
        return {
            question: { body: '' },
            reply: {},
            replyIndex: null,
            dialog: false,
            mode: 'Create'
        }
    },
    created() {
        EventBus.$on('showReplyModal', ({ question, reply, replyIndex }) => {
            this.question = question || { body: '' };
            this.reply = reply || { body: '' };
            this.replyIndex = replyIndex === undefined ? null : replyIndex;
            this.mode = reply ? 'Edit' : 'Create';
            this.dialog = true;
        })
    },
    methods: {
        handleSubmit() {
            axios({
                method: this.mode === 'Create' ? 'post' : 'put',
                url: this.mode === 'Create' ? `/api/question/${this.question.slug}/reply` : `/api/question/${this.question.slug}/reply/${this.reply.id}`,
                data: this.reply
            })
                .then(res => {
                    this.dialog = false;
                    if (this.mode === 'Create') {
                        EventBus.$emit('newReply', { reply: res.data });
                    } else {
                        EventBus.$emit('editedReply', { reply: res.data, index: this.replyIndex });
                    }
                })
                .catch(err => console.log(err.response));
        },
        getMd(text) {
            return md.parse(text);
        }
    }
}
</script>