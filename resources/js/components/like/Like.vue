<template>
    <div>
        <v-btn icon @click="likeIt">
            <v-icon :color="color">favorite</v-icon>
            {{ likes }}
        </v-btn>
    </div>
</template>

<script>
export default {
    props: ['reply'],
    data() {
        return {
            likes: this.reply.like_count,
            liked: this.reply.liked,
            submittingLike: false
        }
    },
    created() {
        Echo.channel('likeChannel')
            .listen('LikeEvent', e => {
                if (this.reply.id === e.id) {
                    e.type === 1 ? this.likes ++ : this.likes --;
                }
            });
    },
    methods: {
        likeIt() {
            if (User.loggedIn() && !this.submittingLike) {
                this.submittingLike = true;
                this.liked ? this.removeLike() : this.addLike();
            }
        },
        removeLike() {
            axios.delete(`/api/like/${this.reply.id}`)
                .then(res => {
                    this.likes --;
                    this.liked = false;
                })
                .catch(err => console.log(err.response.data))
                .finally(() => this.submittingLike = false);
        },
        addLike() {
            axios.post(`/api/like/${this.reply.id}`)
                .then(res => {
                    this.likes ++;
                    this.liked = true;
                })
                .catch(err => console.log(err.response.data))
                .finally(() => this.submittingLike = false);
        }
    },
    computed: {
        color() {
            return this.liked ? 'red' : 'red lighten-4';
        }
    }
}
</script>