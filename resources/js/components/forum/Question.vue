<template>
    <v-card v-if="question">
        <v-container fluid>
            <v-card-title>
                <div>
                    <div class="headline">
                        {{ question.title }}
                    </div>
                    <span class="grey--text">Posted by {{ question.username }} {{ question.created_at }}</span>
                </div>

                <v-spacer></v-spacer>

                <v-btn color="teal">5 replies</v-btn>
            </v-card-title>

            <v-card-text v-html="body"></v-card-text>

            <v-card-actions v-if="canEdit">
                <v-btn icon>
                    <v-icon color="orange">edit</v-icon>
                </v-btn>
                <v-btn icon @click="destroy">
                    <v-icon color="red">delete</v-icon>
                </v-btn>
            </v-card-actions>
        </v-container>
    </v-card>
</template>

<script>
export default {
    data() {
        return {
            question: null
        }
    },
    created() {
        axios.get(`/api/question/${this.$route.params.slug}`)
            .then(res => {
                this.question = res.data.data;
            })
            .catch(err => console.log(err.response.data));
    },
    computed: {
        body() {
            return md.parse(this.question.body);
        },
        canEdit() {
            return User.userIsOwner(this.question.user_id);
        }
    },
    methods: {
        destroy() {
            axios.delete(`/api/question/${this.question.slug}`)
                .then(() => this.$router.push('/forum'))
                .catch(err => console.log(err.response.data));
        }
    }
}
</script>