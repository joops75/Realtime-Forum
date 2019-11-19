<template>
    <div>
        <v-card class="mt-2" v-for="question in questions" :key="question.title">
            <v-card-title primary-title>
                <div>
                    <h3 class="headline mb-0">
                        <router-link :to="question.path">
                            {{ question.title }}
                        </router-link>
                    </h3>
                    <div class="grey--text">Posted by {{ question.username }} {{ question.created_at }}</div>
                </div>

                <v-spacer></v-spacer>

                <v-card color="teal">
                        <v-card-text class="font-weight-bold white--text">{{ question.reply_count }} replies</v-card-text>
                    </v-card>
            </v-card-title>

            <v-card-text>{{ question.body }}</v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            questions: []
        }
    },
    created() {
        axios.get('/api/question')
            .then(res => {
                this.questions = res.data.data;
            })
            .catch(err => Exception.handle(err));
    }
}
</script>