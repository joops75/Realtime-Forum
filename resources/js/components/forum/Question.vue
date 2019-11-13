<template>
    <div v-if="question">
        <v-card>
            <v-container fluid>
                <v-card-title>
                    <div>
                        <div class="headline">
                            {{ question.title }}
                        </div>
                        <span class="grey--text">Posted by {{ question.username }} {{ question.created_at }}</span>
                    </div>

                    <v-spacer />

                    <v-card color="teal">
                        <v-card-text class="font-weight-bold white--text">{{ question.reply_count }} replies</v-card-text>
                    </v-card>
                </v-card-title>

                <v-card-text v-html="body"></v-card-text>

                <v-card-actions>
                    <v-btn v-if="loggedIn" color="green" @click="showReplyModal">Reply</v-btn>
                    <v-btn v-if="canEdit" icon @click="showQuestionModal">
                        <v-icon color="orange">edit</v-icon>
                    </v-btn>
                    <v-btn v-if="canEdit" icon @click="destroy">
                        <v-icon color="red">delete</v-icon>
                    </v-btn>
                </v-card-actions>
            </v-container>
        </v-card>

        <v-spacer />

        <Replies :question="question" :replyCount="question.reply_count" />

        <CreateEditReply />
    </div>
</template>

<script>
import Replies from '../reply/Replies';
import CreateEditReply from '../modal/CreateEditReply';

export default {
    components: { Replies, CreateEditReply },
    data() {
        return {
            question: null
        }
    },
    created() {
        axios.get(`/api/question/${this.$route.params.slug}`)
            .then(res => this.question = res.data.data)
            .catch(err => console.log(err.response.data));
    },
    computed: {
        body() {
            return md.parse(this.question.body);
        },
        canEdit() {
            return User.userIsOwner(this.question.user_id);
        },
        loggedIn() {
            return User.loggedIn();
        }
    },
    methods: {
        destroy() {
            axios.delete(`/api/question/${this.question.slug}`)
                .then(() => this.$router.push('/forum'))
                .catch(err => console.log(err.response.data));
        },
        showQuestionModal() {
            EventBus.$emit('showQuestionModal', this.question);
        },
        showReplyModal() {
            EventBus.$emit('showReplyModal', { question: this.question });
        }
    }
}
</script>