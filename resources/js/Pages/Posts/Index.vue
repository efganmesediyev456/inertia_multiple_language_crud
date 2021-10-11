<template>
        <app-header></app-header>

        <div class="row">
            <div class="col-md-12" style="margin-top: 20px">
                <h2 class="text-left">All Posts</h2>

                <errors-and-messages :errors="errors"></errors-and-messages>

                <div v-if="posts.data.length > 0">

                    <div class="col-md-10 article" v-for="post in posts.data" :key="post.id">
                       
                        <h4>{{post.tit}}</h4>
                        <img v-if="post.image_url" width="300" height="250" :src="post.image_url" class="pull-left img-responsive thumb margin10 img-thumbnail">
                        <article>
                            <p>
                                {{ post.cont }}
                            </p>
                        </article>
                        <inertia-link :href="$route('post.edit', {id: post.id})" class="btn btn-primary pull-right action-btn">Edit Post</inertia-link>
                        <a href="javascript:void(0);" class="btn btn-warning pull-right action-btn" @click.prevent="deletePost(post.id)"><i class="fas fa-trash-alt"></i> Delete Post</a>
                    </div>

                    <!-- Pagination links-->
                    <nav aria-label="Page navigation" v-if="posts.total > posts.per_page" style="margin-top: 20px">
                        <ul class="pagination">
                            <!-- Previous link -->
                            <li :class="'page-item' + (posts.links[0].url == null ? ' disabled' : '')">
                                <inertia-link :href="posts.links[0].url == null ? '#' : posts.links[0].url" class="page-link" v-html="posts.links[0].label"></inertia-link>
                            </li>

                            <!-- Numbers -->
                            <li v-for="item in numberLinks" :class="'page-item' + (item.active ? ' disabled' : '')">
                                <inertia-link :href="item.active ? '#' : item.url" class="page-link" v-html="item.label"></inertia-link>
                            </li>

                            <!-- Next link -->
                            <li :class="'page-item' + (posts.links[posts.links.length - 1].url == null ? ' disabled' : '')">
                                <inertia-link :href="posts.links[posts.links.length - 1].url == null ? '#' : posts.links[posts.links.length - 1].url" class="page-link" v-html="posts.links[posts.links.length - 1].label"></inertia-link>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="text-center" v-else>
                    No posts found! <inertia-link :href="$route('post.create')">Create Post</inertia-link>
                </div>
            </div>
        </div>

</template>

<script>
import AppHeader from "../../Partials/AppHeader";
import ErrorsAndMessages from "../../Partials/ErrorsAndMessages";
import {usePage} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import {computed, inject} from "vue";

export default {
    name: "Posts",
    components: {
        ErrorsAndMessages,
        AppHeader
    },
    props: {
        errors: Object
    },
    setup() {
        const route = inject('$route');

        const deletePost = (id) => {
            if (!confirm('Are you sure?')) return;
            Inertia.delete(route('post.destroy', {id}));
        }

        const posts = computed(() => usePage().props.value.posts);

        const numberLinks = posts.value.links.filter((v, i) => i > 0 && i < posts.value.links.length - 1);

        return {
            posts,
            deletePost,
            numberLinks
        }
    }
}
</script>

<style scoped>
    .action-btn {
        margin-left: 12px;
        font-size: 13px;
    }

    .article {
        margin-top: 20px;
    }

</style>