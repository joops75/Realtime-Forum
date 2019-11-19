<template>
    <v-container fluid v-if="replies.length">
        <h1>Replies</h1>
        <v-card class="mt-2" v-for="(reply, index) in replies" :key="reply.id">
                <v-card-title class="grey--text">
                    <div>Posted by {{ reply.username }} {{ reply.created_at }}</div>

                    <v-spacer />

                    <Like :reply="reply" />
                </v-card-title>

                <v-divider />

                <v-card-text v-html="body(reply.body)" />

                <div v-if="canEdit(reply.user_id)">
                    <v-divider />

                    <v-card-actions>
                        <v-btn icon @click="showReplyModal(reply, index)">
                            <v-icon color="orange">edit</v-icon>
                        </v-btn>

                        <v-btn icon @click="destroy(reply.id, index)">
                            <v-icon color="red">delete</v-icon>
                        </v-btn>
                    </v-card-actions>
                </div>
        </v-card>
    </v-container>
</template>

<script>
import Like from '../like/Like';

export default {
    components: { Like },
    props: ['question', 'replyCount'],
    data() {
        return {
            replies: []
        }
    },
    created() {
        EventBus.$on('newReply', ({ reply }) => {
            this.replies.unshift(reply);
        });

        EventBus.$on('editedReply', ({ reply, index }) => {
            this.replies.splice(index, 1, reply);
        });
            
        Echo.channel('addReplyChannel')
            .listen('AddReplyEvent', e => {
                if (this.question.id == e.question_id) {
                    this.replies.unshift(e.reply);
                }
            });
            
        Echo.channel('editReplyChannel')
            .listen('EditReplyEvent', e => {
                for (let i = 0; i < this.replies.length; i++) {
                    if (this.replies[i].id == e.reply.id) {
                        // this.replies[i] = e.reply; // cannot use this method as it is not reactive (no Vue update occurs)
                        this.replies.splice(i, 1, e.reply);
                    }
                }
            });
            
        Echo.channel('deleteReplyChannel')
            .listen('DeleteReplyEvent', e => {
                for (let i = 0; i < this.replies.length; i++) {
                    if (this.replies[i].id == e.id) {
                        this.replies.splice(i, 1);
                        break;
                    }
                }
            });

        if (!this.replyCount) {
            return;
        }

        axios.get(`/api/question/${this.question.slug}/reply`)
            .then(res => this.replies = res.data.data)
            .catch(err => Exception.handle(err));
    },
    methods: {
        body(text) {
            return md.parse(text);
        },
        canEdit(UserId) {
            return User.userIsOwner(UserId);
        },
        showReplyModal(reply, replyIndex) {
            EventBus.$emit('showReplyModal', { question: this.question, reply, replyIndex });
        },
        destroy(replyId, replyIndex) {
            axios.delete(`/api/question/${this.question.slug}/reply/${replyId}`)
                .then(res => {
                    this.replies.splice(replyIndex, 1);
                    EventBus.$emit('replyDeleted');
                })
                .catch(err => Exception.handle(err));
        }
    }
}
</script>